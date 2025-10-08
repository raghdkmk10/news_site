<?php
$host="localhost";
$username="root";
$password="";
$databasename="news_system";

$conn=new mysqli($host,$username,$password,$databasename);


if ($conn->connect_error) {
    die($conn->connect_error);
}else{
    echo "";
}

?>