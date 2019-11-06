import requests

IMAGE_PATH = "bli.jpg"
image = open(IMAGE_PATH, "rb").read()
payload = {"image": image}

r = requests.post(KERAS_REST_API_URL, files=payload).json()
