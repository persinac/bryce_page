<?php require_once('Connections/bryceConn.php'); ?>
<?php
session_start();
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
} 
} #end function
//echo "whattttttt....";
class wod {
	   public $title = "";
       public $start = "";
       public $descrip  = "";
   }

$mysqli = new mysqli($hostname_brycConn, $username_brycConn, $password_brycConn, $database_brycConn);
$t_date = $_POST['date'];
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$query = "select DATE_FORMAT(date, '%Y-%m-%d') AS date, warmup, strength, conditioning, speed from bryce where date = '{$t_date}'";
if ($result2 = $mysqli->query($query)) {
	///echo "hellooooo...";
	$cars = array();
    /* fetch associative array */
    while ($row = $result2->fetch_assoc()) {
        //printf ("MYSQLi STUFF: %s %s\n", $row["date"], $row["strength"]);
		$w = new wod();
		$w->title = $row["date"];
		$w->start = $row["date"];
		if(strlen($row["warmup"]) > 0) {
			$w->descrip .= $row["warmup"];
		}
		if(strlen($row["strength"]) > 0) {
			$w->descrip .= $row["strength"];
		}
		if(strlen($row["conditioning"]) > 0) {
			$w->descrip .= $row["conditioning"];
		}
		if(strlen($row["speed"]) > 0) {
			$w->descrip .= $row["speed"];
		}
		$cars[] = $w;
    }
	//print_r($cars);
	echo json_encode($cars);
    /* free result set */
    $result2->free();
}

/* close connection */
$mysqli->close();
/*
mysql_select_db($database_brycConn, $brycConn);

###
# Defualt view 
###
$query_getAdminWeeklyTotals = "select DATE_FORMAT(date, '%Y-%m-%d') AS date, warmup, strength, conditioning, speed from bryce where date = '{$t_date}'";
$getAdminWeeklyTotals = mysql_query($query_getAdminWeeklyTotals, $brycConn) or die(mysql_error());
$totalRows_getAdminWeeklyTotals = mysql_num_rows($getAdminWeeklyTotals);
$results = array();

while ($row = mysql_fetch_assoc($getAdminWeeklyTotals)) {
    echo $row["date"];
    echo $row["warmup"];
    echo $row["strength"];
	echo $row["conditioning"];
	echo $row["speed"];
}


for($i = 0; $i < $totalRows_getAdminWeeklyTotals; $i++)
{
	$results[] = mysql_fetch_assoc($getAdminWeeklyTotals);
}

echo json_encode($results);
*/	
?>