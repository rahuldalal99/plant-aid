import os
from flask import Flask, render_template, request, redirect, url_for, send_from_directory,make_response, render_template_string
from werkzeug import secure_filename
import numpy as np
import os
import six.moves.urllib as urllib
import sys
import tensorflow as tf
from collections import defaultdict
from io import StringIO
from PIL import Image
sys.path.append("..")
from utils import fit
from utils import label_map_util
from utils import visualization_utils as vis_util
MODEL_NAME = 'faster_rcnn_inception_v2_coco'
PATH_TO_CKPT = MODEL_NAME# + '/frozen_inference_graph.pb'
PATH_TO_LABELS = os.path.join('data', 'label_map.pbtxt')
NUM_CLASSES = 18
'''
detection_graph = tf.Graph()
with detection_graph.as_default():
  od_graph_def = tf.GraphDef()
  with tf.gfile.GFile(PATH_TO_CKPT, 'rb') as fid:
    serialized_graph = fid.read()
    od_graph_def.ParseFromString(serialized_graph)
    tf.import_graph_def(od_graph_def, name='')
'''
label_map = label_map_util.load_labelmap(PATH_TO_LABELS)
categories = label_map_util.convert_label_map_to_categories(label_map, max_num_classes=NUM_CLASSES, use_display_name=True)
category_index = label_map_util.create_category_index(categories)

with tf.Session(graph=tf.Graph()) as sess:
    tf.saved_model.loader.load(sess, ['serve'], PATH_TO_CKPT)
    detection_graph = tf.get_default_graph()

def load_image_into_numpy_array(image):
  (im_width, im_height) = image.size
  return np.array(image.getdata()).reshape(
      (im_height, im_width, 3)).astype(np.uint8)


app = Flask(__name__)

app.config['UPLOAD_FOLDER'] = 'uploads'
app.config['ALLOWED_EXTENSIONS'] = set(['png', 'jpg', 'jpeg'])
app.config['MAX_CONTENT_LENGTH'] = 16 * 1024 * 1024
app.config['DEBUG'] = True

def allowed_file(filename):
    #return True
    return '.' in filename and \
           filename.rsplit('.', 1)[1] in app.config['ALLOWED_EXTENSIONS']
'''
@app.before_request
def before_request():
    if request.url.startswith('http://'):
        url = request.url.replace('http://', 'https://', 1)
        code = 301
        return redirect(url, code=code)
'''
@app.route('/')
def index():
    return render_template('index.html')
@app.route('/robots.txt')
def robots():
    return send_from_directory('static',
                                   'robots.txt')
@app.route('/file')
def file():
    img_src='uploads/500.jpg'
    return render_template('file.html')

@app.route('/upload', methods=['POST'])
def upload():
    user=request.headers.get('User-Agent')
    with open("log.txt","a") as log:
        log.write("***************\n"+user+"\n")
    files_ids = list(request.files)
    file = request.files[files_ids[0]]
    if file and allowed_file(file.filename):
        filename = secure_filename(str(len(os.listdir('static')))+file.filename)
        file.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))
        return redirect(url_for('uploaded_file',
                                filename=filename))
    if file:
        print("NOT ALLOWED EXTENSION")
    else:
        print("FILE GONE")

@app.route('/uploads/<filename>')
def uploaded_file(filename):
    PATH_TO_TEST_IMAGES_DIR = app.config['UPLOAD_FOLDER']
    TEST_IMAGE_PATHS = [ os.path.join(PATH_TO_TEST_IMAGES_DIR,filename.format(i)) for i in range(1, 2) ]
    IMAGE_SIZE = (12, 8)

    with detection_graph.as_default():
        with tf.Session(graph=detection_graph) as sess:
            for image_path in TEST_IMAGE_PATHS:
                image = Image.open(image_path)
                image = fit.pad(image)
                image_np = load_image_into_numpy_array(image)
                image_np_expanded = np.expand_dims(image_np, axis=0)
                image_tensor = detection_graph.get_tensor_by_name('image_tensor:0')
                boxes = detection_graph.get_tensor_by_name('detection_boxes:0')
                scores = detection_graph.get_tensor_by_name('detection_scores:0')
                classes = detection_graph.get_tensor_by_name('detection_classes:0')
                num_detections = detection_graph.get_tensor_by_name('num_detections:0')
                
                (boxes, scores, classes, num_detections) = sess.run(
                    [boxes, scores, classes, num_detections],
                    feed_dict={image_tensor: image_np_expanded})
                cls=vis_util.visualize_boxes_and_labels_on_image_array(
                    image_np,
                    np.squeeze(boxes),
                    np.squeeze(classes).astype(np.int32),
                    np.squeeze(scores),
                    category_index,
                    use_normalized_coordinates=True,
                    min_score_thresh=0.5,
                    line_thickness=8)
                
                im = Image.fromarray(image_np)
                im=fit.resize(im,2)
                im.save('static/'+filename)
                print(cls)
                with open("log.txt","a") as log:
                    log.write(str(cls)+"\nGET /static/"+filename+"\n**************")
                #'static/'+filename
    response= make_response(render_template_string("{{ url_for('static',filename=filename) }}",filename=filename,classes=cls))

    #response=make_response(url_for('static/'+
    #                           filename))
    response.headers['PREDICTION_CLASSES']=cls
    return response
if __name__ == '__main__':
    app.run(debug=False,host='0.0.0.0',port=80)

