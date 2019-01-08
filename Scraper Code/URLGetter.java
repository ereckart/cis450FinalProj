import java.net.HttpURLConnection; import java.net.URL; import java.net.URLConnection; import java.util.ArrayList; import java.util.Scanner;
public class URLGetter {
	private URL url; private HttpURLConnection httpConnection;
	/**  * Creates a URL from the given string.  * Open the connection to be used later.  * @param url the url to get the information from  */ 
	public URLGetter(String url) {
	try {
	this.url = new URL(url);
	URLConnection connection = this.url.openConnection(); httpConnection = (HttpURLConnection) connection;
	} catch (Exception e) { e.printStackTrace(); }
	}
	/**  * This method will print the status codes from the connection.  */ 
	public void printStatusCode() {
	try {
	int code = httpConnection.getResponseCode(); String message = httpConnection.getResponseMessage();
	System.out.println(code + " : " + message);
	} catch (Exception e) { e.printStackTrace(); }
	}
	/**  * This method will get the HTML contents.  * @return the arraylist of contents of the page.  */ public ArrayList<String> getContents() {
	ArrayList<String> contents = new ArrayList<String>();
	Scanner in; try {

	in = new Scanner(httpConnection.getInputStream()); while (in.hasNextLine()) {
	String line = in.nextLine(); contents.add(line);
	}
	} catch (Exception e) { e.printStackTrace(); }
	return contents;
	}
}
