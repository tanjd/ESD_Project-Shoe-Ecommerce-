from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ

app = Flask(__name__)
#app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
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

    def __init__(self, id, email, name, telegram_id, password, address, email_setting, telegram_setting, created_at):
        self.id = id
        self.email = email
        self.name = name
        self.telegram_id = telegram_id
        self.password = password
        self.address = address
        self.email_setting = email_setting
        self.telegram_setting = telegram_setting
        self.created_at = created_at

    def json(self):
        return {"id": self.id, "email": self.email, "name": self.name, "telegram_id": self.telegram_id, "password": self.password,
                "address": self.address, "email_setting": self.email_setting, "telegram_setting": self.telegram_setting, "created_at": self.created_at}


class Subscription(db.Model):
    customer_id = db.Column(db.Integer, db.ForeignKey(
        'customer.id'), primary_key=True, nullable=False)
    category_id = db.Column(db.Integer, primary_key=True)

    def __init__(self, customer_id, category_id):
        self.customer_id = customer_id
        self.category_id = category_id

    def json(self):
        return {"customer_id": self.customer_id, "category_id": self.category_id}


@app.route('/')
def home():
    # return config.myname
    # return 'Hello, Flask!'
    return jsonify({"customer": [Customer.json() for Customer in Customer.query.all()]})


if __name__ == "__main__":
    app.run(port=5000, debug=True)
