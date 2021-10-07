<?php

session_start();

require_once "../dompdf_config.inc.php";
require_once "functions.inc.php";

function li_arrow() {
  return '<li style="list-style-image: url(\'images/arrow_0' . rand(1,6) . '.gif\');">';  
}

function li_star() {
  return '<li style="list-style-image: url(\'images/star_0' . rand(1,5) . '.gif\');">';  
}

auth_check();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <?php if (isset($_SESSION["auth_message"])) { ?>
    <script type="text/javascript">
      alert("<?php echo $_SESSION["auth_message"]; ?>");
    </script>
  <?php } ?>
      <meta charset="utf-8">
    <title>Library License</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <!-- this is a way broken down bootstrap, mostly grid, nav and responsive -->
    <link rel="stylesheet" href="css/TangleKit.css" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/typeplate.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le fav and touch icons -->
    <script type="text/javascript">
 		 var _gaq = _gaq || [];
  		_gaq.push(['_setAccount', ' UA-29277171-1']);
  		_gaq.push(['_trackPageview']);

  		(function() {
    		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  		})();
	</script>
	
	<script type="text/javascript" src="js/Tangle.js"></script>

	<!-- TangleKit (optional) -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/TangleKit/mootools.js"></script>
	<script type="text/javascript" src="js/TangleKit/sprintf.js"></script>
	<script type="text/javascript" src="js/TangleKit/BVTouchable.js"></script>
	<script type="text/javascript" src="js/TangleKit/TangleKit.js"></script>

	<!-- example -->
	<script type="text/javascript">

		function setUpTangle () {

			var element = document.getElementById("active");

			var tangle = new Tangle(element, {
				initialize: function () {
					this.years = 5;
					this.days = 365;
				},
				update: function () {
					this.time = this.years * this.days;
				}
			});
		}
		

	</script>
	<script type="text/javascript">
	$(document).ready(function() {
  // Handler for .ready() called.
	setUpTangle();
	$("#active").on("mouseenter", ".TKAdjustableNumber", function(event){
			$(".dynamic-variable").removeClass("smaller");
			 $(".dynamic-variable").addClass("bigger");
		});

		$("#active").on("mouseleave", ".TKAdjustableNumber", function(event){
 			$(".dynamic-variable").removeClass("bigger");
 			$(".dynamic-variable").addClass("smaller");
		});
	});
	</script>
</head>




