<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Q&A Summary</title>
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
        echo(" Q&A</h3><br>");
		mysqli_free_result($co_result);

		print "<h5>Supported Tag:</h5>";

		$tag_query = "select t_name FROM tag WHERE cid='".$cid."'";  

        if ( ! ( $tag_result = mysqli_query($conn, $tag_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }

		print("<div class=\"col-sm-10 offset-sm-2 row\">");
        echo("<div class=\"row row-cols-4\">");

        while ($row = mysqli_fetch_assoc($tag_result)) {        
                foreach ($row as $key => $value) {
						print("<div class = \"col\"> \n <form action=\"qa.php\" method=\"post\">");
                        print("<input type=\"hidden\" name=\"pid\" value='" . $pid . "'>");      
                        print("<input type=\"hidden\" name=\"cid\" value='" . $cid . "'>");
						print("<input type=\"hidden\" name=\"tag\" value='" . $value . "'>");
                        print("<input type='submit' value='" . $value . "'>");                   
                        print("</form> </div>\n");
				}
        }       
		
		echo ("</div></div><br>");
		mysqli_free_result($tag_result);
	?>
<div>
<h5>Post Question:</h5>
<form action="create_q.php" method="post">
  <div class="row mb-3">
    <label for="title" class="col-sm-2 col-form-label">Title</label>
    <div class="col-sm-10">
      <input type="text" name="title" class="form-control" id="title" required>
    </div>
  </div>
  <div class="row mb-3">
    <label for="text" class="col-sm-2 col-form-label">Content</label>
    <div class="col-sm-10">
      <textarea class="form-control" name="text" id="text" rows="3" required></textarea>
    </div>
  </div>

  <div class="row mb-3">
    <label for="ch" class="col-sm-2 col-form-label">Tag</label>
    <div class="col-sm-10 offset-sm-2 row">
<?php
	$t_query = "select t_name FROM tag WHERE cid='".$cid."'";  
        if ( ! ( $t_result = mysqli_query($conn, $t_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }

        while ($row = mysqli_fetch_assoc($t_result)) {        
                foreach ($row as $key => $value) {
			print ("<div class=\"form-check col-md-3\">");
                        print ("<input type=\"checkbox\"  name= \"tag[]\" class=\"form-check-input\" id=\"" . $value . "\" value=\"" . $value . "\"  >\n");
			print ("<label class=\"form-check-label\" for=\"" . $value . "\">" . $value . "</label>\n");
			print ("</div>");
                }
        }
		mysqli_free_result($t_result);
		mysqli_close($conn);
?>
    </div>
  </div>     
  
<?php
            print("<input type=\"hidden\" name=\"pid\" value='" . $pid . "'>");    
			print("<input type=\"hidden\" name=\"cid\" value='" . $cid . "'>");
			$time = date("Y-m-d H:i:s");
			print("<input type=\"hidden\" name=\"time\" value='" . $time . "'>");   
?>
  <button type="reset" class="btn btn-primary">Reset</button>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

		</div>        
      </div>
  </body>
</html>
