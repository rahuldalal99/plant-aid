<b>Email endpoint:</b>

Call POST on /send

parameters:
- 'to': 'email of recipient'
- 'user': 'user for which mail is sent'
- 'disease': 'predicted disease'
- 'img': 'path of predicted image'

example:

<code>curl -X POST "http://139.59.60.5:6000/send" -d "to=tanaykarve@gmail.com&user=tanay&disease=Tomato Curl Virus&img=tcurl.jpg"</code>

TODO:

  -collect more data
  
  -implement Faster RCNN for better model performance
  

app.py is API server

model alternative storage at https://testsysadmin.000webhostapp.com/plant-ai/model-keras-mn.h5

returns: JSON respose for predictions

hosted @ medivine.me

sample_request.py is a script to simulate php request
