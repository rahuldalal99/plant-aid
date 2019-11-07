#@Tanay Karve 
#7th November 12:40 PM

import requests
import json

TRANSLATE_KEY="trnsl.1.1.20191107T052815Z.1d03b099a096c3c5.d88b0272fb67f869d284b7ed7a3973c8a4045994"
WEATHER_KEY="aa9ba4c1b9e7b8d8ebea4435abe37e62"

TRANSLATE_URL="https://translate.yandex.net/api/v1.5/tr.json/translate?"
WEATHER_URL="http://api.openweathermap.org/data/2.5/weather?"

langDict={
	"english" : "en",
	"marathi" : "mr",
	"telugu"  : "te",
	"punjabi" : "pa",
	"tamil"	  : "ta",
	"malyalam": "ml",
	"hindi"	  : "hi",
	"gujarati": "gu",
	"kannada" : "kn"
}

def getWeather(lon,lat):
	#Returns tuple of temperature and humidity
	response=requests.get(WEATHER_URL+"lat="+str(lat)+"&lon="+str(lon)+"&units=metric&appid="+WEATHER_KEY)
	response=json.loads(response.text)
	temp=response["main"]["temp"]
	humid=response["main"]["humidity"]
	return (temp,humid)

def translate(lang,text):
	#Returns translated text, which is in devanagari script.
	#Do not try to print translated text on terminal, as it will display improper format characters
	#If you want to check translation consistency, uncomment lines [43-44] to verify from file 'translate.html'
	try:
		lang=langDict[lang]
	except:
		return "{\"error\":\"invalid language code\"}"
	response=requests.get(TRANSLATE_URL+"key="+TRANSLATE_KEY+"&text="+text+"&lang=en-"+lang)
	print(TRANSLATE_URL+"key="+TRANSLATE_KEY+"&text="+text+"&lang=en-"+lang)
	response=json.loads(response.text)
	response=response["text"][0]
	# with open('translate.html','w', encoding='utf-8') as f:
	# 		f.write(r.text)
	return response

def tests():
	print(getWeather(lon=73.84,lat=18.52))
	translate(lang="marathi",text="The plant disease Esca is a serious one")
