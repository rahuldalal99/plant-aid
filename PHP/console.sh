#!/bin/bash
if [ $1 == 'restart' ]
then
	sudo kill $(lsof -ti :420)
	php -S 0.0.0.0:420 
fi
if [ $1 == "start" ]
then
	php -S 0.0.0.0:420
fi
if [ $1 == "stop" ]
then
	sudo kill $(lsof -ti :420)
fi

