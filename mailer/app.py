from flask import request,Flask
from mailer import *

app=Flask(__name__)
@app.route('/send',methods=["GET"])
def send():
	try:
		mail(request.args.get('to'),request.args.get('msg'))
		return "success"
	except Exception as e:
            return "failed:"+e
if __name__=="__main__":
    app.run(host="0.0.0.0",port=5001
            )
