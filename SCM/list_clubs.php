<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:400,300,600" />
  	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css" />
  	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css" />
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"></link>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Clubs application</title>
	<script>
		$(document).ready(function(){
			$('div.row.club').on('click',function(event){
				event.target.closest("form").submit();
			});
		});
	</script>
</head>
<body>
<div class="container-fluid">
	    <h1>Club list</h1>
	    <hr/>
	    <div class="row">
	      		<div class="col-md-4">
		        	<label>Club name</label>
	      		</div>
	      		<div class="col-md-4">
		          	<label>Number of courts</label>
	      		</div>
	    </div>
<?php

	require'db.php';
	
	$sql = "SELECT id, name, number_of_courts FROM club";
    $result = db::getInstance()->get_result($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			echo "<div class=\"row club\">
				<form action=\"club_calendar.php\">
					<div class=\"col-md-4\">
						<input type=\"hidden\" name=\"club_id\" value=\"". $row["id"] ."\" />
						<label class=\"form-control\" type=\"text\" name=\"name\">". $row["name"] ."</label>
					</div>
					<div class=\"col-md-4\">
						<label class=\"form-control\" type=\"text\" name=\"numberOfCourts\">". $row["number_of_courts"] ."</label>
					</div>
				</form>
			</div>";
					
		}
	}

?> 

</body>
</html>