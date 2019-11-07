from flask import Flask,render_template, request, make_response, jsonify,session,redirect,url_for,g
from werkzeug import secure_filename
from werkzeug.exceptions import default_exceptions, HTTPException
import os


app = Flask(__name__)
app.secret_key = os.urandom(24) #secret key for sessions

app.config['UPLOADED_FILES_DEST'] = '/c/Users/mihir/Downloads/flask_app/uploads'

@app.route("/")
def index():
    return  render_template("index.html")


@app.route("/login", methods=["GET", "POST"])
def login():
    if not session.get('user'):
        if request.method == 'POST':
            session.pop('user', None)
            session['user'] = request.form['email_id'] #save email in session
            email_id = request.form.get("email_id")
            passwd = request.form.get("passwd")
            return redirect(url_for('upload')) # redirect to upload after login
        return render_template("login.html")
    return redirect(url_for('index'))


@app.route("/signup", methods=["GET", "POST"])
def signup():
    if not session.get('user'):   # if user is logged in redirect to index.html
        if request.method == 'POST':
            email_id = request.form.get("email_id")
            passwd = request.form.get("passwd")
            name = request.form.get("name")
            return redirect(url_for('upload'))
        return render_template("signup.html")
    return redirect(url_for('index'))



@app.route("/upload", methods=["GET", "POST"])
def upload():

    if request.method == "POST":
        filesize = request.cookies.get('filesize')
        file = request.files["file"]
        print(f"Filesize: {filesize}")

        #print("File uploaded")
        print(file)
        #file.save(os.path.join(app.config['UPLOADED_FILES_DEST'], file.filename))
        file.save(secure_filename(file.filename))
        #res = make_response(jsonify({"message": "File uploaded"}), 200)
        res = make_response(jsonify({"message": "File uploaded"}), 200)

        return res

    return render_template("upload.html")

@app.route('/logout')
def dropsession():
    session.pop('user', None)
    return 'Logged out'
