import java.io.IOException; 
import java.net.HttpURLConnection; 
import java.net.URL; 
import java.net.URLConnection; 
import java.util.ArrayList;
import java.util.HashMap;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Scanner;
import java.util.Set;
import java.util.TreeMap;
import java.util.TreeSet;
import java.util.regex.*;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import org.jsoup.Jsoup; 
import org.jsoup.nodes.Document; 
import org.jsoup.nodes.Element; 
import org.jsoup.select.Elements;
import org.w3c.dom.NodeList;

public class ImageGetter {
	
	public String movie;
	public String movieYear;
	public static String baseURL = "https://en.wikipedia.org";
	public static String startURL = "https://en.wikipedia.org/wiki/Lists_of_films";
	
	private static HttpURLConnection httpConnection;
	
	public ImageGetter(String movie, String movieYear){
		this.movie = movie;
		this.movieYear = movieYear;
	}
	
	public String getMovieImage(){
		Document allMoviesPage = convertToDoc(startURL);
		// Start w movie year
		// Get list of movies in that year
		// Get specific movie
		// Get image
		for(Element e1 : allMoviesPage.getElementsByTag("a")){
			if(Jsoup.parse(e1.toString()).text().contains(this.movieYear)){
				String yearURL = e1.attr("href");
				Document yearMoviePage = convertToDoc(baseURL + yearURL);

				for(Element e2: yearMoviePage.getElementsByTag("a")){
					if(Jsoup.parse(e2.toString()).text().contains(this.movie)){
						String movieURL = e2.attr("href");
						
						Document moviePage = convertToDoc(baseURL + movieURL);
						for(Element e3: moviePage.getElementsByClass("infobox")){
							for(Element e4 : e3.getElementsByClass("image")){
								String imageLink = e4.attr("href");
								Document imagePage = convertToDoc(baseURL + imageLink);
								for(Element e5 : imagePage.getElementsByClass("fullImageLink")){
									return e5.child(0).attr("href").substring(2);
								}
							}
						}
						
						break;
					}
				}
				break;
			}
		}
		
		return "";
	}
	
	public static Document convertToDoc(String l) {
		URLGetter urlGet = new URLGetter(l);
		try {
			URL url = new URL(l);
			URLConnection connection = url.openConnection(); 
			httpConnection = (HttpURLConnection) connection;
		}
		catch (Exception e) { 
			e.printStackTrace(); 
		}
		ArrayList<String> contents = urlGet.getContents();
		StringBuilder pg = new StringBuilder();
		for (String s : contents) {
			pg.append(s);
		}
		Document docum = Jsoup.parse(pg.toString());
		return docum;
	}

}