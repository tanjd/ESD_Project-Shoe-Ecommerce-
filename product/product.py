from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ

app = Flask(__name__)
#app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/product_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)


class Product(db.Model):
    __tablename__ = 'product'
    id = db.Column(db.Integer, primary_key=True)
    image = db.Column(db.String(120), nullable=False)
    name = db.Column(db.String(120), nullable=False)
    category_id = db.Column(db.Integer, db.ForeignKey(
        'category.id'), nullable=False)
    description = db.Column(db.String(1000), nullable=False)
    unit_price = db.Column(db.Float(10), nullable=False)
    quantity = db.Column(db.Integer, nullable=False)


    def __init__(self, id, image, name, category_id, description, unit_price, quantity):
        self.id = id
        self.image = image
        self.name = name
        self.category_id = category_id
        self.description = description
        self.unit_price = unit_price
        self.quantity = quantity


    def json(self):
        return {"id": self.id, "image": self.image, "name": self.name, "category_id": self.category_id, "description": self.description,
                "unit_price": self.unit_price, "quantity": self.quantity}


class Category(db.Model):
    __tablename__ = 'category'
    id = db.Column(db.Integer, primary_key=True, nullable=False)
    name = db.Column(db.String(120), primary_key=True)

    # CHECK AGAIN
    products = db.relationship(
        'Product', backref='products', lazy=True)

    def __init__(self, id, name):
        self.id = id
        self.name = name

    def json(self):
        return {"id": self.id, "name": self.name}


@app.route("/product")
def get_all(): 
    # translates to select * from product 
    return jsonify({"products": [product.json() for product in Product.query.all()]})


if __name__ == "__main__":
    app.run(port=5000, debug=True)
