FROM ubuntu
LABEL maintainer="tanaykarve"
#ADD . ~
RUN apt-get update -y
RUN apt-get upgrade -y
RUN apt-get install -y python3 python3-pip
#RUN pip3 install -upgrade pip
#RUN pip3 install -r requirements.txt
COPY ./requirements.txt /FlaskObjectDetection/requirements.txt
WORKDIR /FlaskObjectDetection
RUN pip3 install --upgrade pip
RUN pip install -r requirements.txt
ENTRYPOINT ["python3"]
CMD ["app.py"]

