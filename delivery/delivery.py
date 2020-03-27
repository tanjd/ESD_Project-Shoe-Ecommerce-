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
# app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/delivery_db'
#app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/markers_db'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///delivery_db.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)
CORS(app)


class Delivery(db.Model):
    invoice_id = db.Column(db.Integer, primary_key=True)
    address = db.Column(db.String(1000), nullable=False)
    status = db.Column(db.String(120), nullable=True)
    customer_id = db.Column(db.Integer, nullable=False)

    def init(self, invoice_id, address, status, customer_id):
        self.invoice_id = invoice_id
        self.address = address
        self.status = status
        self.customer_id = customer_id

    def json(self):
        return {"invoice_id": self.invoice_id, "address": self.address, "status": self.status, "customer_id": self.customer_id}


class Markers(db.Model):
    __tablename__ = 'markers'

    id = db.Column(db.Integer, nullable=False)
    name = db.Column(db.String(60), nullable=False)
    address = db.Column(db.String(80), nullable=False, primary_key=True)
    lat = db.Column(db.Float, nullable=False)
    lng = db.Column(db.Float, nullable=False)
    type = db.Column(db.String(30), nullable=False)

    def init(self, id, name, address, lat, lng, type):
        self.id = id
        self.name = name
        self.address = address
        self.lat = lat
        self.lng = lng
        self.type = type

    def json(self):
        return {"id": self.id, "name": self.name, "address": self.address, "lat": self.lat, "lng": self.lng, "type": self.type}


def delivery_notification(message_content, customer_id):
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
    print("Delivery details sent to notification")
    connection.close()


@app.route('/')
def home():
    return 'delivery microservice is working'


@app.route('/get_all_markers')
def get_all_markers():
    markers = [Markers.json()
               for Markers in Markers.query.all()]
    if markers:
        return_message = ({"status": "success",
                           "markers": markers})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


@app.route('/get_deliveries', methods=['GET'])
def get_deliveries():
    status = "In Progress"
    delivery = [delivery.json()
                for delivery in Delivery.query.filter_by(status=status).all()]
    if delivery:
        return_message = ({"status": "success",
                           "delivery": delivery})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


@app.route('/delivery/', methods=['GET'])
def update_status():
    invoice_id = request.args.get('invoice_id')
    update_this = Delivery.query.filter_by(invoice_id=invoice_id).first()
    if update_this:
        update_this.status = "Dispatched"
        db.session.commit()
        message_content = "Invoice " + invoice_id + " have been dispatched."
        delivery_notification(message_content, update_this.customer_id)
        return jsonify({"status": "success"})
    else:
        return jsonify({"status": "fail",
                        "message": "An error occurred updating delivery status."})


@app.route('/create_delivery', methods=['POST'])
def create_delivery():
    delivery_data = request.get_json()
    invoice_id = delivery_data['invoice_id']
    address = delivery_data['address']
    status = delivery_data['status']
    customer_id = delivery_data['customer_id']
    new_delivery = Delivery(
        invoice_id=invoice_id, address=address, status=status, customer_id=customer_id)
    try:
        db.session.add(new_delivery)
        db.session.commit()
    except:
        return jsonify({"status": "fail",
                        "message": "An error occurred creating delivery."})
    return jsonify({"status": "success"})


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5002, debug=True)
