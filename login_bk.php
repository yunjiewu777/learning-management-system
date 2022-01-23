<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>

  <body>
    <div class="container">
      <?php
        $conn = mysqli_connect("localhost",
                               "cs377", "ma9BcF@Y", "canvas");  
        if (mysqli_connect_errno()) {
          printf("Connect failed: %s\n", mysqli_connect_error());
          exit(1);
        }

        $id = $_POST['pid'];
        $name = "select fname,lname FROM person WHERE pid='". $id . "';";
		if (!( $name_result = mysqli_query($conn, $name))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
		print("<h3\n>");
		while ($row = mysqli_fetch_assoc($name_result)) {        
			foreach ($row as $key => $value) {
				print ($value . " "); 
          	}
		}
		print ("</h3>\n");
		print("<br>");
		mysqli_free_result($name_result);
	
	
		print("<h4>Take</h4>");
		$query = "select cid,cnumber AS Course,c_name AS Name,semester AS Semester,year AS Year from take JOIN class USING(cid)JOIN course USING (cnumber) JOIN person  WHERE pid = take_pid AND pid='" . $id . "' ORDER BY year DESC,semester,c_name;";
        if (!( $result = mysqli_query($conn, $query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
        
		print("<div><table class=\"table table-striped\"\n");
        $header = false;
        while ($row = mysqli_fetch_assoc($result)) {
          if (!$header) {
            print("<!-- print header once -->");
            $header = true;
            print("<thead class=\"table-dark\"><tr>\n");
            foreach ($row as $key => $value)
		if($key != 'cid'){
			print "<th>" . $key . "</th>";}
            print("</tr></thead>\n");
          }
          print("<tr>\n");     
          foreach ($row as $key => $value) {
			if($key == 'cid'){
				print "<th>";
				print("<form action=\"scourse.php\" method=\"post\">");
				print("<input type=\"hidden\" name=\"pid\" value='" . $id . "'>");	
				print("<input type=\"hidden\" name=\"cid\" value='" . $value . "'>");
			}
			else if($key == 'Course'){
				print("<input type='submit' value='" . $value . "'>");                   
                print("</form></th>");			
			}
            else{
           		print ("<td>" . $value . "</td>"); 
			}
		  }
          print ("</tr>\n");  
        }
        print("</table></div>\n");
        mysqli_free_result($result);


       print("<br>");
       print("<h4>Teach</h4>");
       $te_query = "select cid,cnumber AS Course,c_name AS Name,semester AS Semester,year AS Year from class JOIN course USING (cnumber) WHERE instructor_pid='" . $id . "'ORDER BY year DESC,semester,c_name;";
       if ( ! ( $te_result = mysqli_query($conn, $te_query)) ) { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
        }

        print("<div><table class=\"table table-striped\"\n");
        $header = false;
        while ($row = mysqli_fetch_assoc($te_result)) {
          if (!$header) {
            print("<!-- print header once -->");
            $header = true;
            print("<thead class=\"table-dark\"><tr>\n");
            foreach ($row as $key => $value)
               if($key != 'cid'){
                print "<th>" . $key . "</th>";}
            print("</tr></thead>\n");
          }
          print("<tr>\n");     
          foreach ($row as $key => $value) {
                if($key == 'cid'){
                        print "<th>";
                        print("<form action=\"tcourse.php\" method=\"post\">");
                        print("<input type=\"hidden\" name=\"pid\" value='" . $id . "'>");      
                        print("<input type=\"hidden\" name=\"cid\" value='" . $value . "'>");
                }
                else if($key == 'Course'){
                        print("<input type='submit' value='" . $value . "'>");                   
                        print("</form></th>");                  
                }
                else{
                        print ("<td>" . $value . "</td>"); # One item in row
          }}
          print ("</tr>\n");
        }
        print("</table></div>\n");
        mysqli_free_result($te_result);

        print("<br>");
        print("<h4>TA</h4>");
		$ta_query = "select cid,cnumber AS Course,c_name AS Name,semester AS Semester,year AS Year from class JOIN course USING(cnumber) JOIN ta USING (cid) WHERE ta_pid='" . $id . "'ORDER BY year DESC,semester,c_name;";
        if ( ! ( $ta_result = mysqli_query($conn, $ta_query)) ) { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
        }

        print("<div><table class=\"table table-striped\"\n");
        $header = false;
        while ($row = mysqli_fetch_assoc($ta_result)) {
          if (!$header) {
            print("<!-- print header once -->");
            $header = true;
            print("<thead class=\"table-dark\"><tr>\n");
            foreach ($row as $key => $value)
               if($key != 'cid'){
                print "<th>" . $key . "</th>";}
            print("</tr></thead>\n");
          }
          print("<tr>\n");     
          foreach ($row as $key => $value) {
                if($key == 'cid'){
                        print "<th>";
                        print("<form action=\"tcourse.php\" method=\"post\">");
                        print("<input type=\"hidden\" name=\"pid\" value='" . $id . "'>");      
                        print("<input type=\"hidden\" name=\"cid\" value='" . $value . "'>");
                }
                else if($key == 'Course'){
                        print("<input type='submit' value='" . $value . "'>");                   
                        print("</form></th>");                  
                }
                else{
                        print ("<td>" . $value . "</td>"); # One item in row
          }}
          print ("</tr>\n");
        }
        print("</table></div>\n");
		mysqli_free_result($ta_result);

		mysqli_close($conn);
      ?>

        <br>
		<br>
        <h5> Transcript </h5>
        <form action="transcript.php" method="post">
        <?php
                print("<input type=\"hidden\" name=\"pid\" value='" . $id . "'>");      
        ?>
        <input type='submit' value='Apply'>
        </form> 

    </div>
  </body>
</html>