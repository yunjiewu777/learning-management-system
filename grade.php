<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Teaching Staff Grading Page</title>
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
        $cid = $_POST['cid']; 
        $pid = $_POST['stuid']; 

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

        $name_query = "select fname,lname FROM person WHERE pid='". $pid . "';";
        if (!( $name_result = mysqli_query($conn, $name_query))){
          printf("Error: %s\n", mysqli_error($conn));
          exit(1);
        }
        print("<h4\n>");
        while ($row = mysqli_fetch_assoc($name_result)) {        
                foreach ($row as $key => $value) {
                        print ($value . " "); 
                }
        }
        print ("</h4>\n");
		mysqli_free_result($name_result);

        $grade_query = "select c_grade FROM take WHERE cid='".$cid."' AND take_pid ='" . $pid . "';";

        if ( ! ( $grade_result = mysqli_query($conn, $grade_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }

        while ($row = mysqli_fetch_assoc($grade_result)) {        
                foreach ($row as $key => $value) {
                        $grade = $value; 
                }
        }
		mysqli_free_result($grade_result);

		if($grade != ""){
			echo("<br><h4>Final Grade: " . $grade. "</h4><br>");
		}
		else {
		 
            	print("<form action=\"check_letter.php\" method=\"post\">");
                print("<div class=\"row mb-3\">");
		print("<label for=\"grade\" class=\"col-sm-2 col-form-label col-form-label-lg\"> Final Grade: </label>");
		print("<div class=\"col-sm-10\">");
		print("<input type=\"text\" class=\"form-control form-control-lg\" id=\"grade\" name=\"grade\" required>");
		print("<input type=\"hidden\" name=\"pid\" value='" . $pid . "'>");      
		print("<input type=\"hidden\" name=\"cid\" value='" . $cid . "'>");
		print("</div>");
                print("</div>");
                print("<div class=\"form-group\">");
                    print("<button type=\"submit\" class=\"btn btn-primary\">Submit</button>");
                print("</div>");
                print("</form><br><br>");	
	}

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
		mysqli_free_result($ass_result);
	?>

	<h5> Grade Assignment</h5>
	<form class="row g-3 needs-validation" action="grade_a.php" method="post">
	<div class="col-md-6">
    <label for="assign" class="form-label">Assignment</label>
    <select class="form-select" id="assign" name="assign" required>
      <option selected="" disabled="" value="">Choose...</option>

	<?php

	$assign_query = "select a_name From assignment WHERE cid='" . $cid . "' ORDER BY duedate,a_name;";
        echo($assign_query); 
        if ( ! ( $assign_result = mysqli_query($conn, $assign_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }

		while ($row = mysqli_fetch_assoc($assign_result)) {        
                foreach ($row as $key => $value) {
                        print ("<option>" . $value . "</option>"); 
                }
        }
		
		mysqli_free_result($assign_result);
		
		print("<input type=\"hidden\" name=\"pid\" value='" . $pid . "'>");    
		print("<input type=\"hidden\" name=\"cid\" value='" . $cid . "'>");

		mysqli_close($conn);
	?>
	</select>
  </div>

  <div class="col-md-6">
    <label for="gra" class="form-label">Grade</label>
    <input type="number" class="form-control" name= "gra" id="gra" required>
  </div>
  <div class="col-12">
    <button type="reset" class="btn btn-primary">Reset</button>
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</form>
	<br>
	</div>
  </body>
</html>
