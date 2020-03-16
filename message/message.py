from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ
import json
import requests


app = Flask(__name__)
# app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/message_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)

customerURL = "http://localhost:5000/"


class Inbox(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    content_message = db.Column(db.String(120), nullable=True)
    customer_id = db.Column(db.Integer, primary_key=True)
    created_at = db.Column(
        db.DateTime, server_default=func.now(), nullable=False)

    inbox_messages = db.relationship(
        'Message', backref='inbox_message', lazy=True)

    def json(self):
        return {"id": self.id, "content_message": self.content_message, "customer_id": self.customer_id, "created_at": self.created_at}


class Message(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    inbox_id = db.Column(db.Integer, db.ForeignKey(
        'inbox.id'), primary_key=True, nullable=False)
    content_message = db.Column(db.String(120), nullable=True)
    created_at = db.Column(
        db.DateTime, server_default=func.now(), nullable=False)

    def json(self):
        return {"id": self.id, "inbox_id": self.inbox_id, "content_message": self.content_message, "created_at": self.created_at}


@app.route('/')
def home():
    return 'Hello, message microservice is up!'


@app.route('/send_message_by_category', methods=['POST'])
def send_message():
    data = request.get_json()
    category_id = data['category_id']
    # message_content = data['message']

    GET_data = {
        'category_id': category_id
    }
    subscriber_data = requests.get(
        customerURL + 'get_customer_ids_by_cat', params=GET_data)
    subscriber_data = subscriber_data.json()

    if subscriber_data['status'] == 'success':
        for subscriber in subscriber_data['subscribers']:
            customer_id = subscriber['customer_id']
            inbox = Inbox.query.filter_by(customer_id=customer_id).first()
            try:
                message = Message()
                message.inbox_id = inbox.id
                message.content_message = message_content
                db.session.add(message)
                db.session.commit()
            except:
                return jsonify({"status": "fail",
                                "message": "An error occurred in sending message."})
        return jsonify({"status": "success"})
    else:
        return jsonify({"status": "fail",
                        "message": "An error occurred in sending message."})
    return subscriber_data


@app.route('/broadcast_message', methods=['POST'])
def broadcast_message():
    msg_data = request.get_json()
    try:
        message = Message(**msg_data)
        db.session.add(message)
        db.session.commit()
    except:
        return jsonify({"status": "fail",
                        "message": "An error occurred in sending message."})
    return jsonify({"status": "success"})

# @app.route('/authenticate', methods=['POST'])
# def authenticate():
#     customer_data = request.get_json()
#     email = customer_data['email']
#     password = customer_data['password']
#     customer = Customer.query.filter_by(email=email).first()
#     if customer:
#         if password == customer.password:
#             return_message = ({"status": "success",
#                                "customer_id": customer.id})
#         else:
#             return_message = ({"status": "fail",
#                                "message": "Invalid Password"})
#     else:
#         return_message = ({"status": "fail",
#                            "message": "Invalid Email"})
#     return jsonify(return_message)


# @app.route('/fb_login', methods=['POST'])
# def fb_login():
#     fb_data = request.get_json()
#     email = fb_data['email']
#     customer = Customer.query.filter_by(email=email).first()
#     if customer:
#         return_message = ({"status": "success",
#                            "customer_id": customer.id})
#     else:
#         fb_data['password'] = 'password'
#         try:
#             cust = Customer(**fb_data)
#             db.session.add(cust)
#             db.session.commit()
#         except:
#             return jsonify({"status": "fail",
#                             "message": "An error occurred creating customer."})
#         customer = Customer.query.filter_by(email=email).first()
#         if customer:
#             return_message = ({"status": "success",
#                                "customer_id": customer.id})
#         else:
#             return_message = ({"status": "fail",
#                                "message": "Invalid Email"})
#     return jsonify(return_message)


# @app.route('/get_all_customers', methods=['GET'])
# def get_all_customers():
#     customers = [Customer.json()
#                  for Customer in Customer.query.all()]
#     if customers:
#         return_message = ({"status": "success",
#                            "customers": customers})
#     else:
#         return_message = ({"status": "fail"})
#     return jsonify(return_message)


# @app.route('/get_customer/', methods=['GET'])
# def get_customer():
#     customer_id = request.args.get('customer_id')
#     customer = Customer.query.filter_by(id=customer_id).first()
#     if customer:
#         return_message = ({"status": "success",
#                            "customer": customer.json()})
#     else:
#         return_message = ({"status": "fail"})
#     return jsonify(return_message)


# @app.route('/update_setting', methods=['POST'])
# def update_setting():
#     setting_data = request.get_json()
#     customer_id = setting_data['customer_id']
#     customer = Customer.query.filter_by(id=customer_id).first()
#     customer.telegram_id = setting_data['telegram_id']
#     customer.email_setting = setting_data['email_setting']
#     customer.telegram_setting = setting_data['telegram_setting']
#     customer.address = setting_data['address']
#     customer.postal_code = setting_data['postal_code']
#     try:
#         db.session.commit()
#         # admin = User.query.filter_by(username='admin').update(dict(email='my_new_email@example.com')))
#         # db.session.commit()
#     except:
#         return jsonify({"status": "fail",
#                         "message": "An error occurred creating customer."})
#     return jsonify({"status": "success"})


# @app.route('/add_subscription', methods=['POST'])
# def add_subscription():
#     sub_data = request.get_json()
#     try:
#         subscription = Subscription(**sub_data)
#         db.session.add(subscription)
#         db.session.commit()
#     except:
#         return jsonify({"status": "fail",
#                         "message": "An error occurred in adding subscription."})
#     return jsonify({"status": "success"})


# @app.route('/remove_subscription', methods=['POST'])
# def remove_subscription():
#     sub_data = request.get_json()
#     customer_id = sub_data['customer_id']
#     category_id = sub_data['category_id']
#     try:
#         Subscription.query.filter(
#             Subscription.customer_id == customer_id, Subscription.category_id == category_id).delete()
#         db.session.commit()
#     except:
#         return jsonify({"status": "fail",
#                         "message": "An error occurred in deleting subscription."})
#     return jsonify({"status": "success"})


# @app.route('/is_subscribed', methods=['POST'])
# def is_subscribed():
#     sub_data = request.get_json()
#     customer_id = sub_data['customer_id']
#     category_id = sub_data['category_id']
#     subscriber = Subscription.query.filter(
#         Subscription.customer_id == customer_id, Subscription.category_id == category_id).first()
#     if subscriber:
#         return_message = ({"status": "success",
#                            "message": True})
#     else:
#         return_message = ({"status": "success",
#                            "message": False})
#     return jsonify(return_message)


# @app.route('/load_customers', methods=['GET'])
# def load_customers():
#     customers = customer_data.customers
#     for customer in customers:
#         try:
#             cust = Customer(**customer)
#             db.session.add(cust)
#             db.session.commit()
#         except:
#             return jsonify({"status": "fail",
#                             "message": "An error occurred creating customer."})
#     return jsonify({"status": "success"})


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5004, debug=True)
