package medivine;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Statement;

public class userDisease {
	public static void main(String a[]) throws Exception
    {
		 userDisease d = new userDisease();
		 String disease = "Esca";
		 int p_no = 1234856;
		 //Insert function
		 d.insert(p_no, disease);
    }
	
	public void insert(int p_no,String disease) throws Exception
	{
		 Connection conn = null;
		 Statement stmt = null;
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
	      String sql = "INSERT INTO user_disease (phone,disease) values "+"("+p_no+","+"'"+disease+"')";
	      stmt.executeUpdate(sql);
	      stmt.close();
	      conn.close();
	}

}
