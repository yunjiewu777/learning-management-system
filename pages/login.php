<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    
	<body>
    <div class="container">
	<div class="position-absolute top-50 start-50 translate-middle">
            <h3 class= "text-center">Welcome!</h3>
		    <br>

            <form action="check.php" method="post">
            <div class="row mb-3">
		    <div class="col-sm-10">		    
				<input type="text" class="form-control" placeholder="User ID"  name="stuid" required>
		    </div>
		    </div >
			
			<div class="row mb-3">
		    <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="Login ID"  name="logid" required>
		    </div>
			</div>
    
			<div class="form-group">
				<button type="reset" class="btn btn-primary">Reset</button>
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            </form>
	</div>
    </div>
    </body>
</html>