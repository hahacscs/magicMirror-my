<?php
//echo $_POST["name"]; 
//echo $_POST["email"];

$myfile = fopen("../media/anser.txt", "r") or die("Unable to open file!");
$text = fgets($myfile);
fclose($myfile);
if ($text[0] == '0')
	{echo "0 ";}
else
{	
	$myfile = fopen("../media/anser.txt", "w") or die("Unable to open file!");
	fwrite($myfile,'0');
	fclose($myfile);
	echo $text;
}
?>