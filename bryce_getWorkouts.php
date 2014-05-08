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
	public $id = 0;
	public $title = "";
	public $start = "";
	public $end = "";
	public $description  = "";
	public $color = "";
   }

$mysqli = new mysqli($hostname_brycConn, $username_brycConn, $password_brycConn, $database_brycConn);
$t_date = $_POST['date'];
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "select DATE_FORMAT(date, '%Y-%m-%d') AS date, warmup, strength, conditioning, speed, core, rest from bryce";

if ($result2 = $mysqli->query($query)) {
	$cars = array();
	$index = 1;
	$warm = 1;
	$str = 1;
	$cond = 1;
	$speed = 1;
	$core = 1;
	$is_rest_day = 0;
	$prev_date = "";
	 /* fetch associative array */
   while ($row = $result2->fetch_assoc()) {
        if($prev_date == $row["date"]) {
			$warm = $warm + 1;
			$str = $str + 1;
			$cond = $cond + 1;
			$speed = $speed + 1;
			$core = $core + 1;
			$index = $index + 5;
		}
		if($is_rest_day < 1) {
			if(strlen($row["rest"]) > 0) {
				//echo "REST DAY ON " . $row["date"];
				$w = new wod();
				$w->id = $index;
				//$w->title = $row["date"];
				if($index < 10) {
					$w->start = $row["date"] . "T0".$index.":00:00";
					$w->end = $row["date"] . "T0".$index.":59:00";
				} else if ($index > 9 && $index < 13) {
					$w->start = $row["date"] . "T".$index.":00:00";
					$w->end = $row["date"] . "T0".$index.":59:00";
				}
				$w->description = "Rest Day";
				$w->title = "Rest Day";
				$is_rest_day = 1;
				
				$cars[] = $w;
				$index = $index + 1;
			} else {
				if(strlen($row["warmup"]) > 0) {
					//echo "WARMUP " . $row["date"];
					$w = new wod();
					$w->id = $index;
					//$w->title = $row["date"];
					if($index < 10) {
						$w->start = $row["date"] . "T0".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					} else if ($index > 9 && $index < 13) {
						$w->start = $row["date"] . "T".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					}
					$w->title = "Warm up " . $warm;
					$w->description .= "".$row["warmup"]."  ";
					$w->color = "yellow";
					
					$cars[] = $w;
					$index = $index + 1;
					//$warm = $warm + 1;					
				}
				if(strlen($row["strength"]) > 0) {
					//echo "STRENGTH ON " . $row["date"];
					$w = new wod();
					$w->id = $index;
					//$w->title = $row["date"];
					if($index < 10) {
						$w->start = $row["date"] . "T0".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					} else if ($index > 9 && $index < 13) {
						$w->start = $row["date"] . "T".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					}
					
					$w->description .= "".$row["strength"]."  ";
					$w->title = "Strength " . $str;
					$w->color = "blue";
					
					$cars[] = $w;
					$index = $index + 1;
					//$str = $str + 1;
				}
				if(strlen($row["conditioning"]) > 0) {
					//echo "Conditioning ON " . $row["date"];
					$w = new wod();
					$w->id = $index;
					//$w->title = $row["date"];
					if($index < 10) {
						$w->start = $row["date"] . "T0".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					} else if ($index > 9 && $index < 13) {
						$w->start = $row["date"] . "T".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					}
					
					$w->description .= "".$row["conditioning"]."  ";
					$w->title = "Conditioning ".$cond;
					$w->color = "orange";
					
					$cars[] = $w;
					$index = $index + 1;
					///$cond = $cond + 1;
				}
				if(strlen($row["speed"]) > 0) {
					//echo "SPEED ON " . $row["date"];
					$w = new wod();
					$w->id = $index;
					//$w->title = $row["date"];
					if($index < 10) {
						$w->start = $row["date"] . "T0".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					} else if ($index > 9 && $index < 13) {
						$w->start = $row["date"] . "T".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					}
					
					$w->description .= "".$row["speed"]."  ";
					$w->title = "Speed " . $speed;
					$w->color = "green";
					
					$cars[] = $w;
					$index = $index + 1;
					//$speed = $speed + 1;
				}
				if(strlen($row["core"]) > 0) {
					//echo "CORE ON " . $row["date"];
					$w = new wod();
					$w->id = $index;
					//$w->title = $row["date"];
					if($index < 10) {
						$w->start = $row["date"] . "T0".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					} else if ($index > 9 && $index < 13) {
						$w->start = $row["date"] . "T".$index.":00:00";
						$w->end = $row["date"] . "T0".$index.":59:00";
					}
					
					$w->description .= "".$row["core"]."  ";
					$w->title = "Core " . $core;
					$w->color = "purple";
							
					$cars[] = $w;
					$index = $index + 1;
					//$core = 1;
				}
			}
		}
		$prev_date = $row["date"];
		$is_rest_day = 0;
		$index = 1;
		$warm = 1;
		$str = 1;
		$cond = 1;
		$speed = 1;
		$core = 1;
    }
	//echo "END";
	echo json_encode($cars);
	    /* free result set */
    $result2->free();
}
/* close connection */
$mysqli->close();
?>