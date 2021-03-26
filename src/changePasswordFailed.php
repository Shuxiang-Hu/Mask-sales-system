
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
    <br/>
    <!--report failure -->
    <div id="failureMsg" class="mainbox">
        <p>
            <?php echo "Your new password is invalid. Change password failed.";?>
            <a href="changePassword.php"><br/>Try again</a>
        </p>
    </div>


</body>
</html>