<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <!--<link rel="stylesheet" href="3-col-pages/css/bootstrap.min.css">-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
    <script src="js/myScript.js" type="text/javascript"></script> 
	<link rel="amphtml" href="https://mercury.postlight.com/amp?url=http://www.example.com/sample-article.html">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
 <style>
         .well {
             height: 350px;
             width: 100%;

         }
    </style>
</head>
<body>
	<div class="container">
		<div class="row">
			<?php require_once "mercuurius_modal.php"; ?>
			<?php require_once "merc_2.php"; ?>
			   
			<?php getVoog("https://flipboard.com/@raimoseero/feed-nii8kd0sz?rss"); ?>

		 
		</div>
	</div>
</body>
</html>