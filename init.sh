apt-get install python3 python3-pip
pip3 install requirements.txt
gunicorn -b 0.0.0.0 -p 80 app.py --daemon

