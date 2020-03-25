import os
import json
import pika
import requests
import sys
from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ
from sqlalchemy import desc


# app = Flask(__name__)
# app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
# app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/message_db'
# app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

# db = SQLAlchemy(app)
# CORS(app)

customerURL = "http://localhost:5000/"
# customerURL = "http://:5000/"

# hostname = "my-rabbit"
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
    channel.exchange_declare(exchange=exchange_name, exchange_type='topic')

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
    if customer_data['status'] == "success":
        customer = customer_data['customer']
        email_setting = customer['email_setting']
        telegram_setting = customer['telegram_setting']

        publish_message = {
            'message_content': message_content,
            'name': customer['name'],
            'telegram_id': customer['telegram_id'],
            'email': customer['email'],
        }
        publish_message = json.dumps(publish_message, default=str)
        return_msg = ({"status": "success",
                       "message": "Customer does not want to be notified through email and telegram"})
        if (email_setting == True and telegram_setting == True):
            # publish to both telegram and email
            try:
                channel.queue_declare(queue='notify_email', durable=True)
                channel.queue_declare(queue='notify_telegram', durable=True)
                channel.queue_bind(exchange=exchange_name,
                                   queue='notify_email', routing_key='notify.*')
                channel.queue_bind(exchange=exchange_name,
                                   queue='notify_telegram', routing_key='notify.*')
                channel.basic_publish(exchange=exchange_name, routing_key='notify.*', body=publish_message,
                                      properties=pika.BasicProperties(delivery_mode=2,))
            except:
                return_msg = ({"status": "failure",
                               "message": "An error occurred in notifying customer through email and telegram"})
            return_msg = ({"status": "success",
                           "message": "Message has been been notified through email and telegram"})
        elif (email_setting == True):
            try:
                channel.queue_declare(queue='notify_email', durable=True)
                channel.queue_bind(exchange=exchange_name,
                                   queue='', routing_key='*.email')
                channel.basic_publish(exchange=exchange_name, routing_key='*.email', body=publish_message,
                                      properties=pika.BasicProperties(delivery_mode=2,))
            except:
                return_msg = ({"status": "failure",
                               "message": "An error occurred in notifying customer through email"})
            return_msg = ({"status": "success",
                           "message": "Message has been been notified through email"})
        elif (telegram_setting == True):
            try:
                channel.queue_declare(queue='notify_telegram', durable=True)
                channel.queue_bind(exchange=exchange_name,
                                   queue='', routing_key='*.telegram')
                channel.basic_publish(exchange=exchange_name, routing_key='*.telegram', body=publish_message,
                                      properties=pika.BasicProperties(delivery_mode=2,))
            except:
                return_msg = ({"status": "failure",
                               "message": "An error occurred in notifying customer through telegram"})
            return_msg = ({"status": "success",
                           "message": "Message has been been notified through telegram"})
        # connection.close()
        return return_msg
    else:
        return ({"status": "fail",
                 "message": "An error occurred in retrieving customer."})


# execute this program only if it is run as a script (not by 'import')
if __name__ == "__main__":
    print("This is " + os.path.basename(__file__) +
          ": receiving a message to notify...")
    receive_notification_message()
