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
  	<title>Clubs calendar</title>
  	<style>

	div.cell {
	    width: 100px;
	    height: 50px;
	    border: 1px solid black;
	    padding: 0px;
	    margin: 0px;
	    text-align: center;
		vertical-align: middle;
		line-height: 50px;
	}
	
	div.free-day {
	    background-color: #C3E8A6;
	}
	
	div.free-weekend {
	    background-color: #AFDD8A;
	}
	
	div.taken-day {
	    background-color: #E8A6A6;
	}
	
	div.taken-weekend {
	    background-color: #E29898;
	}
	
	div.header-day {
	    width: 100px;
	    height: 75px;
	    background-color: #F6F6F6;
	    border: 1px solid black;
	    padding: 0px;
	    margin: 0px;
	    text-align: center;
		vertical-align: middle;
		line-height: 40px;
	}
	
	div.header-weekend {
	    width: 100px;
	    height: 75px;
	    background-color: #E9E9E9;
	    border: 1px solid black;
	    padding: 0px;
	    margin: 0px;
	    text-align: center;
		vertical-align: middle;
		line-height: 40px;
	}
	
	div.header-hour {
	    background-color: #F6F6F6;
	}
	
	div.passed-hour {
	    background-color: #E9E9E9;
	}
	
	#myDialog { display: none; }
	
	#dummyDate {
	    opacity: 0;
	    position: absolute;
	    top: 0;
	    left: 0;    
	}
	</style>
	<script>
		$(document).ready(function(){
			$('div.cell.free-day, div.cell.free-weekend').on('click',function(event){
				event.target.closest("form").submit();
			});
		});
	</script>
</head>
<body>
  	<div class="container-fluid">
		<?php
		require'db.php';
	
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$parts = parse_url($actual_link);
		parse_str($parts['query'], $query);
		
		$sql = "SELECT id, name, number_of_courts FROM club where id = ".$query['club_id'];
		$result = db::getInstance()->get_result($sql);
		
		$club = array();
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$club = $row;
				echo "<h1>Club calendar for <span>".$row['name']."</span></h1><hr/>";
			}
		}
				
		$sql = "SELECT * FROM reservation where club_id = ".$query['club_id'];
		$result = db::getInstance()->get_result($sql);
		$reservations = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($reservations, $row);
			}
		}
		
		$cells = array();
		
		for ($h = 8; $h <= 22; $h++){
			array_push($cells, array());
			array_push($cells[$h - 8], $h);
			for ($d = date("d"); $d <= (date("d") + 7); $d++){
				array_push($cells[$h - 8], array($h , $d, $club['number_of_courts']));
			}
		}
		
		foreach ($reservations as $res) {
			$hourIndex = $res['hour'] - 8;
			$dateIndex = $res['date'] - date("d") + 1;
			if ($dateIndex>0){
				$cells[$hourIndex][$dateIndex][2] = ($cells[$hourIndex][$dateIndex][2] - 1);
			}
		}
								
		echo "<div class=\"row\"><div class=\"col-xs-1 cell header-hour\"><label></label></div>";
		for ($d = 0; $d < 7; $d++){
			echo "<div class=\"col-xs-1 cell header-hour\" id=\"cell\" th:title=\"title}\">
					<label type=\"text\" name=\"content\" th:text=\"headerText\">".(date("d") + $d)."-".date("m")."-".date("Y")."</label>
				</div>";
		}
		echo "</div>";
		for ($h = 0; $h < 14; $h++){
			echo "<div class=\"row\"><div class=\"col-xs-1 cell header-hour\"><label>".($h+8)."</label></div>";
			for ($d = 0; $d < 7; $d++){
				echo $cells[$h][0][2];
				echo "<div class=\"col-xs-1 cell free-day\" id=\"cell_".(date("d") + $d)."_".date("m")."_".date("Y")."_".($h+8)."\" th:title=\"title}\">
							<form id=\"new_reservation\" th:method=\"post\" action=\"reservation_management.php\">
								<label type=\"text\" name=\"content\">".$cells[$h][$d+1][2]."</label>
								<input type=\"hidden\" name=\"hour\" value=\"".($h+8)."\" />
								<input type=\"hidden\" name=\"date\" value=\"".($d+date("d"))."\" />
								<input type=\"hidden\" name=\"month\" value=\"3\" />
								<input type=\"hidden\" name=\"year\" value=\"2018\" />
								<input type=\"hidden\" name=\"club_id\" value=\"1\" />
							</form>
						</div>";
			}
			echo "</div>";
		}
		?>
	</div>
</body>
</html>