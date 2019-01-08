import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.BufferedWriter;
import java.io.FileWriter;


public class Main {
	public static void main(String args[]) {
		String csvFile = "scraper.csv";
        BufferedReader br = null;
        String line = "";
        String cvsSplitBy = ",";

        try {

            br = new BufferedReader(new FileReader(csvFile));
        	BufferedWriter writer = new BufferedWriter(new FileWriter("jsonified.csv"));
        	int count = 1;
            while ((line = br.readLine()) != null) {

                // use comma as separator
                String[] movies = line.split(cvsSplitBy);
                String movieName = movies[1].replaceAll("^\"|\"$", "");
        		ImageGetter i = new ImageGetter(movieName, movies[2]);
            	writer.write(movieName + "," + i.getMovieImage());
            	writer.newLine();
            	System.out.println("Running " + count);
            	count += 1;
            }
            writer.close();
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            if (br != null) {
                try {
                    br.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }
    }
}
