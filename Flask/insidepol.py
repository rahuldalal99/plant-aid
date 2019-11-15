from flask import Flask, render_template, request, url_for, redirect
from pymongo import MongoClient
import json

mongo = MongoClient()
db = mongo.medivine
location=db.location

app = Flask(__name__)

@app.route('/log')
def log():
    '''for i in pol:
        print(i)'''
    user_rec ={}
    try:
        l1 = json.loads(request.args.get('par'))
        print("inside try and could load loc*********")
        user_rec=l1
        location.insert_one(user_rec)
        print("inserted********")
    except Exception as e:
        print("COULDNT INSERT : ",e )
    return render_template("login.html")

''' TODO get boundaries from MongoD for a user
@app.route('/check/<int:x>/<int:y>')
def point_in_poly(x,y):
    try:
        poly = location.find_one({user:})
   # check if point is a vertex
   if (x,y) in poly: return "IN"

   # check if point is on a boundary
   for i in range(len(poly)):
      p1 = None
      p2 = None
      if i==0:
         p1 = poly[0]
         p2 = poly[1]
      else:
         p1 = poly[i-1]
         p2 = poly[i]
      if p1[1] == p2[1] and p1[1] == y and x > min(p1[0], p2[0]) and x < max(p1[0], p2[0]):
         return "IN"

   n = len(poly)
   inside = False

   p1x,p1y = poly[0]
   for i in range(n+1):
      p2x,p2y = poly[i % n]
      if y > min(p1y,p2y):
         if y <= max(p1y,p2y):
            if x <= max(p1x,p2x):
               if p1y != p2y:
                  xints = (y-p1y)*(p2x-p1x)/(p2y-p1y)+p1x
               if p1x == p2x or x <= xints:
                  inside = not inside
      p1x,p1y = p2x,p2y

   if inside: return True
   else: return False
'''
if __name__ == "__main__":
    app.run(debug=True)