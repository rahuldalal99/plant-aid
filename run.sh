docker run --rm -p 8501:8501 --mount type=bind,source=$(pwd)/saved_model,target=/models/predictor --name medivine-vision -e MODEL_NAME=predictor -t tensorflow/serving & 
