<?php
session_start();

//creat connection
$conn = new mysqli('localhost','shysh1','shysh1','shysh1'); 
    
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

//if the manager logged in
$username = $_SESSION['username'];
if($_SESSION['username'])
{
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $employeeID = $_POST['employeeID'];
        $quantity = $_POST['quantity'];

        //get current quota
        $get_quota_query = "SELECT quota FROM representative WHERE employeeID = '$employeeID' ";
        $result = $conn->query($get_quota_query);
	$tempresult = $result->fetch_assoc();
        $quota = $tempresult['quota'];
        //calculate new quota
        $temp = $quota + $quantity;
        //update quota
        $return_quota_query = "UPDATE representative SET quota = '$temp'  WHERE employeeID = '$employeeID' ";
        $conn->query($return_quota_query);
        //change the requests of this representative to processed
        $change_request_query = "UPDATE request SET requestStatus = 'processed'  WHERE employeeID = '$employeeID' ";
        $conn->query($change_request_query);
        
        echo "<script> alert('Quota assigned successfully');parent.location.href='requests.php'; </script>";
    }
}
$_SESSION['username'] = $username;
    


?>

<!DOCTYPE html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woolin Auto face mask Sales Management System</title>
    <link rel="stylesheet" type="text/css" href="index.css"></link>
    <style>
    /*control size of main menu*/
    #mainmenu a
    {
        display:block;
        width:220px;
    }
    
    /*control position of region assignment form */
    #quotaform{
        position: absolute;
        top: 300px;
        left:400px;
        margin: 0 auto;
    }

    #statistics{
        position: absolute;
        top: 350px;
        left:400px;
        background-color: cyan;
        width: 50%;
        margin: 0 auto;
        border: solid 1px #ff0000
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
        <li><a href="statistics.php">Statistics</a></li>
        <li><a href="customers.php">Customers</a></li>
        <li><a href="representatives.php">Representatives</a></li>
        <li><a href="requests.php">Requests</a></li>
        <li><a href="Logout.php">Logout</a></li>
    </ul>
    </div> 
    <h2 id="subheader">Woolin Auto face mask Sales Management System</h2>
    <!-- display representative account information-->
    <br/>
    <!-- assign the region of a representative-->
    <div>
        <form method="post" action="requests.php" id="quotaform">
            <label>
                Choose a representative
                <select name="employeeID">
                    <?php
                        $rep_query = "SELECT * FROM representative ";
                        $rep_result = $conn->query($rep_query);
                        while($row = $rep_result->fetch_assoc())
                        {                            
                            $employeeID = $row['employeeID'];
                            echo "<option value = \"$employeeID\">$employeeID</option>";            
                        }
                    ?>
                </select>
            </label>
            <label>
                Assign quota:
                <select id="quantity" name="quantity" >
                    <?php
                        for ($i=1; $i<=500; $i++)
                        {
                        echo "<option value=\"$i\">$i</option>";
                        } 
                    ?>
                </select>
            </label>
            <br/>
            <label>
                <input type="submit" value="Confirm assignment"/>
            </label>
        </form>
    </div>
    <br/>
    <!--display information of requests-->
    <table id="statistics" border="1" >
        <tr>
            <th>RequestID</th>
            <th>Representative ID</th>
            <th>Total number of masks required</th>
        </tr>
        <?php  
        $request_query = "SELECT * FROM request ";
        $request_result = $conn->query($request_query);
        while($row = $request_result->fetch_assoc())
        {   
            //get details of the request
            $requestID = $row['requestID'];
            $employeeID = $row['employeeID'];
            $quantity = $row['quantity'];
            $status = $row['requestStatus'];

            if(($status === "queuing") === true)
            {
                echo "<tr>".
                        "<td>$requestID</td>".
                        "<td>$employeeID</td>".
                        "<td>$quantity</td>".
                    "</tr>";
            }
        }
        
        ?>
    </table>

</body>
</html>