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




# [GET] all products
@app.route("/product")
def get_all(): 
    return jsonify({"product": [product.json() for product in Product.query.all()]})

# # [GET] all categories
# @app.route("/category")
# def get_all(): 
#     return jsonify({"category": [Category.json() for category in Category.query.all()]})

# # [GET] products by category
# @app.route("/product/<string:category_id>")
# def find_by_category_id (category_id): 
#     product = Product.query.filter_by (category_id = category_id)
#     if product: 
#         return jsonify(product.json())
#     return jsonify({"message": "Products not found"}), 404

# # [GET] products by name **NEED TO LOOK INTO THIS
# @app.route("/product/<string:name>")
# def find_by_name (name): 
#     product = Product.query.filter_by (name = name)
#     if product: 
#         return jsonify(product.json())
#     return jsonify({"message": "Products not found"}), 404

# # [POST] create product
# @app.route("/book/<string:id>", methods = ['POST'])
# def create_product(id): 
#     if (Product.query.filter_by (id = id).first()): 
#         return jsonify({"message": "A product with id '{}' already exists.".format(id)}), 400 

#         data = request.get.json()
#         product = Product(id, **data) # get all fields (**)

#         try: 
#             db.session.add(product)
#             db.session.commit()

#         except: 
#             return jsonify({"message": "An error occurred creating the product"}), 500

#         return jsonify(product.json()), 201


if __name__ == "__main__":
    app.run(port=5000, debug=True)
