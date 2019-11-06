import pandas as pd
import os
import seaborn as sns
import glob
tmp=[]
all_data=pd.DataFrame()
for f in os.listdir():
    if f.endswith('.xlsx'):
        print(f)
        tmp.append(pd.read_excel(f,names=["temp","humid","dis"]))

all_data=pd.concat(tmp)
print(all_data.head())
if(input("??:")=="Y"):
    all_data.to_excel('file1.xlsx',header=False, index=False)
print("done")
plt=sns.lmplot('temp', 'humid', data=all_data, hue='dis', fit_reg=False)
plt.savefig('S.png')
