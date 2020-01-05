package com.example.cure;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class MainActivity extends AppCompatActivity {

    TextView tvDisease,tvCure,tvCure_Header;
    View header,Cure_header;
    String plantname,diseasename,value,cure;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        tvDisease = findViewById(R.id.tvDisease);
        tvCure = findViewById(R.id.tvCure);
        header = findViewById(R.id.header);
        tvCure_Header = findViewById(R.id.tvCure_Header);

        tvDisease.setVisibility(View.INVISIBLE);
        tvCure.setVisibility(View.INVISIBLE);
        header.setVisibility(View.INVISIBLE);
        tvCure_Header.setVisibility(View.INVISIBLE);


        AlertDialog.Builder mBuilder = new AlertDialog.Builder(MainActivity.this);
        View mView = getLayoutInflater().inflate(R.layout.accept_info, null);
        final EditText etPlant = (EditText) mView.findViewById(R.id.etPlant);
        final EditText etDisease = (EditText) mView.findViewById(R.id.etDisease);
        mBuilder.setView(mView);
        mBuilder.setTitle("Upload");
        mBuilder.setCancelable(false);
        mBuilder.setPositiveButton("Submit", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                if (!etDisease.getText().toString().isEmpty() && !etPlant.getText().toString().isEmpty()) {
                    Toast.makeText(MainActivity.this, "Uploaded", Toast.LENGTH_SHORT).show();
                    plantname = etPlant.getText().toString();
                    diseasename = etDisease.getText().toString();
                    new DisplayCure().execute();

                } else {
                    Toast.makeText(MainActivity.this, "Please enter all fields", Toast.LENGTH_SHORT).show();
                }
            }
        });
        AlertDialog dialog = mBuilder.create();
        dialog.show();


    }
    public class DisplayCure extends AsyncTask<String, String, Void>
    {
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }

        @Override
        protected void onPostExecute(Void s) {
            super.onPostExecute(s);
            tvDisease.setVisibility(View.VISIBLE);
            tvCure.setVisibility(View.VISIBLE);
            header.setVisibility(View.VISIBLE);
            tvCure_Header.setVisibility(View.VISIBLE);
            tvDisease.setText("Disease Name:"+diseasename);
            tvCure.setText("Cure: "+cure);
            tvCure.setMovementMethod(new ScrollingMovementMethod());
        }

        @Override
        protected Void doInBackground(String... strings) {
            try {
                //URL url = new URL("https://api.myjson.com/bins/ytbh8");
                URL url = new URL("http://192.168.8.8:8080/medivine/cure?plant="+plantname+"&disease="+diseasename);
                HttpURLConnection con = (HttpURLConnection) url.openConnection();
                con.setRequestMethod("GET");
                con.connect();
                BufferedReader br = new BufferedReader(new InputStreamReader(con.getInputStream()));
                value = br.readLine();
                JSONObject json = new JSONObject(value);
                cure = json.getString("cure");
            }
            catch(Exception e)
            {
                System.out.println(e);
            }

            return null;
        }
    }

}


