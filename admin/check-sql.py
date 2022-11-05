import mysql.connector
import pandas as pd
import datetime

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="food-order"
)

sql="SELECT * FROM tbl_sales  INNER JOIN tbl_food ON tbl_sales.item_id=tbl_food.id"
# my_data=pd.read_sql(sql,mydb)

# date =  my_data['sales_date']

# my_data.to_csv('food_data.csv')
# print(my_data)
mycursor = mydb.cursor()

mycursor.execute(sql)

myresult = mycursor.fetchall()

myresult.sort(key=lambda x:x[3])



for x in myresult:
  
  print(x[3].day)

