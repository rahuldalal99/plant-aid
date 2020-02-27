clear
ls
ks
ls
exit
clear
ls
export MODEL_NAME=
ls .ssh/
ls -a
ls /etc/ssh/
vi /etc/ssh/sshd_config
clear
ls
export MODEL_DIR="~/saved_model"
export MODEL_NAME="predictor"
docker run -p 8501:8501   --mount type=bind,source=/path/to/my_model/,target=/models/my_model 
clear
docker run -p 8501:8501 --mount type=bind,source=${MODEL_PATH},target=/models/${MODEL_PATH} -e MODEL_NAME=${MODEL_NAME} -t tensorflow/serving
docker run -p 8501:8501 --mount type=bind,source=${MODEL_DIR},target=/models/${MODEL_DIR} -e MODEL_NAME=${MODEL_NAME} -t tensorflow/serving
export MODEL_DIR=/root/saved_model/
docker run -p 8501:8501 --mount type=bind,source=${MODEL_DIR},target=/models/${MODEL_DIR} -e MODEL_NAME=${MODEL_NAME} -t tensorflow/serving
echo MODEL_NAME
docker run -p 8501:8501 --mount type=bind,source=${MODEL_DIR},target=/models/${MODEL_DIR} -e MODEL_NAME=${MODEL_NAME} -t tensorflow/serving
export MODEL_DIR="/root/saved_model/predictor.pb"
docker run -p 8501:8501 --mount type=bind,source=${MODEL_DIR},target=/models/${MODEL_DIR} --name medivine-vision -e MODEL_NAME=${MODEL_NAME} -t tensorflow/serving
echo $MODEL_Path
echo $MODEL_PATH
echo ${MODEL_PATH}
echo ${MODEL_DIR}
ls $MODEL_DIR
ls saved_model/
ls
cd saved_model/
ls
mv predictor.pb saved_model.pb
cd ..
docker run -p 8501:8501 --mount type=bind,source=${MODEL_DIR},target=/models/predictor --name medivine-vision -e MODEL_NAME=${MODEL_NAME} -t tensorflow/serving
export MODEL_DIR="/root/saved_model/"
docker run -p 8501:8501 --mount type=bind,source=${MODEL_DIR},target=/models/predictor --name medivine-vision -e MODEL_NAME=${MODEL_NAME} -t tensorflow/serving
docker rm medivine-vision 
docker run -p 8501:8501 --mount type=bind,source=${MODEL_DIR},target=/models/predictor --name medivine-vision -e MODEL_NAME=${MODEL_NAME} -t tensorflow/serving
ls
cd saved_model/
mkdir 1
mv saved_model.pb 1
ls
ls 1
cd ..
docker run -p 8501:8501 --mount type=bind,source=${MODEL_DIR},target=/models/predictor --name medivine-vision -e MODEL_NAME=${MODEL_NAME} -t tensorflow/serving
