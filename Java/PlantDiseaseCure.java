import java.io.Serializable;

public class PlantDiseaseCure implements Serializable {
    String plantName,diseaseName,cure;
    
    public PlantDiseaseCure(String plantName, String diseaseName, String cure) {
        this.plantName = plantName;
        this.diseaseName = diseaseName;
        this.cure = cure;
    }
}
