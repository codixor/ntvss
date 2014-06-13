<?php
include("vars.php");
include("includes/misc.class.php");
include("includes/movie.class.php");


$misc = new Misc();
$mov  = new Movie();

$mov->deleteAllEmbeds(1);
?>