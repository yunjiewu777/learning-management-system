<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Question Detail</title>
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
		$title = $_POST['title'];

		$co_query = "select cnumber,c_name,semester,year FROM class JOIN course USING (cnumber) WHERE cid='".$cid."'";  
        if ( ! ( $co_result = mysqli_query($conn, $co_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
        }

        echo("<br><h3>");
        while ($row = mysqli_fetch_assoc($co_result)) {        
                foreach ($row as $key => $value) {
                        print ($value . " "); 
                }
        }       
        echo("</h3><br><br>\n");
        mysqli_free_result($co_result);

		$qe_query = "select qtext, fname, lname, date FROM question JOIN person WHERE ask_pid = pid AND cid='".$cid."' AND title='". $title . "';";  

		if ( ! ( $qe_result = mysqli_query($conn, $qe_query)) ) 
		{ 
			printf("Error: %s\n", mysqli_error($conn)); 
			exit(1); 
		}

		while ($row = mysqli_fetch_assoc($qe_result)) { 
			print("<div class=\"card border-primary text-primary\"> \n <div class=\"card-body\"> \n");
			print("<h5 class=\"card-title\"><b>" . $title . "</b></h5>");
                foreach ($row as $key => $value) {
					if($key=="qtext"){
						print("<p class=\"card-text\">" . $value . "</p> \n	</div> \n <div class=\"card-footer text-muted\"> Posted By: ");
					}
					else if($key=="fname"){
						print($value. ", "); 
					}
					else if($key=="lname"){
						print($value . "    ");
					}
					else{
						print ($value . "</div> \n </div><br><br>"); 
					}      
                }
		}
		mysqli_free_result($qe_result);

		$re_query = "select rnum, rtext, fname, lname, time FROM reply JOIN person WHERE answer_pid = pid AND cid='".$cid."' AND title='". $title . "' ORDER BY time;"; 
		if ( ! ( $re_result = mysqli_query($conn, $re_query)) ) 
		{ 
			printf("Error: %s\n", mysqli_error($conn)); 
			exit(1); 
		}

		while ($row = mysqli_fetch_assoc($re_result)) { 
			print("<div class=\"card\"> \n <div class=\"card-header\"> \n");
                foreach ($row as $key => $value) {
					if($key=="rnum"){
						print("Reply ". $value . "</div> \n <div class=\"card-body\"> \n <p class=\"card-text\">");
					}
					else if($key =="rtext"){
						print($value . "</p> \n </div> \n <div class=\"card-footer text-muted\">Posted By: \n");
					}
					else if($key=="fname"){
						print($value. ", "); 
					}
					else if($key=="lname"){
						print($value . "    ");
					}
					else{
						print ($value . "</div> \n </div><br> \n"); 
					}      
                }
			}
		mysqli_free_result($re_result);
		mysqli_close($conn);
	?>

<br>
<h5>Post Reply: </h5>
<form action="create_reply.php" method="post">
      <textarea class="form-control" name="text" id="text" rows="3" required></textarea>
<?php
      print("<input type=\"hidden\" name=\"pid\" value='" . $pid . "'>");      
      print("<input type=\"hidden\" name=\"cid\" value='" . $cid . "'>");
	  print("<input type=\"hidden\" name=\"title\" value='" . $title . "'>");
      
	  $t = date("Y-m-d H:i:s");
      print("<input type=\"hidden\" name=\"time\" value='" . $t . "'>");   
?>
  <button type="reset" class="btn btn-primary">Reset</button>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<br>

      </div>
  </body>
</html>
