# Run this to load product database
import csv
import mysql.connector
import sqlite3
mydb = sqlite3.connect('product_db.db')

# mydb =mysql.connector.connect(host='localhost', user='root', password='', database='product_db')
print("database connected")

cursor =mydb.cursor()
csv_data =csv.reader(open('category.csv'))
for row in csv_data:
    cursor.execute("INSERT INTO category (id, name) VALUES (?, ?)", row)
    print(row)

# mydb.commit()
# cursor.close()

# mydb =mysql.connector.connect(host='localhost', user='root', password='', database='product_db')
# print("database connected")

# cursor =mydb.cursor()

csv_data =csv.reader(open('product.csv'))
for row in csv_data:
    cursor.execute("INSERT INTO product (image, name, category_id, description, unit_price, quantity) VALUES (?, ?, ?, ?, ?, ?)", row)
    print(row)

mydb.commit()
cursor.close()

print('DONE')