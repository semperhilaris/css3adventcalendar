<!DOCTYPE html>
<html>
<head>
<title>Example Calendar</title>
<link type="text/css" rel="stylesheet" href="../advent-calendar.css" media="all">
<link type="text/css" rel="stylesheet" href="./example.css" media="all">
<!--[if lte IE 9]>
<style type='text/css'>
	a.advent-calendar-entry:hover .advent-calendar-door { display:none; }
</style>
<![endif]-->
</head>
<body>

<?php

require "../AdventCalendar.php";
$config = file_get_contents("./calendar.json");
$calendar = new AdventCalendar();
$calendar->load_from_json($config);
$calendar->render();

?>

</body>
</html>
