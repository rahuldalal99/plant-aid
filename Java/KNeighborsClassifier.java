package com.medivine;

import java.io.*;
import java.util.*;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
//import org.apache.commons.lang.ArrayUtils;
@WebServlet("/voter")
public class Voter extends HttpServlet{
	GaussianNB GNB_clf;
	RandomForestClassifier RF_clf;
	DecisionTreeClassifier DT_clf;
	SVC SVC_clf;
	KNeighborsClassifier KNN_clf;
	static double[][]vectors ;
	//constructor
	public Voter() {
		String path = "F:\\Dev\\ml\\Porter\\";
		try {
		
		GNB_clf = new GaussianNB(path+"GaussianNB.json");
		RF_clf = new RandomForestClassifier(path+"RandomForest.json");
		KNN_clf = new KNeighborsClassifier(path+"KNN.json");
		DT_clf = new DecisionTreeClassifier(path+"DecisionTree.json");	
		SVC_clf = new SVC(path+"SVC.json");
		
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
		
		for(int i =0;i<Pred.length;i++) {
			if(list.contains(Pred[i])) {
				continue;
			}
			else {
				list.add(Pred[i]);
			}
		}
		return list;
	}
	
	@Override
	protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
		Voter v = new Voter();
		PrintWriter out = resp.getWriter();
		ArrayList<Integer> predictions =  new ArrayList<Integer>();
		double[] features= new double[2];
		features[0]=24.0;
		features[1] = 75.2;
		predictions = v.vote(features);
		for(int i: predictions)
			out.write(i+" ");
		
	}

//	public static void main() throws IOException{
//		Voter v = new Voter();
//		ArrayList<Integer> predictions =  new ArrayList<Integer>();
//		double[] features= new double[2];
//		features[0]=24.0;
//		features[1] = 75.2;
//		predictions = v.vote(features);
//		for(int i: predictions)
//			predictions.get(i);
//	}
}
