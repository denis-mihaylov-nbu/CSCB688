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
	<style>
	/* Methods */
.method .header, .method .cell {
  padding: 6px 6px 6px 10px; }
.method .list-header .header {
  font-weight: normal;
  text-transform: uppercase;
  font-size: 0.8em;
  color: #999;
  background-color: #eee; }
.method [class^="row"],
.method [class*=" row"] {
  border-bottom: 1px solid #ddd; }
  .method [class^="row"]:hover,
  .method [class*=" row"]:hover {
    background-color: #f7f7f7; }
.method .cell {
  font-size: 0.85em; }
  .method .cell .mobile-isrequired {
    display: none;
    font-weight: normal;
    text-transform: uppercase;
    color: #aaa;
    font-size: 0.8em; }
  .method .cell .propertyname {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; }
  .method .cell .type {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; }
  .method .cell code {
    color: #428bca; }
  .method .cell a, .method .cell a:hover {
    text-decoration: none; }
  .method .cell code.custom {
    color: #8a6d3b;
    text-decoration: none; }
  .method .cell .text-muted {
    color: #ddd; }
@media (max-width: 991px) {
  .method [class^="row"],
  .method [class*=" row"] {
    padding-top: 10px;
    padding-bottom: 10px; }
  .method .cell {
    padding: 0 10px; }
    .method .cell .propertyname {
      font-weight: bold;
      font-size: 1.2em; }
      .method .cell .propertyname .lookuplink {
        font-weight: normal;
        font-size: 1.5em;
        position: absolute;
        top: 0;
        right: 10px; }
    .method .cell .type {
      padding-left: 10px;
      font-size: 1.1em; }
    .method .cell .isrequired {
      padding-left: 10px;
      display: none; }
    .method .cell .description {
      padding-left: 10px; }
    .method .cell .mobile-isrequired {
      display: inline; } }


/* Row Utilities */
[class^='row'].margin-0,
[class*=' row'].margin-0,
[class^='form-group'].margin-0,
[class*=' form-group'].margin-0 {
  margin-left: -0px;
  margin-right: -0px; }
  [class^='row'].margin-0 > [class^='col-'],
  [class^='row'].margin-0 > [class*=' col-'],
  [class*=' row'].margin-0 > [class^='col-'],
  [class*=' row'].margin-0 > [class*=' col-'],
  [class^='form-group'].margin-0 > [class^='col-'],
  [class^='form-group'].margin-0 > [class*=' col-'],
  [class*=' form-group'].margin-0 > [class^='col-'],
  [class*=' form-group'].margin-0 > [class*=' col-'] {
    padding-right: 0px;
    padding-left: 0px; }
  [class^='row'].margin-0 [class^='row'],
  [class^='row'].margin-0 [class*=' row'],
  [class^='row'].margin-0 [class^='form-group'],
  [class^='row'].margin-0 [class*=' form-group'],
  [class*=' row'].margin-0 [class^='row'],
  [class*=' row'].margin-0 [class*=' row'],
  [class*=' row'].margin-0 [class^='form-group'],
  [class*=' row'].margin-0 [class*=' form-group'],
  [class^='form-group'].margin-0 [class^='row'],
  [class^='form-group'].margin-0 [class*=' row'],
  [class^='form-group'].margin-0 [class^='form-group'],
  [class^='form-group'].margin-0 [class*=' form-group'],
  [class*=' form-group'].margin-0 [class^='row'],
  [class*=' form-group'].margin-0 [class*=' row'],
  [class*=' form-group'].margin-0 [class^='form-group'],
  [class*=' form-group'].margin-0 [class*=' form-group'] {
    margin-left: 0;
    margin-right: 0; }
    
	</style>
</head>
<body>

<div class="container">

    <h2>Играчи</h2>
    <p class="lead">
        TODO Дoбави филтри
    </p>
    
    <div class="alert alert-info">
    </div>

    <hr />

    <div class="method">
        <div class="row margin-0 list-header hidden-sm hidden-xs">
            <div class="col-md-3"><div class="header">Играч</div></div>
            <div class="col-md-2"><div class="header">Победи/Загуби</div></div>
            <div class="col-md-2"><div class="header">Играе от</div></div>
            <div class="col-md-5"><div class="header">Населено място</div></div>
        </div>
    </div>
</div>

<div class="container-fluid">
	   
<?php

	require'db.php';
	
	$sql = "SELECT * FROM player";
    $result = db::getInstance()->get_result($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			echo '<div class="row margin-0">
					<div class="col-md-3">
						<div class="cell">
							<div class="propertyname">
								'.$row["name"].'<span class="mobile-isrequired"></span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="cell">
							<div class="type">
								<code>'.$row["name"].'</code>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="cell">
							<div class="isrequired">
								'.$row["name"].'
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="cell">
							<div class="description">
								The standard ISO 4217 3-letter currency code
							</div>
						</div>
					</div>
				</div>';
					
		}
	}

?> 

</body>
</html>