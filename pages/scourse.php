<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Student Course Page</title>
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

        $grade_query = "select c_grade FROM take WHERE cid='".$cid."' AND take_pid ='" . $pid . "';";
        if ( ! ( $grade_result = mysqli_query($conn, $grade_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }
        echo("<br><h4>Final Grade: ");
        while ($row = mysqli_fetch_assoc($grade_result)) {        
                foreach ($row as $key => $value) {
                        print($value); 
                }
        }       
        echo("</h4><br>");
		mysqli_free_result($grade_result);

	
		$ass_query = "SELECT a_name AS Assignment,text,duedate AS Due_Date,total_p AS Total_Point,(SELECT a_grade FROM grade WHERE stu_pid='" . $pid . "' AND grade.a_name = assignment.a_name AND cid='" .$cid. "') AS Grade FROM assignment WHERE cid='" . $cid . "'ORDER BY duedate,Assignment;"; 
		if ( ! ( $ass_result = mysqli_query($conn, $ass_query)) ) 
		{ 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }

		print("<div><table class=\"table table-striped\"\n");
        $header = false;
        while ($row = mysqli_fetch_assoc($ass_result)) {
          if (!$header) {
            print("<!-- print header once -->");
            $header = true;
            print("<thead class=\"table-dark\"><tr>\n");
            foreach ($row as $key => $value){
				if($key=="text"){}
				else{		
					print "<th>" . $key . "</th>";
				}
			}
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
			}
		   }
		   print ("</tr>\n");   
        }
        print("</table></div>\n");
		mysqli_free_result($ass_result);

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