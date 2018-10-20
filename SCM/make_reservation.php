<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:th="http://www.thymeleaf.org">
<head>
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:400,300,600" />
  	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css" />
  	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css" />
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  	<title>Reservation management</title>
</head>
<body>
  	<div class="container-fluid">
	    <h1>New reservation</h1>
	    <hr/>
		<?php
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$parts = parse_url($actual_link);
			parse_str($parts['query'], $query);
			echo "<div class=\"row\">
						<div class=\"col-xs-10\">
							Reservation for ".$query['date']."-0".$query['month']."-".$query['year']." - ".$query['hour']." court ".$query['court_id']." successfully made
						</div>
					</form>
				</div>";
		?>
	</div>
</body>
</html>