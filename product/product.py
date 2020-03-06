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


class Product(db.Model):
    product_id = db.Column(db.String(11), primary_key=True)
    product_image = db.Column(db.String(120), nullable=False)
    product_name = db.Column(db.String(120), nullable=False)
    category_id = db.Column(db.String(30), db.ForeignKey(
        'category_id'), nullable=False)
    description = db.Column(db.String(65535), nullable=False)
    unit_price = db.Column(db.Float(10), nullable=False)
    quantity = db.Column(db.Integer(65535), nullable=False)


    def __init__(self, product_id, product_image, product_name, category_id, description, unit_price, quantity):
        self.product_id = product_id
        self.product_image = product_image
        self.product_name = product_name
        self.category_id = category_id
        self.description = description
        self.unit_price = unit_price
        self.quantity = quantity


    def json(self):
        return {"product_id": self.product_id, "product_image": self.product_image, "product_name": self.product_name, "category_id": self.category_id, "description": self.description,
                "unit_price": self.unit_price, "quantity": self.quantity}


class Category(db.Model):
    category_id = db.Column(db.String(30), primary_key=True, nullable=False)
    category_name = db.Column(db.String(120), primary_key=True)

    # CHECK AGAIN
    products = db.relationship(
        'Product', backref='product', lazy=True)

    def __init__(self, category_id, category_name):
        self.category_id = category_id
        self.category_name = category_name

    def json(self):
        return {"category_id": self.category_id, "category_name": self.category_name}


@app.route('/')
def home():
    # return config.myname
    # return 'Hello, Flask!'
    return jsonify({"product": [Product.json() for Product in Product.query.all()]})


if __name__ == "__main__":
    app.run(port=5000, debug=True)
