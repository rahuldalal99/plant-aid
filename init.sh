apt-get install python3 python3-pip
pip3 install --upgrade pip
pip install -r requirements.txt
gunicorn -b 0.0.0.0:80 app:app --daemon

