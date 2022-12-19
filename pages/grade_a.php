<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Grading Assignment</title>
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
        $grade = $_POST['gra'];
		$name = $_POST['assign'];

		$grade_query = "INSERT INTO grade VALUES ('". $name . "','" . $pid . "'," . $grade . ",'" . $cid . "');";

        if ( ! ( $grade_result = mysqli_query($conn, $grade_query)) ) {	
	          printf("Error: %s\n", mysqli_error($conn)); 
              exit(1);    
		}
		else{
			print("<div class=\"alert alert-success\" role=\"alert\">");
            print("Successfully Graded!");
            print("</div>");
         }
		 mysqli_free_result($grade_result);
		 mysqli_close($conn);
       ?>

    </div>
  </body>
</html>