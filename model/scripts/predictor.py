import xlrd
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

loc = "file1.xlsx"

wb=pd.read_excel(loc,names=['temp','humid','dis'])

temp = []
hum = []
lab = []
temp=wb['temp']
hum=wb['humid']
Y=wb['dis']

X = np.vstack((temp,hum)).T

def prediction(t,h):
    preds=[]
    freq = []
    #fitting and predicting from each model
    MLC_clf = MLPClassifier(activation='relu',hidden_layer_sizes=(15,))
    MLC_clf.fit(X,Y)
    preds.append(MLC_clf.predict([[t,h]]))

    DT_clf = DecisionTreeClassifier()
    DT_clf.fit(X,Y)
    preds.append(DT_clf.predict([[t,h]]))

    RF_clf = RandomForestClassifier(n_estimators=15)
    RF_clf.fit(X,Y)
    preds.append(RF_clf.predict([[t,h]]))

    n_neighbor=2
    KNN_clf = neighbors.KNeighborsClassifier(n_neighbor)
    KNN_clf.fit(X,Y)
    preds.append(KNN_clf.predict([[t,h]]))

    GNB_clf = GaussianNB()
    GNB_clf.fit(X,Y)
    preds.append(GNB_clf.predict([[t,h]]))

    LR_clf = LogisticRegression(C=1e5,solver='lbfgs',multi_class='multinomial',max_iter=1500)
    LR_clf.fit(X,Y)
    preds.append(LR_clf.predict([[t,h]]))
    
    SVM_clf = svm.SVC(gamma='scale')
    SVM_clf.fit(X,Y)
    preds.append(SVM_clf.predict([[t,h]]))

    print(preds[0:7])
    #finding mode
    counter = 0
    num = preds[0] 
      
    #first most occuring  
    for j in range(0,3):
      counter = 0
      num = preds[0]
      #finding most freq
      for i in preds: 
          curr_frequency = preds.count(i) 
          if(curr_frequency> counter): 
              runner_up = num
              counter = curr_frequency 
              num = i
    
      freq.append(num)
      #removing most frequent from list
      for i in preds:
        if(i==num):
          preds.remove(i)

      if(len(preds)==0):
        if(j==1):
          freq[1] = freq[0]
          freq[2] = freq[0]
          break
        if(j==2):
          freq[2]=freq[0]
          break

    return freq[0],freq[1],freq[2] 

result=prediction(19,74)
print("Most frequent: ", result[0], "\nSecond most frequent: ",result[1],"\nThird: ",result[2])
    
