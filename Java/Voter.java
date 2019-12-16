import java.io.*;
import java.util.*;
//import org.apache.commons.lang.ArrayUtils;

public class Voter {
	GaussianNB GNB_clf;
	RandomForestClassifier RF_clf;
	DecisionTreeClassifier DT_clf;
	SVC SVC_clf;
	KNeighborsClassifier KNN_clf;
	static double[][]vectors ;
	//constructor
	public Voter() {
		try {
		GNB_clf = new GaussianNB("GaussianNB.json");
		RF_clf = new RandomForestClassifier("RandomForest.json");
		KNN_clf = new KNeighborsClassifier("KNN.json");
		DT_clf = new DecisionTreeClassifier("DecisionTree.json");	
		SVC_clf = new SVC("SVC.json");
		
		}
		catch(Exception e) {
			e.printStackTrace();
		}
	}
	
	public boolean Check(int[] arr,int p ,int ind){
		for(int i =0;i<arr.length;i++) {
			if(p == arr[i]){
				if(i==ind) {
					continue;
				}
				else {
				return true;
				}
			}
		}
		return false;
	}
	
	ArrayList<Integer> vote(double[] features) {
		int[] Pred = new int[5];
		//int[] Preds =  new int[5];
		//int Preds_ptr =1 ;
		Pred[0] = GNB_clf.predict(features);
		Pred[1] = RF_clf.predict(features);
		Pred[2] = KNN_clf.predict(features);
		Pred[3] = DT_clf.predict(features);
		Pred[4] = SVC_clf.predict(features);
		
		ArrayList list = new ArrayList<Integer>();
		//Preds[0]=Pred[0];
		for(int i =0;i<=Pred.length;i++) {
			if(list.contains(Pred[i])) {
				continue;
			}
			else {
				list.add(Pred[i]);
			}
		}
		return list;
	}
	public static void main() throws IOException{
		Voter v = new Voter();
		ArrayList<Integer> predictions =  new ArrayList<Integer>();
		double[] features= new double[2];
		features[0]=24.0;
		features[1] = 75.2;
		predictions = v.vote(features);
		for(int i: predictions)
			predictions.get(i);
	}
}
