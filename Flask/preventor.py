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
    url = "https://tools.keycdn.com/geo.json"

    data = {
    'host': request.remote_addr
    }

    response = requests.request("GET", url, data=data)
    print("resp:",response.text)
    J=json.loads(response.text)
    lon=J["data"]["geo"]["longitude"]
    lat=J["data"]["geo"]["latitude"]
    state=J["data"]["geo"]["region_name"]
    print("state: ",state)

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
    ses=[]
    Response={}
    Response["disease"]=""
    for disease in freq:
      Response={}
      Response["disease"]=""
      ret=disease[0].split("_")
      if(ret[-1]!="blight"):
        Response["plant"]=ret[-1]
        Response["plant"]=Response["plant"].capitalize()
        ret.pop()
        for word in ret:
          word=word.capitalize()
          Response["disease"]+=word+" "
        Response["disease"]=Response["disease"][:-1]
      ses.append(Response)
    freq1 = json.dumps(ses)
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
