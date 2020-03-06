import csv
import mysql.connector

mydb =mysql.connector.connect(host='localhost', user='root', password='', database='product_db')
print("database connected")

cursor =mydb.cursor()
csv_data =csv.reader(open('category.csv'))
for row in csv_data:
    cursor.execute("INSERT INTO category (id, name) VALUES (%s, %s)", row)
    print(row)

mydb.commit()
cursor.close()
print('DONE')