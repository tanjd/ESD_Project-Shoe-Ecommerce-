from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ

app = Flask(__name__)
#app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
# app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/product_db'
#app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///product_db.db'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:////product_db.db'

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


    def json(self):
        return {"id": self.id, "image": self.image, "name": self.name, "category_id": self.category_id, "description": self.description,
                "unit_price": self.unit_price, "quantity": self.quantity}


class Category(db.Model):
    __tablename__ = 'category'
    id = db.Column(db.Integer, primary_key=True, nullable=False)
    name = db.Column(db.String(120), primary_key=True)

    
    products = db.relationship(
        'Product', backref='products', lazy=True)

    def __init__(self, id, name):
        self.id = id
        self.name = name

    def json(self):
        return {"id": self.id, "name": self.name}


# [GET] all products
@app.route("/get_all_products")
def get_all_products():
    products = [Product.json()
                for Product in Product.query.all()]
    if products:
        return_message = ({"status": "success",
                           "products": products})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)

# [GET] all categories
@app.route("/get_all_categories")
def get_all_categories():
    categories = [Category.json()
                  for Category in Category.query.all()]
    if categories:
        return_message = ({"status": "success",
                           "categories": categories})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


@app.route("/get_products_by_category/")
def get_products_by_id():
    category_id = request.args.get('category_id')
    products = [Product.json()
                for Product in Product.query.filter_by(category_id=category_id).all()]
    if products:
        return_message = ({"status": "success",
                           "products": products})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


@app.route("/get_category/", methods=['GET'])
def get_category():
    category_id = request.args.get('category_id')
    category = Category.query.filter_by(id=category_id).first()
    if category:
        return_message = ({"status": "success",
                           "category": category.json()})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


@app.route('/get_product/', methods=['GET'])
def get_product():
    product_id = request.args.get('product_id')
    product = Product.query.filter_by(id=product_id).first()
    if product:
        return_message = ({"status": "success",
                           "product": product.json()})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5001, debug=True)
