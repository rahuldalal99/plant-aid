#@Tanay Karve
#Script for automatic distribution of dataset
import os
import shutil

path="JPEGImages/"
persons=["rahul/","mihir/","tanay/"]
for folder in os.listdir(path):
	if folder!="filtered":
		for person in persons:
			try:
				os.mkdir("ImageSets/"+person+"/"+folder)
			except Exception as e:
				print(e)
				pass
		imgs=os.listdir(path+folder)
		#0->1/3 1/3->2/3 2/3->1
		mihir=[imgs[i] for i in range(0,int(len(imgs)/3))]
		tanay=[imgs[i] for i in range(int(len(imgs)/3),2*int(len(imgs)/3))]
		rahul=[imgs[i] for i in range(2*int(len(imgs)/3),len(imgs))]
		
		for file in mihir:
			shutil.copy(path+"/"+folder+"/"+file,"ImageSets/mihir/"+folder)
		for file in rahul:
			shutil.copy(path+"/"+folder+"/"+file,"ImageSets/rahul/"+folder)
		for file in tanay:
			shutil.copy(path+"/"+folder+"/"+file,"ImageSets/tanay/"+folder)