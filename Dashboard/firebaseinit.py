import firebase_admin
from flask import Flask,render_template, request, make_response, jsonify,session,redirect,url_for
from firebase_admin import credentials
from firebase_admin import db

# Fetch the service account key JSON file contents
cred = credentials.Certificate('medivine-259b9.json')

# Initialize the app with a service account, granting admin privileges
firebase_admin.initialize_app(cred, {
    'databaseURL': 'https://medivine-259b9.firebaseio.com'
})

app = Flask(__name__)
ref = db.reference('users')

@app.route('/')
def welcome():
    return render_template("index.html")


@app.route('/analytics/<int:n>')
def getCount(n):
    phoneNumbers = []
    snapshot = ref.order_by_key().limit_to_first(n).get()
    for key,val in snapshot.items():
        person_temp = "users/" + key + "/phoneNumber"
        pno_ref = db.reference(person_temp)
        snap4shot = pno_ref.get()
        print(snap4shot)
        phoneNumbers.append(snap4shot)
    my_string = ','.join(str(x) for x in phoneNumbers) 
    print('********** string is' )
    print(my_string)
    return my_string
    

@app.route('/analyticsDisease/<phone_no>')
def getDiseaseNames(phone_no):
    ref = db.reference('users')
    Diseases = []
    snapshot = ref.order_by_key().get()
    print("INSIDE ANALYTICSDISEASE**********")
    print(phone_no)
    for key in snapshot:
        print(key)
        #phone number matched
        temp = 'users/' + key + '/phoneNumber'
        userref=db.reference(temp)
        print("INSIDE PHONENUMBER SEARCH**********")
        snap2shot = userref.get()
        print("Phone Number is: ")
        print(snap2shot)
        #for p in snap2shot:
        if(snap2shot==phone_no):
            print("Comparison result: ####")
            print(snap2shot == phone_no)
            print("Pno matched is: ") 
            print(snap2shot)
            temp2 = 'users/' + key + '/diseases'
            disease_ref = db.reference(temp2)
            print("INSIDE DISEASE SEARCH**********")
            snap3shot = disease_ref.get()
            print(snap3shot)
            Diseases = []
            for k,v in snap3shot.items():
                if(snap2shot.__eq__(phone_no)):
                    Diseases.append(v)
                    print(v)
            break
    my_string = ','.join(str(x) for x in Diseases) 
    print("DISEASES: ")
    for val in Diseases:
        print(val)
    print("FINAL DISEASE STRING: " + my_string)
    return my_string
    

if __name__ == "__main__":
    app.run(debug=True,host="0.0.0.0",port=4444)

