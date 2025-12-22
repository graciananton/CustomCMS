<?php
//Sample Database Connection Syntax for PHP and MySQL.

//Connect To Database
$hostname="p3smysql63.secureserver.net:3306";
$username="ottawachurch";
$password="ottawachurch";
$dbname="ottawachurch";
$usertable="basil";
$yourfield = "id";
mysql_connect($hostname,$username, $password);
mysql_select_db($dbname);

# Check If Record Exists

$query = "SELECT * FROM $usertable";

$result = mysql_query($query);

if($result)
{
while($row = mysql_fetch_array($result))
{
$name = $row["$yourfield"];
echo "Name: ".$name."
";
}
}
?> 

