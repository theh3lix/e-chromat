<?php
$servername = "mysql1.ugu.pl";
$username = "db691781";
$password = "2Krn25.1";
$dbname = "db691781";
$tablename = "User_Details";
$user = "h3lix";
$conn = mysql_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed" . mysql_error());
} 

$db_select = mysql_select_db("db691781",$conn);
    if(!$db_select) {
    die("Database selection failed: " . mysql_error());
    }
   
mysql_query('SET NAMES utf8');
    
$sql = "SELECT id_us from User where login='$user'";
$tmp = mysql_query($sql);
$res=mysql_result($tmp,0);

$query= "SELECT name from User_Details where id_us=$res";
$tmp2 = mysql_query($query);
$res2 = mysql_result($tmp2, 0);
echo $res2;


mysql_close();
?>
