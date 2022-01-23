<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Posting Reply</title>
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

        $cid = $_POST['cid']; 
        $pid = $_POST['pid'];
		$time = $_POST['time'];
		$title = $_POST['title'];
		$text = $_POST['text'];


		if(strlen(trim($text)) == 0){
                print "<div class=\"alert alert-warning\" role=\"alert\">";
                echo("Only Spaces are not Acceptable. Reply Something Else.");
				print "</div>";	
		}
		else{
			$num_query = "select count(*) FROM reply WHERE time <'" . $time . "' AND cid='".$cid."' AND title = '" . $title . "';";  
			if ( ! ( $num_result = mysqli_query($conn, $num_query)) ) 
			{ 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
			}

			while ($row = mysqli_fetch_assoc($num_result)) {        
               foreach ($row as $key => $value) {
                        $rnum = $value+1;
               }
			}
			mysqli_free_result($num_result);

			$insert_query = "INSERT INTO reply VALUES (". $rnum . ",'" .$text. "','" . $time . "','" . $pid . "','" . $title . "','" . $cid . "')";

			  if ( ! ( $insert_result = mysqli_query($conn, $insert_query)) ) 
				{                       
					printf("Error: %s\n", mysqli_error($conn)); 
					exit(1); 
				}		 

			mysqli_free_result($insert_result);
			
			print("<div class=\"alert alert-success\" role=\"alert\">");
			print("Successfully Posted!");
			print("</div>");}
	
		mysqli_close($conn);
		?>
      </div>
  </body>
</html>