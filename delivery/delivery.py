from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from datetime import datetime
from sqlalchemy.sql import func
from os import environ

app = Flask(__name__)
#app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
#app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/delivery_db'
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/markers_db'
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


# class Delivery_location(db.Model):
#     coordinates = db.Column(db.Integer,primary_key=True)
#     address = db.Column(db.String(1000), nullable=False)

#     def init(self, coordinates, address):
#         self.coordinates = coordinates
#         self.address = address
    
#     def json(self):
#          return {"coordinates": self.coordinates, "address": self.address}

class Markers(db.Model):
    __tablename__ = 'markers'

    id = db.Column(db.Integer, nullable=False)
    name = db.Column(db.String( 60 ), nullable=False)
    address = db.Column(db.String(80), nullable=False, primary_key=True)
    lat = db.Column(db.Integer, nullable=False)
    lng = db.Column(db.Integer, nullable=False)
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
    status = "NULL"
    delivery = [delivery.json() for delivery in Delivery.query.filter_by(status=status).all()]
    if delivery:
        return_message = ({"status": "success",
                           "delivery": delivery})
    else:
        return_message = ({"status": "fail"})
    return jsonify(return_message)


@app.route('/delivery/', methods=['GET'])
def update_status():
    invoice_id = request.args.get('invoice_id')
    update_this = Delivery.query.filter_by(invoice_id = invoice_id).first()
    if update_this:
        update_this.status = "Dispatched"
        db.session.commit()
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


 