import customer_data
from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ
import sys

sys.path.insert(1, 'customer')

app = Flask(__name__)
# app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/customer_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)


class Customer(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    email = db.Column(db.String(120), unique=True, nullable=False)
    name = db.Column(db.String(120), nullable=False)
    telegram_id = db.Column(db.String(120), unique=False, nullable=True)
    password = db.Column(db.String(60), nullable=False)
    address = db.Column(db.String(120), nullable=True)
    postal_code = db.Column(db.String(120), nullable=True)
    email_setting = db.Column(db.Boolean, server_default="1", nullable=False)
    telegram_setting = db.Column(
        db.Boolean, server_default="0", nullable=False)
    created_at = db.Column(
        db.DateTime, server_default=func.now(), nullable=False)

    subscriptions = db.relationship(
        'Subscription', backref='subscriber', lazy=True)

    # def __init__(self, id, email, name, telegram_id, password, address, postal_code, email_setting, telegram_setting, created_at):
    #     self.id = id
    #     self.email = email
    #     self.name = name
    #     self.telegram_id = telegram_id
    #     self.password = password
    #     self.address = address
    #     self.postal_code = postal_code
    #     self.email_setting = email_setting
    #     self.telegram_setting = telegram_setting
    #     self.created_at = created_at

    def json(self):
        return {"id": self.id, "email": self.email, "name": self.name, "telegram_id": self.telegram_id, "password": self.password,
                "address": self.address, "postal_code": self.postal_code, "email_setting": self.email_setting, "telegram_setting": self.telegram_setting, "created_at": self.created_at}


class Subscription(db.Model):
    customer_id = db.Column(db.Integer, db.ForeignKey(
        'customer.id'), primary_key=True, nullable=False)
    category_id = db.Column(db.Integer, primary_key=True)

    # def __init__(self, customer_id, category_id):
    #     self.customer_id = customer_id
    #     self.category_id = category_id

    def json(self):
        return {"customer_id": self.customer_id, "category_id": self.category_id}


@app.route('/')
def home():
    # return config.myname
    # return 'Hello, Flask!'
    return jsonify({"customer": [Customer.json() for Customer in Customer.query.all()]})


@app.route('/authenticate', methods=['POST'])
def authenticate():
    customer_data = request.get_json()
    email = customer_data['email']
    password = customer_data['password']
    customer = Customer.query.filter_by(email=email).first()
    if customer:
        if password == customer.password:
            return_message = ({"status": "success",
                               "customer_id": customer.id})
        else:
            return_message = ({"status": "fail",
                               "message": "Invalid Password"})
    else:
        return_message = ({"status": "fail",
                           "message": "Invalid Email"})
    return jsonify(return_message)


@app.route('/fb_login', methods=['POST'])
def fb_login():
    fb_data = request.get_json()
    email = fb_data['email']
    customer = Customer.query.filter_by(email=email).first()
    if customer:
        return_message = ({"status": "success",
                           "customer_id": customer.id})
    else:
        fb_data['password'] = 'password'
        try:
            cust = Customer(**fb_data)
            db.session.add(cust)
            db.session.commit()
        except:
            return jsonify({"status": "fail",
                            "message": "An error occurred creating customer."})
        customer = Customer.query.filter_by(email=email).first()
        if customer:
            return_message = ({"status": "success",
                               "customer_id": customer.id})
        else:
            return_message = ({"status": "fail",
                               "message": "Invalid Email"})
    return jsonify(return_message)


@app.route('/get_all_customers', methods=['GET'])
def get_all_customers():
    customers = [Customer.json()
                 for Customer in Customer.query.all()]
    if customers:
        return_message = ({"status": "success",
                           "customers": customers})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


@app.route('/get_customer/', methods=['GET'])
def get_customer():
    customer_id = request.args.get('customer_id')
    customer = Customer.query.filter_by(id=customer_id).first()
    if customer:
        return_message = ({"status": "success",
                           "customer": customer.json()})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


@app.route('/update_setting', methods=['POST'])
def update_setting():
    setting_data = request.get_json()
    customer_id = setting_data['customer_id']
    customer = Customer.query.filter_by(id=customer_id).first()
    customer.telegram_id = setting_data['telegram_id']
    customer.email_setting = setting_data['email_setting']
    customer.telegram_setting = setting_data['telegram_setting']
    customer.address = setting_data['address']
    customer.postal_code = setting_data['postal_code']
    try:
        db.session.commit()
        # admin = User.query.filter_by(username='admin').update(dict(email='my_new_email@example.com')))
        # db.session.commit()
    except:
        return jsonify({"status": "fail",
                        "message": "An error occurred creating customer."})
    return jsonify({"status": "success"})


@app.route('/add_subscription', methods=['POST'])
def add_subscription():
    sub_data = request.get_json()
    try:
        subscription = Subscription(**sub_data)
        db.session.add(subscription)
        db.session.commit()
    except:
        return jsonify({"status": "fail",
                        "message": "An error occurred in adding subscription."})
    return jsonify({"status": "success"})


@app.route('/remove_subscription', methods=['POST'])
def remove_subscription():
    sub_data = request.get_json()
    customer_id = sub_data['customer_id']
    category_id = sub_data['category_id']
    try:
        Subscription.query.filter(
            Subscription.customer_id == customer_id, Subscription.category_id == category_id).delete()
        db.session.add(subscription)
        db.session.commit()
    except:
        return jsonify({"status": "fail",
                        "message": "An error occurred in adding subscription."})
    return jsonify({"status": "success"})


@app.route('/load_customers', methods=['GET'])
def load_customers():
    customers = customer_data.customers
    for customer in customers:
        try:
            cust = Customer(**customer)
            db.session.add(cust)
            db.session.commit()
        except:
            return jsonify({"status": "fail",
                            "message": "An error occurred creating customer."})
    return jsonify({"status": "success"})


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)
