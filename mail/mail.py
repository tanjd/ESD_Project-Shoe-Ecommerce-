import requests
import json
import pika
import sys
import smtplib
import os
import imghdr
from email.message import EmailMessage
from datetime import datetime

# hostname = "myrabbit"
hostname = "localhost"
port = 5672
connection = pika.BlockingConnection(
    pika.ConnectionParameters(host=hostname, port=port))
channel = connection.channel()
exchange_name = "notify_topic"
queue = "notify_email"
routing_key = "*.email"
channel.exchange_declare(exchange=exchange_name, exchange_type='topic')

EMAIL_ADDRESS = 'g2t3esd@gmail.com'
EMAIL_PASSWORD = 'Qwertyuiop1!'


def receive_email_message():
    channelqueue = channel.queue_declare(queue=queue, durable=True)
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchange_name,
                       queue=queue_name, routing_key=routing_key)
    channel.basic_qos(prefetch_count=1)
    channel.basic_consume(
        queue=queue_name, on_message_callback=receive_email_message_callback, auto_ack=True)
    channel.start_consuming()


def receive_email_message_callback(channel, method, properties, body):
    print("Received a email message to notify")
    result = process_email_message(json.loads(body))
    # # print processing result; not really needed
    # # convert the JSON object to a string and print out on screen
    json.dump(result, sys.stdout, default=str)
    print()  # print a new line feed to the previous json dump
    print()  # print another new line as a separator


def process_email_message(data):
    name = data['name']
    message_content = data['message_content']
    email = data['email']
    msg = EmailMessage()
    msg['Subject'] = 'Python Shoes Email Notification'
    msg['From'] = EMAIL_ADDRESS
    msg['To'] = email
    try:
        msg.add_alternative("""\
        <!DOCTYPE html>
        <html>
            <body>
                <h1 style="color:SlateGray;">Hi {name}, </h1>
                <p>{message_content}</p>
            </body>
        </html>
        """.format(name=name, message_content=message_content), subtype='html')

        with smtplib.SMTP_SSL('smtp.gmail.com', 465) as smtp:
            smtp.login(EMAIL_ADDRESS, EMAIL_PASSWORD)
            smtp.send_message(msg)
    except:
        return ({"status": "fail",
                 "message": "An error occurred in retrieving customer."})
    return ({"status": "success",
             "message": "Email to " + email + " has been sent"})


# execute this program only if it is run as a script (not by 'import')
if __name__ == "__main__":
    print("This is " + os.path.basename(__file__) +
          ": receiving an email message to notify...")
    receive_email_message()
