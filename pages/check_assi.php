<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Creating New Assignment</title>
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

        $name = $_POST['name']; 
        $due = $_POST['due'];
        $point = $_POST['point'];
        $text = $_POST['text']; 
		$cid = $_POST['cid'];
 
        $cassi_query = "INSERT INTO assignment VALUES ('" .$cid. "','" . $name . "','" . $due . "','" . $text . "'," . $point . ");";

        if ( ! ( $cassi_result = mysqli_query($conn, $cassi_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
        }

        else{
                print("<div class=\"alert alert-success\" role=\"alert\">");
				print("Successfully Created <e>" . $name . "</e>!");
                print("</div>");
		
		}

		mysqli_free_result($cassi_result);
		mysqli_close($conn);
	?>

    </div>
  </body>
</html>