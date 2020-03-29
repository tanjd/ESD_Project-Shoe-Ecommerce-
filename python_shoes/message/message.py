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
# app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
# app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/message_db'
#app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///message_db.db'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:////message_db.db'

app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)

#customerURL = "http://localhost:5000/"
customerURL = "http://18.140.5.32:5000/"


class Message(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    customer_id = db.Column(db.Integer, nullable=False)
    content_message = db.Column(db.String(120), nullable=True)
    status = db.Column(
        db.Boolean, server_default="0", nullable=False)
    created_at = db.Column(
        db.DateTime, server_default=func.now(), nullable=False)

    def json(self):
        return {"id": self.id, "customer_id": self.customer_id, "content_message": self.content_message, "status": self.status, "created_at": self.created_at}


def send_notification(message_content, customer_id):
    # default username / password to the borker are both 'guest'
    # default broker hostname. Web management interface default at http://localhost:15672
    hostname = "myrabbit"
    #hostname = "localhost"
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
    send_notification('message', 1)
    return 'message microservice is working'


@app.route('/send_message_by_category', methods=['POST'])
def send_message_by_category():
    data = request.get_json()
    category_id = data['category_id']
    message_content = data['message']

    GET_data = {
        'category_id': category_id
    }
    try:
        subscriber_data = requests.get(
            customerURL + 'get_customer_ids_by_cat/', params=GET_data)
        subscriber_data = subscriber_data.json()
    except:
        return jsonify({"status": "fail",
                        "message": "An error occurred in retrieving customers."})

    if subscriber_data['status'] == 'success':
        for subscriber in subscriber_data['subscribers']:
            customer_id = subscriber['customer_id']
            try:
                message = Message(content_message=message_content,
                                  customer_id=customer_id)
                db.session.add(message)
                db.session.commit()
            except:
                return jsonify({"status": "fail",
                                "message": "An error occurred in sending message."})
            send_notification(message_content, customer_id)
        return jsonify({"status": "success"})
    else:
        return jsonify({"status": "fail",
                        "message": "An error occurred in sending message."})


@app.route('/broadcast_message', methods=['POST'])
def broadcast_message():
    data = request.get_json()
    message_content = data['message']

    try:
        customer_data = requests.get(
            customerURL + 'get_all_customers/')
        customer_data = customer_data.json()
    except:
        return jsonify({"status": "fail",
                        "message": "An error occurred in retrieving customers."})
    if customer_data['status'] == 'success':
        for customer in customer_data['customers']:
            customer_id = customer['id']
            try:
                message = Message(content_message=message_content,
                                  customer_id=customer_id)
                db.session.add(message)
                db.session.commit()
            except:
                return jsonify({"status": "fail",
                                "message": "An error occurred in sending message."})
            send_notification(message_content, customer_id)
        return jsonify({"status": "success"})
    else:
        return jsonify({"status": "fail",
                        "message": "An error occurred in sending message."})


@app.route('/get_messages_by_customer', methods=['POST'])
def get_messages_by_customer():
    data = request.get_json()
    customer_id = data['customer_id']
    messages = [Message.json()
                for Message in Message.query.filter_by(customer_id=customer_id).order_by(desc(Message.created_at))]
    if messages:
        return_message = ({"status": "success",
                           "messages": messages})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


@app.route('/update_message_status/', methods=['GET'])
def update_message_status():
    message_id = request.args.get('message_id')
    message = Message.query.filter_by(id=message_id).first()
    message.status = True
    try:
        db.session.commit()
    except:
        return jsonify({"status": "fail",
                        "message": "An error occured updating message."})
    return jsonify({"status": "success"})


@app.route('/delete_message/', methods=['GET'])
def delete_message():
    message_id = request.args.get('message_id')
    try:
        Message.query.filter_by(id=message_id).delete()
        db.session.commit()
    except:
        return jsonify({"status": "fail",
                        "message": "An error occurred deleting customer."})
    return jsonify({"status": "success"})


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5004, debug=True)
