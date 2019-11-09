import pickle
import json
from flask import Flask, request, render_template, jsonify
from API import *
kn = pickle.load(open("pfiles/KNN.pkl","rb"))
svm = pickle.load(open("pfiles/SVM.pkl","rb"))
dt = pickle.load(open("pfiles/DT.pkl","rb"))
rf = pickle.load(open("pfiles/RF.pkl","rb"))
lr = pickle.load(open("pfiles/LR.pkl","rb"))
gnb = pickle.load(open("pfiles/GNB.pkl","rb"))

app=Flask(__name__)

@app.route('/prev/')
def prev():
    url = "https://geo.p.rapidapi.com/"

    headers = {
    'x-rapidapi-host': "geo.p.rapidapi.com",
    'x-rapidapi-key': "e169a4fe04msh4afb825ab06053fp1dc5ddjsna23987d08d7a"
    }

    response = requests.request("GET", url, headers=headers)
    J=json.loads(response.text)
    lon=J["longitude"]
    lat=J["latitude"]
    t,h=getWeather(lon=lon,lat=lat)
    preds = []
    freq = []
    preds.append(kn.predict([[t,h]]).tolist())
    preds.append(svm.predict([[t,h]]).tolist())
    preds.append(dt.predict([[t,h]]).tolist())
    preds.append(rf.predict([[t,h]]).tolist())
    preds.append(lr.predict([[t,h]]).tolist())
    preds.append(gnb.predict([[t,h]]).tolist())
    for j in range(0,3):
      counter = 0
      num = preds[0]
      #finding most freq
      for i in preds: 
          curr_frequency = preds.count(i) 
          if(curr_frequency> counter): 
              #runner_up = num
              counter = curr_frequency 
              num = i
    
      freq.append(num)
      #removing most frequent from list
      for i in preds:
        if(i==num):
          preds.remove(i)

      if(len(preds)==0):
        if(j==1):
          freq[1] = freq[0]
          freq[2] = freq[0]
          break
        if(j==2):
          freq[2]=freq[0]
          break

    freq = Remove(freq)
    freq1 = json.dumps({"prediction" : freq })
    print("***********freq 1 : ",freq1)
    return freq1
    #return render_template("ind.html",jf =freq1)

def Remove(duplicate): 
	final_list = [] 
	for num in duplicate: 
		if num not in final_list: 
			final_list.append(num) 
	return final_list 

if __name__ == "__main__":
    app.run(host="0.0.0.0",debug=True,port=5000)
