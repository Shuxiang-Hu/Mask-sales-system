<?php
    session_start();
    
    //creat connection
    $conn = new mysqli('localhost','shysh1','shysh1','shysh1');     
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    //if a use logged in
    if($_SESSION['username'])
    {   
        //get the username
        $username = $_SESSION['username'];


        //get details of logged-in representative
        $rep_query = "SELECT * FROM representative WHERE username = '$username' ";
        $result = $conn->query($rep_query);
        $rep_row = $result->fetch_assoc();
        $employeeID = $rep_row['employeeID'];
        $quota = $rep_row['quota'];

        //if a quota request is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //get the quantity 
            $quantity = $_POST['quantity'];
            $request_status = "queuing";
            //creat request message
            $request_query = "INSERT INTO request (quantity,employeeID,requestStatus) " . 
                             "VALUES ('$quantity','$employeeID','$request_status')";
            
            $result = $conn->query($request_query);
            

            

        }

        $_SESSION['username'] = $username;
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woolin Auto face mask Sales Management System</title>
    <link rel="stylesheet" type="text/css" href="index.css"></link>
    <style>
    /* set the position for h2*/
    #subheader{
        position: absolute;
        top:220px;
        left: 400px;
        width: 50%;
        text-align: center;
    }
    #requestform{
        position: absolute;
        top: 30px;
        left:50px;
        margin: 0 auto;
    }
    select{
	border-radius:4px;
    }
    </style>
</head>
<body>
    <div id="header">
        <h6><a href="index.php"><img id="logo" src="Woolin Auto Logo.png"/></a></h6>
    </div>
    <br/>
    <div>
    <!-- main menu-->
    <ul class="menu" id="mainmenu">
         <li><a href="operateOrder.php">Order</a></li>
        <li><a href="requestQuota.php">Request Quota</a></li>
        <li><a href="repAccount.php">Account</a></li>
        <li><a href="Logout.php">Logout</a></li>
    </ul>
    </div> 
    <h2 id="subheader">Your request</h2>
    <div class="mainbox">
        <!-- submit order request-->
        <form action="requestQuota.php" method="post" id="requestform" >
            <label>
                Enter the number of masks:
                <select id="quantity" name="quantity" ">
                <?php
                    for ($i=1; $i<=500; $i++)
                    {
                    echo "<option value=\"$i\">$i</option>";
                    } 
                ?>
            </select>
            </label>
            <br/>
	    <br/>	
            <label>
                Confirm your request:
                <input type="submit" value="request"/>
            </label>
        </form>
    </div>
</body>
</html>