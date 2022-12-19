<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Q&A</title>
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
		$tag = $_POST['tag'];
		
		$co_query = "select cnumber,c_name,semester,year FROM class JOIN course USING (cnumber) WHERE cid='".$cid."'";  
        if ( ! ( $co_result = mysqli_query($conn, $co_query)) ) { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
        }

        echo("<br><h3>");
        while ($row = mysqli_fetch_assoc($co_result)) {        
                foreach ($row as $key => $value) {
                        print ($value . " "); 
                }
        }       
        echo("</h3><br>\n");
        mysqli_free_result($co_result);

		print("<button type=\"button\" class=\"btn btn-outline-secondary\">" . $tag . "</button><br><br>");	

		$question_query = "select title AS Title, qtext, date AS Posted FROM hastag JOIN question USING (cid,title) WHERE cid='".$cid."' AND t_name='". $tag . "' ORDER BY date DESC;";  

        if ( ! ( $question_result = mysqli_query($conn, $question_query)) ) 
        { 
                printf("Error: %s\n", mysqli_error($conn)); 
                exit(1); 
         }

	
		print("<div><table class=\"table table-striped\">\n");
        $header = false;
        while ($row = mysqli_fetch_assoc($question_result)) {
          if (!$header) {
            $header = true;
            print("<thead class=\"table-dark\"><tr>\n");
            foreach ($row as $key => $value){
                if($key=="qtext"){}
                else{           
                        print "<th>" . $key . "</th>";
            }}
			print("<th>Detail</th>");
            print("</tr></thead>\n");
          }
          print("<tr>\n");     
          foreach ($row as $key => $value) {
                if($key=="Title"){
                        print ("<td><details><summary>".$value."</summary>");
						$title = $value;
                }
                else if ($key == "qtext"){
                        print("<p>".$value."</p></details></td>");
                }
                else{
                        print ("<td>" . $value . "</td>"); 
          }}
		 print("<td><form action=\"reply.php\" method=\"post\">");
         print("<input type=\"hidden\" name=\"pid\" value='" . $pid . "'>");      
         print("<input type=\"hidden\" name=\"cid\" value='" . $cid . "'>");
		 print("<input type=\"hidden\" name=\"title\" value='" . $title . "'>");
         print("<input type='submit' value='Check'>");                   
         print("</form></td>");
         print ("</tr>\n");   
        }
        print("</table></div>\n");
        print("<br>");

		mysqli_free_result($question_result);
		mysqli_close($conn);
		?>
      </div>
  </body>
</html>