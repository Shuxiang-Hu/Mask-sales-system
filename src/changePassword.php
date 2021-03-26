<?php
session_start();

//creat connection
$conn = new mysqli('localhost','shysh1','shysh1','shysh1'); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    //get details
    $username = mysqli_real_escape_string($conn,$_POST["username"]);
    $usertype = $_POST['usertype'];
    $oldpassword = mysqli_real_escape_string($conn,$_POST['oldpassword']); 
    $password1 = mysqli_real_escape_string($conn,$_POST['newpassword1']);
    $password2 = mysqli_real_escape_string($conn,$_POST['newpassword2']);



    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    //if user type is customer
    if(($usertype === "customer") === true)
    {
        //check if user name matches the old password
        $user_checking_string = "SELECT * FROM customer WHERE username = '$username' AND pwd = '$oldpassword' ";
        $result = $conn->query($user_checking_string);
        $nrows = $result->num_rows;

        //if no such user is found in database
        //report this error
        if($nrows === 0)
        {
            echo "<script> alert('User name does not match password.');parent.location.href='changePassword.php'; </script>";        
        }
        else
        {
            $changePwd_query = "UPDATE customer SET pwd = '$password1' WHERE username = '$username' AND pwd = '$oldpassword'";
            $conn->query($changePwd_query);
            echo "<script> alert('Password changed successfully.');parent.location.href='index.php'; </script>";      
        }

    }
    //else the user type is representative
    else
    {
        //check if user name matches the old password
        $user_checking_string = "SELECT * FROM representative WHERE username = '$username' AND pwd = '$oldpassword' ";
        $result = $conn->query($user_checking_string);
        $nrows = $result->num_rows;

        //if no such user is found in database
        //report this error
        if($nrows === 0)
        {
            echo "<script> alert('User name does not match password.');parent.location.href='changePassword.php'; </script>";        
        }
        else
        {
            $changePwd_query = "UPDATE representative SET pwd = '$password1' WHERE username = '$username' AND pwd = '$oldpassword'";
            $conn->query($changePwd_query);
            echo "<script> alert('Password changed successfully.');parent.location.href='index.php'; </script>";      
        }

    }

 


    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woolin Auto face mask Sales Management System</title>
    <link rel="stylesheet" type="text/css" href="index.css"></link>
    <script type="text/javascript" src="changePassword.js"></script>
    <style>
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
    
    <div id="registerbox" class="mainbox" style="height: 500px">
        <h2 style="text-align: center;">Change password</h2>

        <br/>
        <form action="changePassword.php" method="post" onsubmit="return checkSubmit();">
            <label>
                Select your user type first:
                <br/>
                    <select name="usertype">
                        <option value="customer">Customer</option>
                        <option value="representative">Representative</option>
                    </select>
            </label>
            <br/>
            <br/>
            <label>
                Enter your user name :<br/>
                <input type="text" size="30" maxlength="10" name="username" class="box" id="username" required />
            </label>
            <br/>
            <br/>
            <label>
                Enter your old password:
                <br/>
                <input type="password" size="30" maxlength="25" name="oldpassword" class="box" id="password" required />
            </label>
            <br/>
            <br/>
            <label>
                Enter your new password (10-25 characters):
                <br/>
                Password can only contain numbers, letters and underscores.
                <input type="password" size="30" maxlength="25" name="newpassword1" class="box" id="newpassword1" required/>
            </label>
            <br/>
            <br/>
            <label>
                Enter your password again:
                <input type="password" size="30" maxlength="25" name="newpassword2" class="box" id="newpassword2" onchange="checkPassword(); required"/>
            </label>
            <br/>
            <label>
                <input type="submit" name="submit" class="box" value="Confirm" class="submitbutton"/>
            </label>
        </form>
    </div>


</body>
</html>