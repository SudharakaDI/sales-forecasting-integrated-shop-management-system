#Get the data from the database
#train the machine learnig model
#Design a html file to show the sales predictions


import string
import pandas 
from sklearn.tree import DecisionTreeClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import accuracy_score
from flask import Flask, request



app = Flask(__name__)



@app.route('/result',methods=['GET'])
def ml_result():
    item_id = request.args.get('id')
    category_id = request.args.get('category_id')

    music_data= pandas.read_csv('admin/music.csv')
    X = music_data.drop(columns=['genre'])
    y=music_data['genre']
    X_train, X_test, y_train, y_test = train_test_split(X,y,test_size=0.2)

    model = DecisionTreeClassifier()
    model.fit(X_train, y_train)
    predictions = model.predict(X_test)

    print(predictions)
    print(predictions)
    score = accuracy_score(y_test, predictions)
    print(score)
    return str(category_id)

if __name__== '__main__':
    app.run(port=3000,debug=True)

