import xlrd
import json
import numpy as np
from collections import Counter
from sklearn.neural_network import MLPClassifier
from sklearn.tree import DecisionTreeClassifier
from sklearn import neighbors
from sklearn.ensemble import RandomForestClassifier
from sklearn.naive_bayes import GaussianNB
from sklearn.linear_model import LogisticRegression
from sklearn import svm
import pandas as pd 
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import Normalizer
import os
import pickle
loc = "file1.xlsx"
wb=pd.read_excel(loc,names=['temp','humid','dis'])
#get data
temp = []
hum = []
lab = []
temp=wb['temp']
hum=wb['humid']
Y=wb['dis']
X = np.vstack((temp,hum)).T

DT_clf = DecisionTreeClassifier()
DT_clf.fit(X,Y)
pickle.dump(DT_clf,open("pfiles/DT.pkl","wb"))

RF_clf = RandomForestClassifier(n_estimators=15)
RF_clf.fit(X,Y)
pickle.dump(RF_clf,open("pfiles/RF.pkl","wb"))

n_neighbor=2
KNN_clf = neighbors.KNeighborsClassifier(n_neighbor)
KNN_clf.fit(X,Y)
pickle.dump(KNN_clf,open("pfiles/KNN.pkl","wb"))

GNB_clf = GaussianNB()
GNB_clf.fit(X,Y)
pickle.dump(GNB_clf,open("pfiles/GNB.pkl","wb"))

LR_clf = LogisticRegression(C=1e5,solver='lbfgs',multi_class='multinomial',max_iter=1500)
LR_clf.fit(X,Y)
pickle.dump(LR_clf,open("pfiles/LR.pkl","wb"))

SVM_clf = svm.SVC(gamma='scale')
SVM_clf.fit(X,Y)
pickle.dump(SVM_clf,open("pfiles/SVM.pkl","wb"))
