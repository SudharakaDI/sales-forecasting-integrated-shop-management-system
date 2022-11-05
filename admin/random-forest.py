import pandas as pd
    
# Load data
melbourne_file_path = 'sales_data.csv'
melbourne_data = pd.read_csv(melbourne_file_path) 
# Filter rows with missing values
melbourne_data = melbourne_data.dropna(axis=0)
# Choose target and features
# y = melbourne_data.Price
y = melbourne_data.Sales

# melbourne_features = ['Rooms', 'Bathroom', 'Landsize', 'BuildingArea', 
#                         'YearBuilt', 'Lattitude', 'Longtitude']

melbourne_features = ['ItemId','CategoryId','Month']
X = melbourne_data[melbourne_features]
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
# print(val_X)
print(val_X.shape)
X_new = [(1,2,3)]
melb_preds = forest_model.predict(X_new)
# print(mean_absolute_error(val_y, melb_preds))
print(melb_preds)