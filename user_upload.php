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
      $buffer=rtrim(fgets($csvfile));
      $arr=explode(",",$buffer);
      if ($arr[0]<>'' && $arr[1]<>'' && $arr[2]<>'')
      {
         $name=addslashes(ucfirst($arr[0]));
         $surname=addslashes(ucfirst($arr[1]));
         $email=addslashes(strtolower($arr[2]));
         if (!filter_var($email,FILTER_VALIDATE_EMAIL)) 
         {
           echo $email." is not a valid email format. This row will be rejected.<br>";
         }
         else
         {
           $insert_query="insert into users(name,surname,email) values('$name','$surname','$email')";
           $conn->query($insert_query);
           echo "Record Inserted.<br>";
         }
      } 
}
?>