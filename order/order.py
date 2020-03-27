from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ
import json
import pika
import requests
from sqlalchemy import desc

app = Flask(__name__)
#app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
# app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/order_db'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///order_db.db'
# app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:////order_db.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)
CORS(app)
delivery_url = 'http://localhost:5002/'
# delivery_url = 'http://18.140.5.32:5002/'

class Order_invoice(db.Model):
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    total_amount = db.Column(db.Integer, nullable=False)
    customer_id = db.Column(db.Integer, nullable=False)

    Orders = db.relationship('Order', backref='orders', lazy=True)

    def json(self):
        return {"id": self.id, "customer_id": self.customer_id, "total_amount": self.total_amount}


class Order(db.Model):
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    invoice_id = db.Column(db.Integer, db.ForeignKey(
        'order_invoice.id'), nullable=False)
    customer_id = db.Column(db.Integer, nullable=False)
    product_id = db.Column(db.String(120), nullable=False)
    quantity = db.Column(db.Integer, nullable=False)
    price = db.Column(db.Float(6, 2), nullable=False)
    timestamp = db.Column(
        db.DateTime, server_default=func.now(), nullable=False)

    def json(self):
        return {"id": self.id, "invoice_id": self.invoice_id, "customer_id": self.customer_id, "product_id": self.product_id, "quantity": self.quantity, "price": self.price,
                "timestamp": self.timestamp}


def order_notification(message_content, customer_id):
    hostname = "localhost"
    port = 5672
    connection = pika.BlockingConnection(
        pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    exchangename = "notification_direct"
    queue = "message_notification"
    routing_key = "notification.message"
    channel.exchange_declare(exchange=exchangename, exchange_type='direct')

    publish_message = {
        'message_content': message_content,
        'customer_id': customer_id
    }
    publish_message = json.dumps(publish_message, default=str)

    channel.queue_declare(queue=queue, durable=True)
    channel.queue_bind(exchange=exchangename,
                       queue=queue, routing_key=routing_key)
    channel.basic_publish(exchange=exchangename, routing_key=routing_key, body=publish_message,
                          properties=pika.BasicProperties(delivery_mode=2,))
    connection.close()


@app.route('/')
def home():
    # order_notification('message', 1)
    return 'order microservice is working'


@app.route('/create_order', methods=['POST'])
def create_order():
    order_data = request.get_json()

    cart = order_data['cart']
    customer_id = order_data['id']

    total = 0
    for c_list in cart:
        product_price = c_list['unit_price']
        total += product_price
        # print(product_price)

    # find sth to generate id)
    new_order_invoice = Order_invoice(
        customer_id=customer_id, total_amount=total)

    try:
        db.session.add(new_order_invoice)
        db.session.commit()
        invoice_id = new_order_invoice.id
        message_content = "Your order have been confirmed. Your Invoice ID is  " + \
            str(invoice_id) + "."
        order_notification(message_content, customer_id)

    except:
        return jsonify({"status": "fail",
                        "message": "An error occurred creating order invoice."})
    # return jsonify({"status": "success"})
    for c_list in cart:
        price = c_list['unit_price']
        product_id = c_list['id']
        quantity = c_list['quantity']
        try:
            new_order = Order(invoice_id=invoice_id, customer_id=customer_id,
                              product_id=product_id, quantity=quantity, price=price)
            db.session.add(new_order)
            db.session.commit()
        except:
            return jsonify({"status": "fail",
                            "message": "An error occurred creating order."})

    POST_data = {
        "invoice_id": invoice_id,
        "address": order_data['address'],
        "status": "In Progress",
        "customer_id": customer_id}

    try:
        requests.post(delivery_url + 'create_delivery',
                      json=POST_data, timeout=1)

    except:
        return jsonify({"status": "fail", "message": "An error occurred creating delivery."})

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
    order = [order.json()
             for order in Order.query.filter_by(invoice_id=invoice_id).all()]
    if order:
        return_message = ({"status": "success",
                           "order": order})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5003, debug=True)
