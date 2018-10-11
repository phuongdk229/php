<?php
if (!defined('APP_PATH')) {
	die('can not access');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">
	<style type="text/css">
		form{
			border: 1px solid #ccc;
			padding: 20px;
			border-radius: 5px;
		}
	</style>	
</head>
<body>
	<div class="container">
		<h3 class="text-center">Customer-Login</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-6 offset-3">
					<form action="?c=login&m=handle" method="POST">
						<div class="form-group">
							<label for="txtEmail">Email</label>
							<input type="text" name="txtEmail" class="form-control" placeholder="Enter Username">
						</div>
						<div class="form-group">
							<label for="txtPass">Pass Word</label>
							<input type="password" name="txtPass" placeholder="Enter Password" class="form-control" >
						</div>
						<button type="submit" class="btn btn-primary" name="btnSubmit">Login</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>