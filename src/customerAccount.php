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
    $customer_query = "SELECT * FROM customer WHERE username = '$username' ";
    $result = $conn->query($customer_query);
    $row = $result->fetch_assoc();
    $passportID = $row['passportID'];
    $region = $row['region'];
    $email = $row['email'];
    $realname = $row['realname'];
    $tel = $row['tel'];
    

}
else
{
    header("location: index.php");
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
        <li><a href="order.php">Order</a></li>
        <li><a href="Myorder.php">My orderings</a></li>
        <li><a href="customerAccount.php">Account</a></li>
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
                &nbsp;&nbsp;<b>User name</b>:&nbsp;<?php echo "$username"?>
            </p>
            <p>
                &nbsp;&nbsp;<b>Real name</b>:&nbsp;<?php echo "$realname"?>
            </p>
            <p>
                &nbsp;&nbsp;<b>Passport ID</b>:&nbsp;<?php echo "$passportID"?>
            </p>
            <p>
                &nbsp;&nbsp;<b>Tel</b>:&nbsp;<?php echo "$tel"?>
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