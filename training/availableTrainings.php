<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Available tainings</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>

<h1>Trainings</h1>
<h2>Available trainings</h2>

<?php

/*
if (isset($_SESSION['internID']))
	$InternID = $_SESSION['internID'] ;
else	
	$InternID = −1;
//*/
/*
if (isset($_GET['internID']))
	$InternID = $_GET['internID'];
else
		$InternID = −1;
*/
/*
if (isset($_REQUEST['internID']))
	$InternID = $_REQUEST['internID'];
else
		$InternID = −1;
*/

if (isset($_COOKIE['LastRequestDate']))
	$LastRequestDate = $_COOKIE['LastRequestDate'];
else
	$LastRequestDate = "";

try {
    $conn = mysqli_connect("localhost", "root", "");
	$DBName = "training";
	mysqli_select_db($conn, $DBName);
    
    $TableName = "student";
    $sql = "SELECT * FROM $TableName WHERE studentID='" . $_SESSION['studentID'] . "'";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) == 0) {
        die ("<p>Invalid Intern ID!</p>");
    }
    $Row = mysqli_fetch_assoc($qRes);
    $InternName = $Row['first'] . " " . $Row['last'];
    echo "$InternName ";
    
    $TableName = "assigned_training";
    $ApprovedOpportunities = 0;
    $sql = "SELECT COUNT(trainingCode) FROM $TableName WHERE studentID='" . $_SESSION['studentID'] . "'";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        $Row = mysqli_fetch_row($qRes);
        $ApprovedOpportunities = $Row[0];
        mysqli_free_result($qRes);
        echo $ApprovedOpportunities;
    }
        
    $SelectedOpportunities = array();
    $sql = "SELECT trainingCode FROM $TableName WHERE studentID='" . $_SESSION['studentID'] . "'";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        while (($Row = mysqli_fetch_row($qRes))!= FALSE)
            $SelectedOpportunities[] = $Row[0];
        $s= mysqli_free_result($qRes);
        
        
    }

    $AssignedOpportunities = array();
    $sql = "SELECT trainingCode FROM $TableName WHERE date_approved IS NOT NULL";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        while (($Row = mysqli_fetch_row($qRes))!= FALSE)
            $AssignedOpportunities[] = $Row[0];
        mysqli_free_result($qRes);
    }

    $TableName = "trainings";
    $Opportunities = array();
    $sql = "SELECT trainingCode, trainingName, facility, start_date, end_date, trainer FROM $TableName";
//echo $sql;
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
            $Opportunities[] = $Row;
        mysqli_free_result($qRes);
       
        
    }
    mysqli_close($conn);

}
catch (mysqli_sql_exception $e){
    die ("<p>Error in connection with the database server or database </p>\n");
}


if (!empty($LastRequestDate))
	echo "<p>You last requested an training opportunity on " . $LastRequestDate . ".</p>\n";

echo "<table border='1' width='100%'>\n";
echo "<tr>\n";

echo " <th style='background-color:cyan'>trainingName</th>\n";
echo " <th style='background-color:cyan'>facility</th>\n";
echo " <th style='background-color:cyan'>StartDate</th>\n";
echo " <th style='background-color:cyan'>EndDate</th>\n";
echo " <th style='background-color:cyan'>triner</th>\n";
echo " <th style='background-color:cyan'>Status</th>\n";
echo "</tr>\n";
foreach ($Opportunities as $Opportunity) {
	//if (in_array($Opportunity['trainingCode'], $AssignedOpportunities)) {
		echo "<tr>\n";
		
		echo " <td>" . htmlentities($Opportunity['trainingName']) . "</td>\n";
        echo " <td>" . htmlentities($Opportunity['facility']) . "</td>\n";
		echo " <td>" . htmlentities($Opportunity['start_date']) . "</td>\n";
		echo " <td>" . htmlentities($Opportunity['end_date']) . "</td>\n";
		echo " <td>" . htmlentities($Opportunity['trainer']) . "</td>\n";
		echo " <td>";
        if( $ApprovedOpportunities<4){
		if (in_array($Opportunity['trainingCode'], $SelectedOpportunities)){
      
        echo "<a href='withdrawTraining.php?" . SID . "&trainingCode=" . $Opportunity['trainingCode'] . "'>withdraw</a>";
        }
 
			
			else{
			
            echo "<a href='requestTraining.php?" . SID . "&trainingCode=" . $Opportunity['trainingCode'] . "'>Available</a>";
            }
        }
        else{
            if (in_array($Opportunity['trainingCode'], $SelectedOpportunities)){
      
                echo "<a href='withdrawTraining.php?" . SID . "&trainingCode=" . $Opportunity['trainingCode'] . "'>withdraw</a>";
                }
         
                    
                    else{
                    
                    echo "Available";
                    }

        }
		//}
		echo "</td>\n";
		echo "</tr>\n";
	//}
}

echo "</table>\n";
echo "<p><a href='login.php'>Log Out</a></p>\n";
echo "<p><a href='queries.php'>queries</a></p>\n";
?>
</body>
</html>