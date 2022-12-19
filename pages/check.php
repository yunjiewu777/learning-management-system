<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Checking Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>

  <body onload="document.form1.submit()">
    <div class="container">
        <?php
        $conn = mysqli_connect("localhost",
                               "cs377", "ma9BcF@Y", "canvas");  
        if (mysqli_connect_errno()) {
          printf("Connect failed: %s\n", mysqli_connect_error());
          exit(1);
        }
        
        $logid = $_POST['logid'];  
        $pid = $_POST['stuid'];
        $query = "SELECT * FROM person WHERE pid='" . $pid . "' AND log_id = '" . $logid . "';";
        
        if ( ! ( $result = mysqli_query($conn, $query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
        }  
	
		$rowcount=mysqli_num_rows($result); 
		if($rowcount == 0){
			print "<div class=\"alert alert-warning\" role=\"alert\">";
        	echo("Wrong User ID or Login ID. Please Try again.");
			print "</div>";
		}
		else{
         	print("<form action=\"login_bk.php\" method=\"post\" name=\"form1\">");
        	print("<input type=\"hidden\" name=\"pid\" value='" . $pid . "'>");
         	print("</form>");
		}
		
		mysqli_free_result($result);
		mysqli_close($conn);
		?>

    </div>
  </body>
</html>