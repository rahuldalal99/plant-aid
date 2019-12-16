package medivine;
import java.io.Serializable;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;

import com.google.gson.Gson;

public class PlantDCure {
	PlantDiseaseCure obj;
	public static void main(String args[]) throws Exception
	{
		PlantDCure p = new PlantDCure();
		p.serializeCure("Grape","Esca");
	}
	
	public void serializeCure(String plantName,String diseaseName) throws Exception
    {
		 String cure1=null;
    	 Connection conn = null;
		 Statement stmt = null;
		 int plantId= 0,diseaseId = 0;
	      try {
	         Class.forName("org.postgresql.Driver");
	         conn = DriverManager.getConnection("jdbc:postgresql://medivine.me:5432/",
	            "postgres", "");
	        stmt = conn.createStatement();
	       
	      } catch (Exception e) {
	         e.printStackTrace();
	         System.err.println(e.getClass().getName()+": "+e.getMessage());
	         System.exit(0);
	      }
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
	      stmt.close();
	      conn.close();
    	
    }

}
