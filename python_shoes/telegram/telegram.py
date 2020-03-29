import requests
import os
import json
import pika
import sys
from datetime import datetime


bot_token = '837612960:AAGrKl0XmNQAoN3ZCb-VIOpJz0w6HWypPrw'
telegram_bot_url = 'https://api.telegram.org/bot' + bot_token

hostname = "myrabbit"
# hostname = "localhost"
port = 5672
connection = pika.BlockingConnection(
    pika.ConnectionParameters(host=hostname, port=port))
channel = connection.channel()
exchange_name = "notify_topic"
queue = "notify_telegram"
routing_key = "*.telegram"
channel.exchange_declare(exchange=exchange_name, exchange_type='topic')


def receive_telegram_message():
    channelqueue = channel.queue_declare(queue=queue, durable=True)
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchange_name,
                       queue=queue_name, routing_key=routing_key)
    channel.basic_qos(prefetch_count=1)
    channel.basic_consume(
        queue=queue_name, on_message_callback=receive_telegram_message_callback, auto_ack=True)
    channel.start_consuming()


def receive_telegram_message_callback(channel, method, properties, body):
    print("Received a telegram message to notify")
    result = process_telegram_message(json.loads(body))
    # # print processing result; not really needed
    # # convert the JSON object to a string and print out on screen
    json.dump(result, sys.stdout, default=str)
    print()  # print a new line feed to the previous json dump
    print()  # print another new line as a separator


def process_telegram_message(data):
    name = data['name']
    message_content = data['message_content']
    telegram_id = data['telegram_id']
    telegram_message = 'hi ' + name + ', ' + message_content
    send_text_url = telegram_bot_url + \
        '/sendMessage?chat_id=' + telegram_id + \
        '&parse_mode=Markdown&text=' + telegram_message
    response = requests.get(send_text_url)
    return response.json()


# execute this program only if it is run as a script (not by 'import')
if __name__ == "__main__":
    print("This is " + os.path.basename(__file__) +
          ": receiving a telegram message to notify...")
    receive_telegram_message()
