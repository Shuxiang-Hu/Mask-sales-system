<?php
session_start();

//creat connection
$conn = new mysqli('localhost','shysh1','shysh1','shysh1'); 
    
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

//if a representative logged in
if($_SESSION['username'])
{
    //get details of the logged-in representative
    $username = $_SESSION['username'];
    $rep_query = "SELECT * FROM representative WHERE username = '$username' ";
    $result = $conn->query($rep_query);
    $row = $result->fetch_assoc();
    $employeeID = $row['employeeID'];
    $quota = $row['quota'];
    $region = $row['region'];
    $email = $row['email'];
    $realname = $row['realname'];
    $tel = $row['tel'];



}
    $conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woolin Auto face mask Sales Management System</title>
    <link rel="stylesheet" type="text/css" href="index.css"></link>
    <script type="text/javascript" src="Register.js"></script>
</head>
<body>
    <div id="header">
        <h6><a href="index.php"><img id="logo" src="Woolin Auto Logo.png"></a></h6>
    </div>
    <br/>
    <div>
    <ul class="menu" id="mainmenu">
        <li><a href="operateOrder.php">Order</a></li>
        <li><a href="requestQuota.php">Request Quota</a></li>
        <li><a href="repAccount.php">Account</a></li>
        <li><a href="Logout.php">Logout</a></li>
    </ul>
    </div> 
    <h2 id="subheader">Woolin Auto face mask Sales Management System</h2>
    
    <div id="repaccountbox" class="mainbox">
        <!-- display representative account information-->
        <h2 style="text-align: center;">Account</h2>
        <br/>
        <p>
            <p>
                &nbsp;&nbsp;<b>EmployeeID</b>:&nbsp;<?php echo "$employeeID"?>
            </p>
            <p>
                &nbsp;&nbsp;<b>User name</b>:&nbsp;<?php echo "$username"?>
            </p>
            <p>
                &nbsp;&nbsp;<b>Tel</b>:&nbsp;<?php echo "$tel"?>
            </p>
            <p>
                &nbsp;&nbsp;<b>Quota</b>:&nbsp;<?php echo "$quota"?>
            </p>

            <p>
                &nbsp;&nbsp;<b>E-mail address</b>:&nbsp;<?php echo "$email"?>
            </p>
            <p>
                &nbsp;&nbsp;<b>Region</b>:&nbsp;<?php echo "$region"?>
            </p>
        </p>
    </div>


</body>
</html>