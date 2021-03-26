<?php
    session_start();
    
    //creat connection
    $conn = new mysqli('localhost','shysh1','shysh1','shysh1'); 

    // Check connection
    if ($conn->connect_error) 
    {
       die("Connection failed: " . $conn->connect_error);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
 
        //get details
        $username = mysqli_real_escape_string($conn,$_POST["username"]);
        $usertype = mysqli_real_escape_string($conn,$_POST["usertype"]);
        //encrypt password
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        if($usertype === "customer"){
 
            $myquery = "SELECT * FROM customer WHERE username = '$username' AND pwd = '$password'";
        }
        elseif($usertype === "rep"){

            $myquery = "SELECT * FROM representative WHERE username = '$username' AND pwd = '$password' ";
        }
        elseif($usertype === "manager")
        {

            $myquery = "SELECT * FROM manager WHERE username = '$username' AND pwd = '$password'";
        }
        else
        {
            echo "<script> alert('Invalid log in.');parent.location.href='index.php'; </script>";
        }

        
        $result = $conn->query($myquery);
        
        $nrows = $result->num_rows;

        //if the username and password exists in database
        if($nrows === 1)
        {
            $_SESSION['username'] = $username;
            if($usertype === "customer"){
                header("location: order.php");
            }
            elseif($usertype === "rep"){
                header("location: operateOrder.php");
            }
            elseif($usertype === "manager")
            {
                header("location: statistics.php");
            }
            else
            {
                echo "<script> alert('Invalid log in.');parent.location.href='index.php'; </script>";
            }
        }
        else
        {
            echo "<script> alert('Invalid log in.');parent.location.href='index.php'; </script>";
        }


    }



?>



<!DOCTYPE html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woolin Auto face mask Sales Management System</title>
    <link rel="stylesheet" type="text/css" href="index.css"></link>
    <script type="text/javascript" src="Login.js"></script>
    <style>
    /* set the position for h2*/
    #subheader{
        position: absolute;
        top:220px;
        left: 400px;
        width: 50%;
    }

    /*control size of menu */
    #mainmenu a
    {
        display:block;
        width:350px;    
    }

    </style>
</head>
<body>
    <div id="header">
        <h6><a href="index.php"><img id="logo" src="Woolin Auto Logo.png"></a></h6>
    </div>
    <br/>
    <div>
    <ul class="menu" id="mainmenu">
        <li><a href="index.php">Home page</a></li>
        <li><a href="customerregister.php">Register</a></li>
        <li><a href="changePassword.php">Change password</a></li>
    </ul>
    </div> 
    <h2 id="subheader">Woolin Auto face mask Sales Management System</h2>
    <div id="loginbox" class="mainbox">
        <h2 style="text-align: center;">Log in</h2>
        <form action="index.php" method="post" onsubmit="checkLogin();">
            <p>
                Select your user type first.
                <br/>
                <label>
                    <input type="radio" name="usertype" value="customer" checked="checked" />
                    Customer
                </label>
                <br/>
                <label>
                    <input type="radio" name="usertype" value="rep" />
                    Sales representative
                </label>
                <br/>
                <label>
                    <input type="radio" name="usertype" value="manager" />
                    Manager
                </label>
                <br/>
            </p>
            <label>
                User name:
                <input type="text" size="30" maxlength="30" name="username" class="box" Id="username"/>
            </label>
            <br/>
            <br/>
            <label>
                Password:
                <input type="password" size="30" maxlength="30" name="password" class="box" id="password"/>
            </label>
            <br/>
            <br/>
            <input type="submit" value="Log in" class="submitbutton" />
        </form>
    </div>


</body>
</html>