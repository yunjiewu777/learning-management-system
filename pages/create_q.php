<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Posting Question</title>
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

        $title = $_POST['title']; 
        $text = $_POST['text'];
        $time = $_POST['time'];
		$pid = $_POST['pid'];
        $cid = $_POST['cid'];
		$tag = $_POST['tag'];		

		if(empty($tag)){
                print "<div class=\"alert alert-warning\" role=\"alert\">";
                echo("Please Choose at Least One Tag.");
                print "</div>";       
        }

		else{
		$qu_query = "INSERT INTO question VALUES ('" .$time. "','" . $title . "','" . $text . "','" . $pid . "','" . $cid . "')";

        if ( ! ( $qu_result = mysqli_query($conn, $qu_query)) ) 
        { 			
        	printf("Error: %s\n", mysqli_error($conn)); 
            exit(1); 
        }	
		mysqli_free_result($qu_result);


		foreach($tag as $value){
			$tname = $value;
			$insert_query = "INSERT INTO hastag VALUES ('" .$tname. "','" . $title . "','" . $cid ."')";

			if ( ! ( $insert_result = mysqli_query($conn, $insert_query)) ) 
			{ 			
        		printf("Error: %s\n", mysqli_error($conn)); 
				exit(1); 
			}			
		}

		mysqli_free_result($insert_result);

		print("<div class=\"alert alert-success\" role=\"alert\">");
        	print("Successfully Posted!");
        	print("</div>");	

		}

		mysqli_close($conn);
	?>

    </div>
  </body>
</html>
