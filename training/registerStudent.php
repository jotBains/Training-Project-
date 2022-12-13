<?php
session_start();
$Body = "";
$errors = 0;
$email = "";

if (empty($_POST['email'])) {
	++$errors;
	$Body .= "<p>You need to enter an e-mail address.</p>\n";
	}
else {
	$email = stripslashes($_POST['email']);
	if (preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)*(\.[a-z]{2,3})$/i", $email) == 0) {
		
		++$errors;
		$Body .= "<p>You need to enter a valid " . "e-mail address.</p>\n";
		$email = "";
	}
}

if (empty($_POST['password'])) {
	++$errors;
	$Body .= "<p>You need to enter a password.</p>\n"; 
	$password = "";
}
else
	$password = stripslashes($_POST['password']);

if (empty($_POST['password2'])) {
	++$errors;
	$Body .= "<p>You need to enter a confirmation password.</p>\n";
	$password2 = "";
}
else
	$password2 = stripslashes($_POST['password2']);

if ((!(empty($password))) && (!(empty($password2)))) {
	if (strlen($password) < 6) {
		++$errors;
		$Body .= "<p>The password is too short.</p>\n";
		$password = "";
		$password2 = "";
	}
	if ($password <> $password2) {
		++$errors;
		$Body .= "<p>The passwords do not match.</p>\n";
		$password = "";
		$password2 = "";
	}
}

if ($errors == 0) {
    try {
        $conn = mysqli_connect ("localhost", "root", "");

		$DBName = "training";
		$result = mysqli_select_db($conn,$DBName);
        $TableName = "student";
        $sql = "SELECT count(*) FROM $TableName" . " where email='" . $email . "'";
        $qRes = mysqli_query($conn, $sql);
		$Row = mysqli_fetch_row($qRes);
		if ($Row[0]>0) {
			$Body .= "<p>The email address entered (" . htmlentities($email) . ") is already registered.</p>\n";
			++$errors;
		}
	}
    catch (mysqli_sql_exception $e) {
        $Body .= "<p>Unable to connect to the database </p>\n";
        ++$errors;
   }
}
if ($errors > 0) {
	$Body .= "<p>Please use your browser's BACK button to return" . " to the form and fix the errors indicated.</p>\n";
}

if ($errors == 0) {
	$first = stripslashes($_POST['first']);
	$last = stripslashes($_POST['last']);
    try {
        $sql = "INSERT INTO $TableName " . " (first, last, email, password_md5) " . " VALUES( '$first', '$last', '$email', " . " '" . md5($password) . "')";
        mysqli_query($conn, $sql);
		$studentID = mysqli_insert_id($conn);
		$_SESSION['studentID'] = $studentID;
        mysqli_close($conn);
		//setcookie("internID", $InternID); //setcookie() must be first statement before any output is send to the server. That is enabled by $Body
    }
    catch (mysqli_sql_exception $e) {
        $Body .= "<p>Unable to insert record</p>";
        ++$errors;
    }
}
if ($errors == 0) {
	$InternName = $first . " " . $last;
	$Body .= "<p>Thank you, $InternName. ";
	$Body .= "Your new student ID is <strong>" . $_SESSION['studentID'] . "</strong>.</p>\n";
}

if ($errors == 0) {
	$Body .= "<form method='post' " . 	" action='availableTrainings.php?PHPSESSID=" . session_id() . "'>\n";
	$Body .= "<input type='submit' name='submit' " . " value='View Available Opportunities'>\n";
	$Body .= "</form>\n";
	//$Body .= "<p><a href='AvailableOpportunities.php" . SID . "'>View Available Opportunities</a></p>\n";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>REGISTER</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>student traing</h1>
<h2>student Registration</h2>
<?php
echo $Body;
?>
</body>
</html>