//Test URL : http://localhost:8080/medivine/cure?plant=Grape&disease=Esca
package com.medivine;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.PrintWriter;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;

import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import com.google.gson.Gson;

@WebServlet("/cure")
public class PlantDCure extends HttpServlet
{
	PlantDiseaseCure obj;
	public void doGet(HttpServletRequest req,HttpServletResponse res) throws IOException
	{
		
	     String plantName,diseaseName;
	     
	     //plantName = "Grape";
	     //diseaseName = "Esca";
	     plantName = req.getParameter("plant");
	     diseaseName = req.getParameter("disease");
		 String cure1=null;
		 Connection conn = null;
		 Statement stmt = null;
		 int plantId= 0,diseaseId = 0;
	      try {
	         Class.forName("org.postgresql.Driver");
	         conn = DriverManager.getConnection("jdbc:postgresql://medivine.me:5432/",
	            "medivine", "plantpass");
	        stmt = conn.createStatement();
	        System.out.println("Connected");
		      ResultSet rs = stmt.executeQuery("SELECT plant_id FROM plant where plant_name='"+plantName+"'");
		      while(rs.next())
		      {
		    	  plantId = rs.getInt(1);
		      }
		      rs = stmt.executeQuery("SELECT disease_id FROM disease where disease_name='"+diseaseName+"'");
		      while(rs.next())
		      {
		    	  diseaseId = rs.getInt(1);
		      }
		      rs = stmt.executeQuery("select cure from plant_disease where plant_id="+plantId+"and disease_id="+diseaseId+"");
		      while(rs.next())
		      {
		    	  cure1 = rs.getString(1);
		    	  //System.out.println(cure1);
		      }
		    this.obj = new PlantDiseaseCure(plantName,diseaseName,cure1);
		     Gson gson = new Gson();
		    String json = gson.toJson(obj);
		    System.out.println(json);
		    PrintWriter out = res.getWriter();
		    out.println(json);
		      stmt.close();
		      conn.close();
	   	
	     } catch (Exception e) {
	    	 System.out.println(e);
	        
	      }
	     
	}

}
