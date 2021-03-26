<?php
session_start();

//creat connection
$conn = new mysqli('localhost','shysh1','shysh1','shysh1'); 


// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}


if($_SERVER['REQUEST_METHOD'] == 'POST' )
{
   
    //get details
    $username = mysqli_real_escape_string($conn,$_POST["username"]);
    
    $password1 = mysqli_real_escape_string($conn,$_POST['password1']);
    $password2 = mysqli_real_escape_string($conn,$_POST['password2']);
    $realname = mysqli_real_escape_string($conn,$_POST['realname']);
    $passportId = mysqli_real_escape_string($conn,$_POST['passportID']);
    $email = mysqli_real_escape_string($conn,$_POST['e-mail']);
    $tel = mysqli_real_escape_string($conn,$_POST['tel']);
    $region = mysqli_real_escape_string($conn,$_POST['region']);

    //check if there is an exising customer using such username, passportId, telephone number or e-mail address
    $user_checking_string = "SELECT * FROM customer WHERE username = '$username' or passportID = '$passportId' or email = '$email' or tel = '$tel'  LIMIT 1";
    $result = $conn->query($user_checking_string);
    
    $nrows = $result->num_rows;
 

    //if no such user is found in database
    //then insert the details
    if($nrows === 0)
    {
        $_SESSION['username'] = $username;

        //insert details into the database
        $mysql = "INSERT INTO customer (username,realname,pwd,passportID,tel,region,email)"
                ."VALUES ('$username', '$realname', '$password1', '$passportId', '$tel', '$region', '$email')";

        if($conn->query($mysql) === true)
        {
            $_SESSION['message'] = "Registeration successful. Welcome $username";
            header("location: index.php");
        }
        else
        {
            $_SESSION['message'] = "Registeration failed.";
            header("location: registerationfailed.php");
        }
  
    }
    else
    {
        $_SESSION['message'] = "User name, passportID, e-mail or tel already occupied. Registeration failed.";
        header("location: registerationfailed.php");
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
    <script type="text/javascript" src="Register.js"></script>
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
    
    <div id="registerbox" class="mainbox" style="height: 850px">
        <h2 style="text-align: center;">Register</h2>

        <br/>
	<!-- offer links for different register pages-->
        <p>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select your user type first:
            <br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="customerregister.php">Customer</a>
            <br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="repregister.php">Sales representative</a>
            <br/>
        </p>
	<!-- ask user to submit information-->
        <form action="customerregister.php" method="post" onsubmit="return checkRegister1()">
            <label>
                Enter yout user name (no more than 10 characters):<br/>
                <input type="text" size="30" maxlength="10" name="username" class="box" id="username"  required/>
            </label>
            <br/>
            <br/>
            <label>
                Enter your password (10-25 characters):
                <br/>
                Password can only contain numbers, letters and underscores.
                <input type="password" size="30" maxlength="25" name="password1" class="box" id="password" required/>
            </label>
            <br/>
            <br/>
            <label>
                Enter your password again:
                <input type="password" size="30" maxlength="25" name="password2" class="box" id="password2" onchange="checkPassword();" required/>
            </label>
            <br/>
            <br/>
            <label>
                Enter your name :
                <input type="text" size="30" maxlength="255" name="realname" class="box" id="realname" onchange="checkName();" required/>
            </label>
            <br/>
            <br/>
            <label>
                Enter your passport ID:
                <input type="text" size="30" maxlength="30" name="passportID" class="box" id="passportID" onchange="checkPassportID();" required/>
            </label>
            <br/>
            <br/>
            <label>
                Enter your telephone number:
                <input type="text" size="30" maxlength="30" name="tel" class="box" id="tel" onchange="checkTelephoneNumber();" required/>
            </label>
            <br/>
            <br/>
            <label>
                Enter your e-mail address :
                <input type="text" size="30" maxlength="30" name="e-mail" class="box" id="e-mail" onchange="checkEmail();" required/>
            </label>
            <br/>
            <br/>
            <label>
                Choose your region:
                <select name="region" class="box" id="region">
                    <option value ="China">China</option>
                    <option value ="Japan">Japan</option>
                    <option value="America">America</option>
                    <option value="British">British</option>
                    <option value="Korean">Korean</option>
                    <option value="Russia">Russia</option>
                  </select>
            </label>
            <br/>
            <br/>
            <input type="submit" value="Register" class="submitbutton" />
		
            <p>Already registered?<a href="index.php"><b>Click to log in.</b></a></p>
        </form>
    </div>


</body>
</html>