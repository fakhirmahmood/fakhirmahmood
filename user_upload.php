<?php
define('DBHOST', 'localhost');
define('DBUSER', 'fakhir');
define('DBPASS', 'fakhir');
define('DBNAME', 'fakhir_db');
$conn=new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
$filename="users.csv";
$csvfile=fopen($filename,"r");
$headings=fgets($csvfile);
while (!feof($csvfile))
{
      $buffer=fgets($csvfile);
      $arr=explode(",",$buffer);
      if ($arr[0]<>'' && $arr[1]<>'' && $arr[2]<>'')
      {
         $insert_query="insert into users(name,surname,email) values('$arr[0]','$arr[1]','$arr[2]')";
         $conn->query($insert_query);
      }
      
}
?>