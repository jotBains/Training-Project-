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
<p> The code and name of trainings offered by a specific facility </p>
<form method="post" action="" >
<p>facil for name of trainerity name  <input type="text" name="facility" /></p>
<input type="submit" name="facilityfind" value="facilityfind" />
</form \n>

<hr />

<form method="post" action="" >
<p>training name <input type="text" name="training" /></p>
<input type="submit" name="find" value="find" />
</form \n>

<hr />
<hr />

<form method="post" action="" >
<p>facility for name of trainer name <input type="text" name="Ftraining" /></p>
<input type="submit" name="trainerfind" value="trainerfind" />
</form \n>

<hr />


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



try {
    $conn = mysqli_connect("localhost", "root", "");
	$DBName = "training";
	mysqli_select_db($conn, $DBName);
    


 //if (mysqli_num_rows($qRes) > 0) {
 //       while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
  //          $Opportunities[] = $Row;
   //     mysqli_free_result($qRes);
   // }
   
 if (isset($_POST['facilityfind'])) {
    $FName =$_POST['facility'];
      
    $TableName = "student";
    $sql = "SELECT * FROM $TableName WHERE studentID='" . $_SESSION['studentID'] . "'";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) == 0) {
        die ("<p>Invalid Intern ID!</p>");
    }
    $Row = mysqli_fetch_assoc($qRes);
    $InternName = $Row['first'] . " " . $Row['last'];
   // echo "$InternName ";


    $TableName = "trainings";
    $Opportunities = array();
    echo $FName;
    $sql = "SELECT trainingCode, trainingName FROM $TableName WHERE facility =' $FName'";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
            $Opportunities[] = $Row;
        mysqli_free_result($qRes);
    }
    echo "<table border='1' width='100%'>\n";
echo "<tr>\n";

echo " <th style='background-color:cyan'>trainingCode</th>\n";
echo " <th style='background-color:cyan'>traininggName</th>\n";
echo "</tr>\n";
foreach ($Opportunities as $Opportunity) {
	//if (in_array($Opportunity['trainingCode'], $AssignedOpportunities)) {
		echo "<tr>\n";
		
		echo " <td>" . htmlentities($Opportunity['trainingCode']) . "</td>\n";
		echo " <td>" . htmlentities($Opportunity['trainingName']) . "</td>\n";
		echo "</tr>\n";
	//}

    
}


};


$TableName = "assigned_training";
$ApprovedOpportunities = 0;
$sql = "SELECT COUNT(studentID ) FROM $TableName WHERE trainingCode";
$qRes = mysqli_query($conn, $sql);
if (mysqli_num_rows($qRes) > 0) {
    $Row = mysqli_fetch_row($qRes);
    $ApprovedOpportunities = $Row[0];
    mysqli_free_result($qRes);
    //echo $ApprovedOpportunities;
}
$TableName = "trainings";
$eachTraining = array();
$sql = "SELECT trainingCode,  trainingName FROM $TableName ";
$qRes = mysqli_query($conn, $sql);
if (mysqli_num_rows($qRes) > 0) {
    while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
        $eachTraining[] = $Row;
    mysqli_free_result($qRes);
}
echo "<table border='1' width='100%'>\n";
//echo "The number of students in each training \n";
echo "<tr>\n";

echo " <th style='background-color:cyan'>traininggName</th>\n";
echo " <th style='background-color:cyan'>Number of student</th>\n";
echo "</tr>\n";
foreach ($eachTraining as $eachTraining) {
//if (in_array($Opportunity['trainingCode'], $AssignedOpportunities)) {
    echo "<tr>\n";
    $TableName = "assigned_training";
    $NOfStudent = 0;
    $s = htmlentities($eachTraining['trainingCode']);
   
    $sql = "SELECT COUNT(studentID) FROM $TableName WHERE trainingCode = '$s'";
  //  echo"$sql";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        $Row = mysqli_fetch_row($qRes);
        $NOfStudent = $Row[0];
        mysqli_free_result($qRes);
        //echo $ApprovedOpportunities;
    } 
    echo " <td>" . htmlentities($eachTraining['trainingName']) . "</td>\n";

    echo " <td>  " . $NOfStudent . " </td>\n";
    echo "</tr>\n";
//}



}

 
echo "The name of students enrolled in a specific training\n";
$TableName = "trainings";
$TrainingI = 0;
if (isset($_POST['find'])) {
 $TName =$_POST['training'];

$sql = "SELECT trainingCode   FROM $TableName where trainingName ='$TName' ";
$qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        $Row = mysqli_fetch_row($qRes);
        $TrainingI = $Row[0];
        mysqli_free_result($qRes);
}
$TableName = "assigned_training";
$SID  = array();
$sql = "SELECT studentID  FROM $TableName WHERE trainingCode= ' $TrainingI'";
$qRes = mysqli_query($conn, $sql);
if (mysqli_num_rows($qRes) > 0) {
    while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
        $SID [] = $Row;
    mysqli_free_result($qRes);
    foreach( $SID as  $SID){
        
    $TableName = "student";
    $si = htmlentities($SID['studentID']);
    $sql = "SELECT * FROM $TableName WHERE studentID= '$si'";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) == 0) {
        die ("<p>Invalid Intern ID!</p>");
    }
    $Row = mysqli_fetch_assoc($qRes);
    $InternName = $Row['first'] . " " . $Row['last'];
    echo "<p>".$InternName ."</p>\n";
    
    };
    echo"<hr />";
} 
};
if (isset($_POST['trainerfind'])) {
    $FTName =$_POST['Ftraining'];

$TableName = "trainings";
$TF = array();
$sql = "SELECT trainer  FROM $TableName where facility='$FTName' ";
$qRes = mysqli_query($conn, $sql);
if (mysqli_num_rows($qRes) > 0) {
    while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
        $TF[] = $Row;
    mysqli_free_result($qRes);
    foreach( $TF as  $TF){
        echo",,,,,,,,,,,,,,,,,,,,name of trainer \n". htmlentities($TF['trainer']).",,,,,,,,,,,,,,,,,,,,,,,,,\n";
    };

}
};


$TableName = "trainings";
$nOT = 0;
$sql = "SELECT COUNT(trainer ) FROM $TableName WHERE facility='IT' ";
$qRes = mysqli_query($conn, $sql);
if (mysqli_num_rows($qRes) > 0) {
    $Row = mysqli_fetch_row($qRes);
    $nOT = $Row[0];
    mysqli_free_result($qRes);
    echo $nOT;
}

$TableName = "trainings";
$TrainingIOF = 0;
$sql = "SELECT trainingCode   FROM $TableName where facility='IT'";
$qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        $Row = mysqli_fetch_row($qRes);
        $TrainingIOF = $Row[0];
        mysqli_free_result($qRes);
}
$TableName = "assigned_training";
$SID  = array();
$sql = "SELECT studentID  FROM $TableName WHERE trainingCode= ' $TrainingIOF'";
$qRes = mysqli_query($conn, $sql);
if (mysqli_num_rows($qRes) > 0) {
    while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
        $SID [] = $Row;
    mysqli_free_result($qRes);
    foreach( $SID as  $SID){
        
    $TableName = "student";
    $si = htmlentities($SID['studentID']);
    $sql = "SELECT * FROM $TableName WHERE studentID= '$si'";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) == 0) {
        die ("<p>Invalid Intern ID!</p>");
    }
    $Row = mysqli_fetch_assoc($qRes);
    $InternName = $Row['first'] . " " . $Row['last'];
    echo ".....The ID and name of students".$InternName, $si."....\n ";
    
    };
    
} 




  
  $TableName = "assigned_training";
$SOF = 0;
$sql = "SELECT COUNT(studentID ) FROM $TableName WHERE trainingCode";
$qRes = mysqli_query($conn, $sql);
if (mysqli_num_rows($qRes) > 0) {
    $Row = mysqli_fetch_row($qRes);
    $SOF = $Row[0];
    mysqli_free_result($qRes);
    echo $SOF;
}
$TableName = "trainings";
$eachTrainingC = array();
$sql = "SELECT trainingCode, facility  FROM $TableName ";
$qRes = mysqli_query($conn, $sql);
if (mysqli_num_rows($qRes) > 0) {
    while (($Row = mysqli_fetch_assoc($qRes))!= FALSE)
        $eachTrainingC[] = $Row;
    mysqli_free_result($qRes);
}
echo "<table border='1' width='100%'>\n";
echo "<tr>\n";

echo " <th style='background-color:cyan'>facility</th>\n";
echo " <th style='background-color:cyan'>Number of student</th>\n";
echo "</tr>\n";
foreach ($eachTrainingC as $eachTraining) {
//if (in_array($Opportunity['trainingCode'], $AssignedOpportunities)) {
    echo "<tr>\n";
    $TableName = "assigned_training";
    $NOfStudent = 0;
    $s = htmlentities($eachTraining['trainingCode']);
   
    $sql = "SELECT COUNT(studentID) FROM $TableName WHERE trainingCode = '$s'";
  //  echo"$sql";
    $qRes = mysqli_query($conn, $sql);
    if (mysqli_num_rows($qRes) > 0) {
        $Row = mysqli_fetch_row($qRes);
        $NOfStudent = $Row[0];
        mysqli_free_result($qRes);
        //echo $ApprovedOpportunities;
    } 
    echo " <td>" . htmlentities($eachTraining['facility']) . "</td>\n";

    echo " <td>  " . $NOfStudent . " </td>\n";
    echo "</tr>\n";
//}



}


  


    mysqli_close($conn);

}
catch (mysqli_sql_exception $e){
    die ("<p>Error in connection with the database server or database </p>\n");
}


?>
</body>
</html>