from flask import Flask, flash, request, redirect, url_for
from werkzeug.utils import secure_filename
from datetime import datetime
import pickle
import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
from PIL import Image
from keras.preprocessing import image
from keras import backend as K
import numpy as np
from flask import send_from_directory,jsonify
import io
#import urllib
import os
import tensorflow_hub as hub
import tensorflow as tf
from mailer import *
#from rq import Queue
#from worker import conmodel

export_path="tmp/saved_models/1566318387"

app = Flask(__name__)

# classes=pickle.load(open('model/output_labels.pkl','rb'))
#classes__=['Apple___Apple_Scab', 'Apple___Black_Rot', 'Apple___Cedar_Apple_Rust', 'Apple___Healthy', 'Blueberry___Healthy', 'Cherry_(Including_Sour)___Powdery_Mildew', 'Cherry_(Including_Sour)___Healthy', 'Corn_(Maize)___Cercospora_Leaf_Spot Gray_Leaf_Spot', 'Corn_(Maize)___Common_Rust_', 'Corn_(Maize)___Northern_Leaf_Blight', 'Corn_(Maize)___Healthy', 'Grape___Black_Rot', 'Grape___Esca_(Black_Measles)', 'Grape___Leaf_Blight_(Isariopsis_Leaf_Spot)', 'Grape___Healthy', 'Orange___Haunglongbing_(Citrus_Greening)', 'Peach___Bacterial_Spot', 'Peach___Healthy', 'Pepper,_Bell___Bacterial_Spot', 'Pepper,_Bell___Healthy', 'Potato___Early_Blight', 'Potato___Late_Blight', 'Potato___Healthy', 'Raspberry___Healthy', 'Soybean___Healthy', 'Squash___Powdery_Mildew', 'Strawberry___Leaf_Scorch', 'Strawberry___Healthy', 'Tomato___Bacterial_Spot', 'Tomato___Early_Blight', 'Tomato___Late_Blight', 'Tomato___Leaf_Mold', 'Tomato___Septoria_Leaf_Spot', 'Tomato___Spider_Mites Two-Spotted_Spider_Mite', 'Tomato___Target_Spot', 'Tomato___Tomato_Yellow_Leaf_Curl_Virus', 'Tomato___Tomato_Mosaic_Virus', 'Tomato___Healthy']

classes=['00_Corn____Cercospora Leaf Spot',
       '01_Corn____Common Rust_',
              '02_Corn____Blight', '03_Grape___Black Rot',
                     '04_Grape___Esca',
                            '05_Grape___Blight',
                                   '06_Potato___Blight', '07_Potato___Blight',
                                          '08_Tomato___Bacterial Spot', '09_Tomato___Blight',
                                                 '10_Tomato__Blight', '11_Tomato___Mold',
                                                        '12_Tomato___Septoria Leaf Spot',
                                                               '13_Tomato___Spider Mites',
                                                                      '14_Tomato___Target Spot']


classes_actual=['Cercospora Leaf Spot','Common Rust','Blight', 'Black Rot','Esca','Blight','Blight', 'Blight','Bacterial Spot', 'Blight','Blight', 'Mold','Septoria Spot','Spider Mites','Target Spot']

global model
def loadmodel():
    reloaded = tf.keras.experimental.load_from_saved_model(export_path, custom_objects={'KerasLayer':hub.KerasLayer})
    return reloaded

K.clear_session()
model=loadmodel()
model._make_predict_function()
graph = tf.get_default_graph()

print("[!] model loaded")
@app.route('/predict',methods=["GET","POST"])
def prediction():
        try:
                global model
                global graph
                test_image= request.files["image"].read()
                test_image = Image.open(io.BytesIO(test_image))
                if test_image.mode!="RGB":
                    test_image=test_image.convert("RGB")
                test_image=test_image.resize((224, 224))
                test_image = image.img_to_array(test_image)
                test_image=np.array(test_image,dtype=np.float16)/255.0
                test_image = np.expand_dims(test_image, axis = 0)
                with graph.as_default():
                    result = model.predict(test_image)
                cl=[classes[i] for i in range(0,15)]
                dd=dict(zip(cl,result.tolist()[0]))
                dd=sorted(dd.items(), key=lambda kv: kv[1],reverse=True)[0:4]
                jdict={}
                for i in dd:
                        jdict[i[0]]=i[1]
                return (jsonify(jdict))
        except Exception as e:
                print(e)
                return (jsonify({'error':'Did not detect','info':str(e)}))

@app.route('/send',methods=["GET"])
def send():
    try:
        img=request.args.post('img')

        mail(request.args.post('to'),request.args.post('msg'),img)
        return "success"
    except Exception as e:
        return str(e)

@app.route('/',methods=["GET","POST"])
def home():
        return("home")

if __name__ == '__main__':
    app.run(host='0.0.0.0',port=6000,debug=True)
