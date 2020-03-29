import requests
from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from email.message import EmailMessage
import smtplib

app = Flask(__name__)
# app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
# app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/customer_db'
# app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)

@app.route('/')
def hello():
    return 'hello'

@app.route('/telegram_bot_sendtext')
def telegram_bot_sendtext():

    bot_token = '837612960:AAGrKl0XmNQAoN3ZCb-VIOpJz0w6HWypPrw'
    bot_chatID = '99770482'
    # bot_chatID = '167560833'
    send_text = 'https://api.telegram.org/bot' + bot_token + \
        '/sendMessage?chat_id=' + bot_chatID + '&parse_mode=Markdown&text=' + 'hi jeddy'

    response = requests.get(send_text)

    return response.json()


# test = telegram_bot_sendtext("Testing Telegram bot")
# print(test)


bot_token = '837612960:AAGrKl0XmNQAoN3ZCb-VIOpJz0w6HWypPrw'
telegram_bot_url = 'https://api.telegram.org/bot' + bot_token


# @app.route('/getMe')
# def getMe():
#     response = requests.get(telegram_bot_url + "/getMe").json()
#     return response


# @app.route('/getUpdates')
# def getUpdates():
#     response = requests.get(telegram_bot_url + "/getUpdates").json()
#     return response


# @app.route('/setWebhook')
# def setWebhook():
#     response = requests.get(
#         telegram_bot_url + "/setWebhook?url=" + 'localhost:5005/doPost').json()
#     return response


# @app.route('/doPost')
# def doPost():
#     EMAIL_ADDRESS = 'g2t3esd@gmail.com'
#     EMAIL_PASSWORD = 'Qwertyuiop1!'
#     msg = EmailMessage()
#     msg['Subject'] = 'Hello world'
#     msg['From'] = EMAIL_ADDRESS
#     msg['To'] = 'jeddy.tan.2018@smu.edu.sg'
#     msg.set_content('This is a plain text email')
#     with smtplib.SMTP_SSL('smtp.gmail.com', 465) as smtp:
#         smtp.login(EMAIL_ADDRESS, EMAIL_PASSWORD)
#         smtp.send_message(msg)


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5005, debug=True)
