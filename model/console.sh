#!/bin/bash
if [ $1 == 'restart' ]
then
	sudo kill $(lsof -ti :5000)
	gunicorn app:app --bind 0.0.0.0:5000 --timeout 120 
fi
if [ $1 == "start" ]
then
	gunicorn app:app --bind 0.0.0.0:5000 --timeout 120
fi
if [ $1 == "stop" ]
then
	sudo kill $(lsof -ti :5000)
fi

