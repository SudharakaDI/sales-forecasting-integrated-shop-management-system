from tkinter.tix import INTEGER
import pandas as pd

from flask import Flask, request,render_template
import datetime
import pickle

app = Flask(__name__)



@app.route('/result',methods=['GET'])
def ml_result():
    item_id = request.args.get('id')
    category_id = request.args.get('category_id')
    price = request.args.get('price')
    month = datetime.datetime.now().month
    

    # Load data
    sales_file_path = 'sales_data - Copy.csv'
    sales_data = pd.read_csv(sales_file_path) 
    # Filter rows with missing values
    sales_data = sales_data.dropna(axis=0)
    # Choose target and features
    # y = sales_data.Price
    y = sales_data.Sales

    
    sales_features = ['ItemId','CategoryId','Month','Price']
    X = sales_data[sales_features]
    print(X)

    from sklearn.model_selection import train_test_split

    # split data into training and validation data, for both features and target
    # The split is based on a random number generator. Supplying a numeric value to
    # the random_state argument guarantees we get the same split every time we
    # run this script.
    train_X, val_X, train_y, val_y = train_test_split(X, y,random_state = 40 ,test_size=0.1)
    # print(train_X)


    from sklearn.ensemble import RandomForestRegressor
    from sklearn.metrics import mean_absolute_error

    forest_model = RandomForestRegressor(random_state=1)
    forest_model.fit(train_X, train_y)

    #Save machine learning model to disk
    pickle.dump(forest_model,open('model.pkl','wb'))
    sales_model=pickle.load(open('model.pkl','rb'))
    # print(val_X)
    print(val_X.shape)
    X_new = [(item_id,category_id,month,price)]
    # sales_preds = forest_model.predict(X_new)
    sales_preds = sales_model.predict(X_new)
    # print(mean_absolute_error(val_y, sales_preds))

    sales_preds = int(sales_preds)
    print(sales_preds)
    return render_template("index.html",result=sales_preds)

if __name__== '__main__':
    app.run(port=3000,debug=True)
