<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Student Transcript</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity>
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
		
        $pid = $_POST['pid']; 

		$semester_query = "select DISTINCT semester,year FROM class JOIN take USING(cid) WHERE take_pid='".$pid."' ORDER BY year,semester;";
		
        if ( ! ( $semester_result = mysqli_query($conn, $semester_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }


		$rowcount=mysqli_num_rows($semester_result); 
        if($rowcount == 0){
                print "<div class=\"alert alert-warning\" role=\"alert\">";
                print("You didn't take any courses.");
                print "</div>";
        }

        else{
		
		print "<h3 class=\"text-center\">";		
        $name = "select fname,lname FROM person WHERE pid='". $pid . "';";
        if (!( $name_result = mysqli_query($conn, $name))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
        while ($row = mysqli_fetch_assoc($name_result)) {        
                foreach ($row as $key => $value) {
                        print ($value . " "); 
                }
        }
		print " -- Transcript</h3>";
		mysqli_free_result($name_result);
	
       while ($row = mysqli_fetch_assoc($semester_result)) {     
          foreach ($row as $key => $value) {
			  print("<br><h4>");
			  if($key == "semester"){
				$semester = $value;
			  }
			  else{
				$year = $value;
			  }     
          }

		  print($semester . " " . $year ."</h4>");  

		  $query = "select cnumber AS Course, c_name AS Name, c_grade AS Grade FROM class JOIN course USING(cnumber) JOIN take USING(cid) WHERE take_pid='".$pid."' AND semester='" . $semester . "' AND year = " . $year . " ORDER BY Name;";

		  if ( ! ( $result = mysqli_query($conn, $query)) ) 
		  { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
		  }

		print("<table class=\"table table-striped\">\n");
		$header = false;
        while ($rowone = mysqli_fetch_assoc($result)) {
			if (!$header) {
			  $header = true;
              print("<thead class=\"table-dark\"><tr>\n");
              foreach ($rowone as $key => $value){          
				print "<th>" . $key . "</th>";
			  }
				print("</tr></thead>\n");
			}
        print("<tr>\n");    
			foreach ($rowone as $key => $value) {
				print ("<td>" . $value . "</td>");
			}
            print ("</tr>\n");  
        }
        print("</table>\n");
		mysqli_free_result($result); 
        }
		mysqli_free_result($semester_result);
		}		 
		mysqli_close($conn);
		?>
	</div>
  </body>
</html>