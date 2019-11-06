import xlsxwriter
import numpy
import scipy.stats as stats
from statistics import *

# data arrays
#blight tomato, potato, rice,corn and grape
blighttemp = [27, 24, 29, 21, 18]
blighthum = [86, 82, 90, 83, 80]
#rice brown spot
brownspottemp = [16,36,23,29,32]
brownspothum = [86,100,92,96,99]
#common rust corn
cmrusttemp = [15,23,18,17,21]
cmrusthum=[95,96,97,92,90]
#Black rot grape
brtemp=[15,33,21,28,19]
brhum= [76,81,86,82,79]
#esca grape
escatemp = [15,32,28,21,19]
escahum = [80,90,87,81,86]
#leaf smut rice
lsmuttemp = [25,35,27,31,33]
lsmuthum = [91,90,92,93,93]
#bacterial spot tomato
bspottemp = [24,30,29,26,28]
bspothum = [76,82,80,84,79]
#leaf mold tomato
lmoldtemp = [5,32,27,19,14]
lmoldhum = [85,89,88,91,84]
#septoria leaf spot tomato
sspottemp = [15,27,19,23,22]
sspothum = [76,84,79,82,85]
#spider mites tomato
spmitetemp = [20,24,29,32,35]
spmitehum = [75,79,77,82,84]
#target spot tomato
tspottemp = [20,28,22,27,26]
tspothum = [80,81,82,83,85]

ext = ".xlsx"

row=0

def prepDat(temp, hum, dname):
    fname = dname + ext
    wkbk = xlsxwriter.Workbook(fname)
    wkst = wkbk.add_worksheet()
    row=0
    lt = len(temp)
    mtemp = mean(temp)
    mhum = mean(hum)
    sdtemp = pstdev(temp)
    sdhum = pstdev(hum)
    for i in range(0,lt):
        wkst.write(row,0,round(temp[i],2))
        wkst.write(row,1,round(hum[i],2))
        wkst.write(row,2,dname)
        row += 1
    caltemp = numpy.random.normal(loc = mtemp, scale = sdtemp,size =1000)
    calhum = numpy.random.normal(loc = mhum, scale = sdhum,size = 1000)
    for i in range(lt,1000):
        wkst.write(row,0,round(caltemp[i],2))
        wkst.write(row,1,round(calhum[i],2))
        wkst.write(row,2,dname)
        row += 1
    wkbk.close()

prepDat(blighttemp,blighthum,"blight")
prepDat(tspottemp,tspothum,"target_spot_tomato")
prepDat(spmitetemp,spmitehum,"spider_mite_tomato")
prepDat(sspottemp,sspothum,"septoria_spot_tomato")
prepDat(lmoldtemp,lmoldhum,"leaf_mold_tomato")
prepDat(bspottemp,bspothum,"bacterial_spot_tomato")
prepDat(lsmuttemp,lsmuthum,"leaf_smut_rice")
prepDat(escatemp,escahum,"esca_grape")
prepDat(brtemp,brhum,"black_rot_grape")
prepDat(cmrusttemp,cmrusthum,"common_rust_corn")
prepDat(brownspottemp,brownspothum,"brown_spot_rice")


