import requests
import base64
import json
from PIL import Image
import numpy as np


def resize(im,ratio):
        im=im.resize((int(im.size[0]*ratio),int(im.size[1]*ratio)), Image.ANTIALIAS)
        return im

def pad(im,aspect=(16,9)):
        im=resize(im,0.5)
	#im=im.resize((int(im.size[0]*0.5),int(im.size[1]*0.5)), Image.ANTIALIAS)
        if((im.size[0]%aspect[0])+(im.size[1]%aspect[1])) == 0:#if already 16:9
            return im
        desired_size = im.size[1]

        print(desired_size,im.size)
        old_size = im.size  # old_size[0] is in (width, height) format
        ratio = float(desired_size)/max(old_size)
        new_size = tuple([int(x*ratio) for x in old_size])
        im = im.resize(new_size, Image.ANTIALIAS)
        factor=int(desired_size/aspect[1])
        new_im = Image.new("RGB", (aspect[0]*factor, desired_size),color="#EEEEEE")
        new_im.paste(im, (((aspect[0]*factor)-new_size[0])//2,
	                    (desired_size-new_size[1])//2))
        return new_im

def load_image_into_numpy_array(image):
  (im_width, im_height) = image.size
  return np.array(image.getdata()).reshape(
      (im_height, im_width, 3)).astype(np.uint8)


image_path = "grape.jpg"
image = Image.open(image_path)
image = pad(image)
image_np = load_image_into_numpy_array(image)
image_np_expanded = np.expand_dims(image_np, axis=0)

URL = "http://vision.medivine.me:8501/v1/models/predictor:predict" 
headers = {"content-type": "application/json"}
body = {
    "signature_name": "serving_default",
    "instances": image_np_expanded.tolist()
    }
r = requests.post(URL, data=json.dumps(body), headers = headers) 
print(r.text)