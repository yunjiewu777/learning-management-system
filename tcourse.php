<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Teaching Staff Page</title>
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
		echo("</h3><br>");
		mysqli_free_result($co_result);
	?>

	<h4> Assignment </h4>
		<form action="check_assi.php" method="post">
                <div class="form-group">
                    <label for="name">Assignment Name:</label>
                    <input type="text"  name="name" required>
                    <br>
                    <label for="text">Text:</label>
                    <input type="text"  name="text" required>
                    <br>
                    <label for="due">Due Date:</label>
                    <input type="date"  name="due" required>
                    <br> 
                    <label for="point">Total point:</label>
                    <input type="number"  name="point" required>
	<?php               
		print("<input type=\"hidden\" name=\"cid\" value='" . $cid . "'>");
	?>          
	        </div>
                <div class="form-group">
                    <button type="reset" class="btn btn-primary">Reset</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
	<br>

	<?php

		$as_query = "select a_name AS Assignment,text, duedate AS Due_Date, total_p AS Total_Point FROM assignment WHERE cid='" . $cid . "'ORDER BY duedate,Assignment;";
        
        if ( ! ( $as_result = mysqli_query($conn, $as_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }

        print("<div><table class=\"table table-striped\"\n");
        $header = false;
        while ($row = mysqli_fetch_assoc($as_result)) {
          if (!$header) {
            print("<!-- print header once -->");
            $header = true;
            print("<thead class=\"table-dark\"><tr>\n");
            foreach ($row as $key => $value){
                if($key=="text"){}
                else{           
                        print "<th>" . $key . "</th>";
            }}
            print("</tr></thead>\n");
          }
          print("<tr>\n");     
          foreach ($row as $key => $value) {
                if($key=="Assignment"){
                        print ("<td><details><summary>".$value."</summary>");
                }
                else if ($key == "text"){
                        print("<p>".$value."</p></details></td>");
                }
                else{
                        print ("<td>" . $value . "</td>"); 
          }}
          print ("</tr>\n");   
        }
        print("</table></div>\n");
		print("<br>");
		mysqli_free_result($as_result);

		print("<h4>Student</h4>");
		$stu_query = "select fname, lname, take_pid AS Student_ID FROM take JOIN person WHERE pid=take_pid AND cid = '" . $cid ."';";
		if ( ! ( $stu_result = mysqli_query($conn, $stu_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }

		print("<div><table class=\"table table-striped\"\n");
		print("<!-- print header once -->");
		print("<thead class=\"table-dark\"><tr>\n");
		print("<th>Name</th>\n");
		print("<th>ID</th>\n");
		print("<th>Detail</th>\n");
		print("</tr></thead>\n");

        while ($row = mysqli_fetch_assoc($stu_result)) {
          print("<tr>\n");    
          foreach ($row as $key => $value) {
		if($key=="fname"){
			print ("<td>".$value.", ");
		}
		else if ($key == "lname"){
			print($value."</td>");
		}
		else if ($key == "Student_ID"){
                 	 print("<td>" . $value . "</td>");
			 print("<td><form action=\"grade.php\" method=\"post\">");
                         print("<input type=\"hidden\" name=\"stuid\" value='" . $value . "'>");      
                         print("<input type=\"hidden\" name=\"cid\" value='" . $cid . "'>");
                         print("<input type='submit' value='Check'>");
                         print("</form></td>");
		}
		}
			print ("</tr>\n");   
        }
        print("</table></div>\n");
		mysqli_free_result($stu_result);
		mysqli_close($conn);
      ?>

        <br>
        <h4> Q&A </h4>
        <form action="question.php" method="post">
        <?php
                print("<input type=\"hidden\" name=\"pid\" value='" . $pid . "'>");      
                print("<input type=\"hidden\" name=\"cid\" value='" . $cid . "'>");
        ?>
        <input type='submit' value='Go!'>
        </form>
		<br>
	</div>
  </body>
</html>