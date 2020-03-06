from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ

app = Flask(__name__)
#app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/order_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)


class Order(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    customer_id = db.Column(db.Integer, nullable=False)
    product_id = db.Column(db.String(120), nullable=False, primary_key=True)
    quantity = db.Column(db.Integer, nullable=False)
    price = db.Column(db.Float(6,2),nullable=False)
    timestamp = db.Column(
        db.DateTime, server_default=func.now(), nullable=False)


    def __init__(self, id, customer_id, product_id, quantity, price, timestamp):
        self.id = id
        self.customer_id = customer_id
        self.product_id = product_id
        self.quantity = quantity
        self.price = price
        self.timestamp = timestamp

    def json(self):
        return {"id": self.id, "customer_id": self.customer_id, "product_id": self.product_id, "quantity": self.quantity, "price": self.price,
                "timestamp": self.timestamp}


class Order_invoice(db.Model):
    id = db.Column(db.Integer,primary_key=True)
    total_amount = db.Column(db.Integer, nullable=False)
    customer_id = db.Column(db.Integer, nullable=False)

    Orders = db.relationship('Order',backref='orders',lazy=True)

    def __init__(self, id, total_amount, customer_id):
        self.id = id
        self.customer_id = customer_id
        self.total_amount = total_amount

    def json(self):
        return {"id": self.id, "customer_id": self.customer_id, "total_amount": self.total_amount}





@app.route('/')
def home():
    # return config.myname
    return 'Hello, Flask!'
    #return jsonify({"customer": [Customer.json() for Customer in Customer.query.all()]})


if __name__ == "__main__":
    app.run(port=5000, debug=True)
