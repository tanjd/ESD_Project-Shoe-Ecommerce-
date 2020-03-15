from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ

app = Flask(__name__)
#app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/delivery_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)
CORS(app)


class Delivery(db.Model):
    invoice_id = db.Column(db.Integer,primary_key=True)
    address = db.Column(db.String(1000), nullable=False)
    status = db.Column(db.String(120), nullable=True)

    def init(self, invoice_id, address, status):
        self.invoice_id = invoice_id
        self.address = address
        self.status = status
    
    def json(self):
         return {"invoice_id": self.invoice_id, "address": self.address, "status": self.status}


class Delivery_location(db.Model):
    coordinates = db.Column(db.Integer,primary_key=True)
    address = db.Column(db.String(1000), nullable=False)

    def init(self, coordinates, address):
        self.coordinates = coordinates
        self.address = address
    
    def json(self):
         return {"coordinates": self.coordinates, "address": self.address}


@app.route('/get_deliveries', methods=['GET'])
def get_deliveries():
    status = "NULL"
    delivery = [delivery.json() for delivery in Delivery.query.filter_by(status=status).all()]
    if delivery:
        return_message = ({"status": "success",
                           "delivery": delivery})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


""" @app.route('/delivery/', methods=['PATCH'])
def update_status():
    invoice_id = request.args.get('invoice_id')
    delivery = Delivery.query.get(invoice_id)
    status = 'Dispatch'
    delivery.status = status
    try:
        db.session.commit()
    except:
            return jsonify({"status": "fail",
                        "message": "An error occurred updating delivery status."}) """


@app.route('/delivery/<id>', methods=['PATCH'])
def update_status(id):
    delivery = Delivery.query.get(id)
    status = 'Dispatch'
    delivery.status = status
    try:
        db.session.commit()
    except:
            return jsonify({"status": "fail",
                        "message": "An error occurred updating delivery status."})
    return jsonify({"status": "success"})



@app.route('/create_delivery', methods=['POST'])
def create_delivery():
    delivery_data = request.get_json()
    invoice_id = delivery_data['invoice_id']
    address = delivery_data['address']
    status = delivery_data['status']
    new_delivery = Delivery( invoice_id = invoice_id,address = address, status = status) 
    try:
        db.session.add(new_delivery)
        db.session.commit()
    except:
            return jsonify({"status": "fail",
                        "message": "An error occurred creating delivery."})
    return jsonify({"status": "success"})


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5002, debug=True)


 