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

class Order_invoice(db.Model):
    id = db.Column(db.Integer,primary_key=True)
    total_amount = db.Column(db.Integer, nullable=False)
    customer_id = db.Column(db.Integer, nullable=False)

    Orders = db.relationship('Order',backref='orders',lazy=True)

    def init(self, id, total_amount, customer_id):
        self.id = id
        self.customer_id = customer_id
        self.total_amount = total_amount
    
    def json(self):
         return {"id": self.id, "customer_id": self.customer_id, "total_amount": self.total_amount}

class Order(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    invoice_id = db.Column(db.Integer, db.ForeignKey('order_invoice.id'), nullable = False , primary_key = True)
    customer_id = db.Column(db.Integer, nullable=False)
    product_id = db.Column(db.String(120), nullable=False)
    quantity = db.Column(db.Integer, nullable=False)
    price = db.Column(db.Float(6,2),nullable=False)
    timestamp = db.Column(
        db.DateTime, server_default=func.now(), nullable=False)

    def init(self, id, invoice_id, customer_id, product_id, quantity, price, timestamp):
        self.id = id
        self.invoice_id = invoice_id
        self.customer_id = customer_id
        self.product_id = product_id
        self.quantity = quantity
        self.price = price
        self.timestamp = timestamp

    def json(self):
        return {"id": self.id, "invoice_id": self.invoice_id, "customer_id": self.customer_id, "product_id": self.product_id, "quantity": self.quantity, "price": self.price,
                "timestamp": self.timestamp}

    def json(self):
        return {"id": self.id, "customer_id": self.customer_id, "product_id": self.product_id, "quantity": self.quantity, "price": self.price,
                "timestamp": self.timestamp}

@app.route('/create_order', methods=['POST'])
def create_order():
    order_data = request.get_json()
    
    cart = order_data['cart']
    customer_id = order_data['id']

    total = 0
    for c_list in cart:
        product_price = c_list['unit_price']
        total += product_price
        #print(product_price)

    new_order_invoice = Order_invoice( customer_id = order_data['id'], total_amount = total, 
    id = 555) #find sth to generate id)

    try:
        db.session.add(new_order_invoice)
        db.session.commit()
    
    except:
            return jsonify({"status": "fail",
                        "message": "An error occurred creating order invoice."})
    #return jsonify({"status": "success"})
    
    for c_list in cart:
        try:
            product_price = c_list['unit_price']
            product_id = c_list['id']
            quantity = c_list['quantity']
            new_order = (Order( id= 333, invoice_id = 555,
                                    customer_id = customer_id,
                                    product_id = product_id,
                                    quantity = quantity,
                                    price = product_price))
            db.session.add(new_order)
            db.session.commit()
    
        except:
            return jsonify({"status": "fail",
                        "message": "An error occurred creating order."})
        return jsonify({"status": "success"})



@app.route('/get_invoice/', methods=['GET'])
def get_invoice():
    invoice_id = request.args.get('invoice_id')
    invoice = Order_invoice.query.filter_by(id=invoice_id).first()
    if invoice:
        return_message = ({"status": "success",
                           "invoice": invoice.json()})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)



@app.route("/get_all_orders/", methods=['GET'])
def get_all_orders():
    invoice_id = request.args.get('invoice_id')
    order = [order.json() for order in Order.query.filter_by(invoice_id=invoice_id).all()]
    if order:
        return_message =({"status": "success",
                          "order": order})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5003, debug=True)
