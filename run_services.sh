#!/bin/bash
python customer/customer.py & 
python product/product.py &
python order/order.py
