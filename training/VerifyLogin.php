<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>verify login</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>student training </h1>
<h2>Verify traingin Login</h2>

<?php
$errors = 0;
$DBName = "training";
try {
    $conn = mysqli_connect("localhost", "root", "",$DBName );
    
    $TableName = "student";
    $SQLstring = "SELECT studentID, first, last FROM $TableName" . " where email='" . stripslashes($_POST['email']) ."' and password_md5='" . md5(stripslashes($_POST['password'])) . "'";
    $qRes = mysqli_query($conn, $SQLstring);
    if (mysqli_num_rows($qRes)==0) {
        echo "<p>The e-mail address/password " . " combination entered is not valid. </p>\n";
        ++$errors;
    }
    else {
        $Row = mysqli_fetch_assoc($qRes);
        $studentID = $Row['studentID'];
        $studentName = $Row['first'] . " " . $Row['last'];
        echo "<p>Welcome back, $studentName!</p>\n";
        $_SESSION['studentID'] = $studentID;
    }
}
catch(mysqli_sql_exception $e) {
    echo "<p>Error: unable to connect/insert record in the database.</p>";
    ++$errors;
}
if ($errors > 0) {
	echo "<p>Please use your browser's BACK button to return " . " to the form and fix the errors indicated.</p>\n";
}
if ($errors == 0) {
	echo "<form method='post' " . " action='availableTrainings.php?" . SID . "'>\n";
	//echo "<input type='hidden' name='internID' " . " value='$InternID'>\n";
	echo "<input type='submit' name='submit' " . " value='View Available Opportunities'>\n";
	echo "</form>\n"; 
	//echo "<p><a href='AvailableOpportunities.php?" . "internID=$InternID'>Available " . " Opportunities</a></p>\n";
}
?>
</body>
</html>
