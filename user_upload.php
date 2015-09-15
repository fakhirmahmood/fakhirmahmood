<?php

if (isset($_GET['file']))
   $filename=$_GET['file'];
if (isset($_GET['u']))
   $userid=$_GET['u'];
if (isset($_GET['p']))
   $password=$_GET['p'];
if (isset($_GET['h']))
   $host=$_GET['h'];
if (isset($_GET['d']))
   $db=$_GET['d'];
if (isset($_GET['create_table']))
   $create_table=$_GET['create_table'];
if (isset($_GET['dry_run']))
   $dry_run=$_GET['dry_run'];
if (isset($_GET['help']))
   $help=$_GET['help'];

if (isset($host) && isset($userid) && isset($password) && isset($db))
   $conn=new mysqli($host,$userid,$password,$db);

if ($create_table=="y")
{
   $drop_table_query="drop table users";
   $conn->query($drop_table_query);
   $create_table_query="create table users (name varchar(100),surname varchar(100),email varchar(100) UNIQUE)";
   $conn->query($create_table_query);  
}
elseif ($help=="y")
{
   echo "--file [csv file name] – this is the name of the CSV to be parsed<br>";
   echo "--create_table – this will cause the MySQL users table to be built (and no further action will be taken)<br>";
   echo "--dry_run – this will be used with the --file directive in the instance that we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered<br>";
   echo "-u – MySQL username<br>";
   echo "-p – MySQL password<br>";
   echo "-h – MySQL host<br>";
   echo "--help – which will output the above list of directives with details";
}
else
{
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
           if (!($dry_run=='y'))
           {
              $conn->query($insert_query);
           } 
           echo "Record Inserted.<br>";
         }
      } 
}
}
?>