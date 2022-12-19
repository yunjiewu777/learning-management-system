<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Course Final Grade</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity=
"sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
        
        $cid = $_POST['cid'];  
        $pid = $_POST['pid'];
		$grade = $_POST['grade'];

		$grade_query = "select c_grade FROM take WHERE cid='".$cid."' AND take_pid ='" . $pid . "';";
        if ( ! ( $grade_result = mysqli_query($conn, $grade_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }
        while ($row = mysqli_fetch_assoc($grade_result)) {        
                foreach ($row as $key => $value) {
                        $g = $value; 
                }
        }
		mysqli_free_result($grade_result);

        if($g != ""){
			print("<div class=\"alert alert-warning\" role=\"alert\">");
			print("Already Graded. Please refresh the page!");
			print("</div>");
        }
        else {

        $query = "UPDATE take SET c_grade = '" . $grade . "' WHERE cid = '" . $cid . "' AND take_pid='" . $pid. "';"; 

        if ( ! ( $result = mysqli_query($conn, $query)) ) 
        {                       
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
        }       

		else {
			print("<div class=\"alert alert-success\" role=\"alert\">");
			print("Successfully Graded!");
			print("</div>");
		}
		mysqli_free_result($result);
		}

		mysqli_close($conn);
       ?>

    </div>
  </body>
</html>