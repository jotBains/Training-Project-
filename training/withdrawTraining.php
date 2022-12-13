<?php
session_start();
$Body = "";
$errors = 0;
$studentID = 0;
/*
if (isset($_GET['internID']))
	$InternID = $_GET['internID']; */
if (isset($_SESSION['studentID']))
	$studentID = $_SESSION['studentID']; 
else {
	$Body .= "<p>You have not logged in or registered. Please return to the <a href='login.php'>Registration / Log In page</a>.</p>";
	++$errors;
}
if ($errors == 0) {
	if (isset($_GET['trainingCode']))
		$trainingCode = $_GET['trainingCode'];
	else {
		$Body .= "<p>You have not selected an opportunity. Please return to the <a href='AvailableOpportunities.php?". SID . "'>Available Opportunities page</a>.</p>";
		++$errors;
	}
}

if ($errors == 0) {
    try {
        $conn = mysqli_connect("localhost", "root","");
	
		$DBName = "training";
		$result = mysqli_select_db($conn, $DBName);
		
        $DisplayDate = date("Y-m-d");
        $DatabaseDate = date("Y-m-d H:i:s");
        $TableName = "assigned_training";
        $sql = "DELETE FROM `$TableName` WHERE trainingCode = $trainingCode";
         
        $qRes = mysqli_query($conn, $sql) ;
		$Body .= "<p>Your request for training # " . " $trainingCode has been withdrawed on $DisplayDate.</p>\n";
        mysqli_close($conn);
    }
    catch (mysqli_sql_exception $e) {
        $Body .= "<p>Unable to execute the query.</p>\n";
        ++$errors;
    }
}

if ($studentID > 0)
	$Body .= "<p>Return to the <a href='availableTrainings.php?". SID . "'>Available Opportunities</a> page.</p>\n";
else
	$Body .= "<p>Please <a href='login.php'>Register or Log In</a> to use this page.</p>\n";

if ($errors == 0)
	setcookie("LastRequestDate", urlencode($DisplayDate), time()+60*60*24*7); //, "/examples/internship/");
?>
<!DOCTYPE html>
<html>
<head>
<title>Request opportunities</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>College Internship</h1>
<h2>Oportunity requested Registration</h2>
<?php
echo $Body;
?>
</body>
</html>