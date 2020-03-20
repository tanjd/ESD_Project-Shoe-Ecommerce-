from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ
import os
import json
import pika
import requests
import sys
from sqlalchemy import desc


app = Flask(__name__)
# app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/message_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)

customerURL = "http://localhost:5000/"

hostname = "localhost"
port = 5672
connection = pika.BlockingConnection(
    pika.ConnectionParameters(host=hostname, port=port))
channel = connection.channel()


def receive_notification_message():
    exchangename = "notification_direct"
    queue = "message_notification"
    routing_key = "notification.message"
    channel.exchange_declare(exchange=exchangename, exchange_type='direct')

    channelqueue = channel.queue_declare(queue=queue, durable=True)
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchangename,
                       queue=queue_name, routing_key=routing_key)
    channel.basic_consume(
        queue=queue_name, on_message_callback=receive_notification_message_callback, auto_ack=True)
    channel.start_consuming()

# required signature for the callback; no return


def receive_notification_message_callback(channel, method, properties, body):
    print("Received a notificiation message")
    result = process_notification_message(json.loads(body))
    # # print processing result; not really needed
    # # convert the JSON object to a string and print out on screen
    json.dump(result, sys.stdout, default=str)
    print()  # print a new line feed to the previous json dump
    print()  # print another new line as a separator


def process_notification_message(data):
    exchange_name = "notify_topic"
    channel.exchange_declare(exchange=exchangename, exchange_type='topic')

    message_content = data['message_content']
    customer_id = data['customer_id']

    # print(data)
    # print('the message is '+ message_content + ' and the customer_id is ' + str(customer_id))
    # retrieve customer settings
    GET_data = {
        'customer_id': customer_id
    }
    try:
        customer_data = requests.get(
            customerURL + 'get_customer/', params=GET_data)
        customer_data = customer_data.json()
    except:
        return ({"status": "fail",
                 "message": "An error occurred in retrieving customer."})

    email_setting = customer_data['email_setting']
    telegram_setting = customer_data['telegram_setting']
    telegram_id = customer_data['telegram_id']
    email = customer_data['email']

    publish_message = {
        'message_content': message_content,
        'customer_name': customer_data['name']
    }

    # convert a JSON object to a string
    publish_message = json.dumps(publish_message, default=str)
    if (email_setting == True and telegram_setting == True):
        # publish to both telegram and email
        channel.queue_declare(queue='', durable=True)
        channel.queue_bind(exchange=exchange_name,
                           queue='', routing_key='notify.*')
        channel.basic_publish(exchange=exchange_name, routing_key='', body=publish_message,
                              properties=pika.BasicProperties(delivery_mode=2,))
    elif (email_setting == True):
        channel.queue_declare(queue='', durable=True)
        channel.queue_bind(exchange=exchange_name,
                           queue='notify_email', routing_key='*.email')
        channel.basic_publish(exchange=exchange_name, routing_key='', body=publish_message,
                              properties=pika.BasicProperties(delivery_mode=2,))
    elif (telegram_setting == True):
        channel.queue_declare(queue='', durable=True)
        channel.queue_bind(exchange=exchange_name,
                           queue='notify_telegram', routing_key='*.telegram')
        channel.basic_publish(exchange=exchange_name, routing_key='', body=publish_message,
                              properties=pika.BasicProperties(delivery_mode=2,))
    connection.close()
    return True


# execute this program only if it is run as a script (not by 'import')
if __name__ == "__main__":
    print("This is " + os.path.basename(__file__) +
          ": receiving a message to notify...")
    receive_notification_message()
