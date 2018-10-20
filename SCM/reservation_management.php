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
	<script>
		$(document).ready(function(){
			$('button').on('click',function(event){
				event.target.closest('form').submit();
			});
		});
	</script>
</head>
<body>
  	<div class="container-fluid">
	    <h1>New reservation</h1>
	    <hr/>
		<?php
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$parts = parse_url($actual_link);
			parse_str($parts['query'], $query);
			
			echo "<form action=\"make_reservation.php\">
					<div class=\"row form-group\">
						<div class=\"col-xs-1\">
							<label>Hour</label>
						</div>
						<div class=\"col-xs-2\">
							<label class=\"form-control\" type=\"text\" name=\"hour\">".$query['hour']."</label>
						</div>
						<div class=\"col-xs-1\">
							<label>Date</label>
						</div>
						<div class=\"col-xs-2 form-group\">
							<label class=\"form-control\" type=\"text\">".$query['date']."-0".$query['month']."-".$query['year']."</label>
							<input id=\"date\" type=\"hidden\" name=\"date\" value=\"".$query['date']."\" />
							<input type=\"hidden\" name=\"hour\" value=\"".$query['hour']."\" />
							<input type=\"hidden\" name=\"month\" value=\"".$query['month']."\" />
							<input type=\"hidden\" name=\"year\" value=\"".$query['year']."\" />
							<input type=\"hidden\" name=\"club_id\" value=\"".$query['club_id']."\" />
						</div>
						<div class=\"col-xs-1\">
							<label>Court</label>
						</div>
						<div class=\"col-xs-2 form-group\">
							<input class=\"form-control\" type=\"text\" name=\"court_id\"/>
						</div>
						<div class=\"col-xs-3\">
							<button type=\"submit\" class=\"button-primary\">Make reservation</button>
						</div>
					</div>
				</form>";
		?>
	</div>
</body>
</html>