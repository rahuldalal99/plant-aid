from flask import Flask,render_template, request, make_response, jsonify,session,redirect,url_for,g
from werkzeug.utils import secure_filename
from werkzeug.exceptions import default_exceptions, HTTPException
import os
from pymongo import MongoClient
import requests
import json


kn = pickle.load(open("pfiles/KNN.pkl","rb"))
svm = pickle.load(open("pfiles/SVM.pkl","rb"))
dt = pickle.load(open("pfiles/DT.pkl","rb"))
rf = pickle.load(open("pfiles/RF.pkl","rb"))
lr = pickle.load(open("pfiles/LR.pkl","rb"))
gnb = pickle.load(open("pfiles/GNB.pkl","rb"))


mongo = MongoClient()
db = mongo.medivine
users=db.users


app = Flask(__name__)
app.secret_key = os.urandom(24) #secret key for sessions
SAVEDIR="/root/plant-aid/Flask/static/"

app.config['UPLOADED_FILES_DEST'] = '/c/Users/Rahul/Downloads/flask_app/uploads'

@app.route("/")
def index():
    return  render_template("index.html")


@app.route('/cure/<plant>/<disease>',methods = ["POST","GET"])
def cure(plant, disease):
    print(plant)
    data = json.load(open("cure.json", "r", encoding="utf-8"))
    return render_template("cure.html",plant=plant, disease=disease,data = data)


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
    i=0
    blights=["Tomato","Potato"]
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
      elif i<2:
        Response["plant"]=blights[i];
        i+=1;
        Response["disease"]="Blight";
      ses.append(Response)
    
    freq1 = json.dumps(ses)
    

    resp=make_response({"disArray":freq1})
    resp.set_cookie("PREVENTER_CALLED","TRUE")
    return resp
    #return render_template("ind.html",jf =freq1)

def Remove(duplicate): 
    final_list = [] 
    for num in duplicate: 
        if num not in final_list: 
            final_list.append(num) 
    return final_list 

@app.run('/opensr')
def opensr():


@app.route('/sup')
def sup():
    return render_template("supportform.html")

@app.route('/support',methods=["POST"])
def insert():
    try:
        if 1:#request.method == "POST":
            info = request.form
            rec = {}
            #u_id = info['user_id']
            #info.pop('user_id',None)
            #del info['user_id']
            print("************")
            #info = json.dumps(info)
            print(request.form)
            rec['user_id'] = info['user_id']
            rec['disease_title'] = info['disease_title']
            rec['causes']=info['causes']
            rec['cure']=info['cure']
            rec['text']=info['text']
            db.support.insert_one(rec)
            print(rec)
            return render_template("index.html")

    except Exception as e:
        print(e)
        return render_template("index.html")


@app.route("/login", methods=["GET", "POST"])
def login():
    if not session.get('user'):
        if request.method == 'POST':
            session.pop('user', None)
            session['user'] = request.form['email_id'] #save email in session
            email = request.form.get("email_id")
            pwd = request.form.get("passwd")
            try:
                log_user = users.find_one({'email_id': email})
                if hash(pwd) == log_user['passwd']:
                    session['user'] = log_user['name']
                    return redirect(url_for('upload')) # redirect to upload after login
                else :
                    resp=make_response(redirect(url_for('login')))
                    resp.set_cookie("SIGNED_IN",email)
                    return resp
            except:
                print("user doesn't exist")
                resp=make_response(render_template("login.html"))

           
        return render_template("login.html")
    return redirect(url_for('index'))


@app.route("/signup", methods=["GET", "POST"])
def signup():
    user_rec ={}
    try:
        session.get("user")

       # if user is logged in redirect to index.html
        if request.method == 'POST':
            session.pop('user', None)
            session['user'] = request.form["email_id"]
            email_id = request.form.get("email_id")
            passwd = request.form.get("passwd")
            name = request.form.get("name")
            user_rec['email_id'] = email_id
            user_rec['passwd'] = hash(passwd)
            user_rec['name'] = name
            users.insert_one(user_rec)
            session['user'] = user_rec['name']
            return redirect(url_for('upload'))
    except:
        return render_template("signup.html")
    return redirect(url_for('index'))


@app.route("/upload", methods=["GET", "POST"])
def upload():

    if request.method == "POST":
        filesize = request.cookies.get('filesize')
        file = request.files["file"]
        #print(f"Filesize: {filesize}")
        
        #print("File uploaded")
        #print(file)
        #file.save(os.path.join(app.config['UPLOADED_FILES_DEST'], file.filename))
        path="IMG"+str(len(os.listdir(SAVEDIR))+1)+".jpg"
        print(path)
        pathIMG=os.path.join(SAVEDIR, path)
        file.save(pathIMG)
        print(pathIMG)
        print("PATH^^")
        #path=urlencode(path)
        #print("http://medivine.me:5000?img_path="+path)
        #file.save(pathIMG)
        #print(pathIMG)
        #F={'image':open(pathIMG,'rb').read()}
        #print(F)
        #print(path in os.listdir('uploads/'))
        #r=requests.post("http://medivine.me:5000/predict",files=F)
        #print(r.json())
        print(path)
        r=requests.post('http://medivine.me:5000/predict',data={'path':path})
        print(r.text)
        data = json.loads(r.text)
        key_max = max(data.keys(), key= (lambda k:data[k]))
        print(key_max)
        key_max =  key_max.split("_")
        plant = key_max[1]
        disease = key_max[4]
        print(plant)
        print(disease)
        #res = make_response(jsonify({"message": "File uploaded"}), 200)
        res = make_response(jsonify({"message": "File uploaded","path":path,"plant":plant,"disease":disease}), 200)
        return res

    return render_template("upload1.html")

@app.route('/logout')
def logout():
    session.pop('user', None)
    return render_template('index.html')

if __name__ == "__main__":
    app.run(debug=True,host="0.0.0.0",port=80)
