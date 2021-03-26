<?php
session_start();

//creat connection
$conn = new mysqli('localhost','shysh1','shysh1','shysh1'); 
    
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

//get username 
$username = $_SESSION['username'];

//if the manager logged in
if($_SESSION['username'])
{

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
	
        $employeeID = $_POST['employeeID'];
        $region = $_POST['region'];
	
        $region_assign_query = "UPDATE representative SET region = '$region' WHERE employeeID = '$employeeID'";
        $conn->query($region_assign_query);
        echo "<script> alert('Region assigned successfully');parent.location.href='representatives.php'; </script>";
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
    /*control size of main menu*/
    #mainmenu a
    {
        display:block;
        width:220px;
    }
    
    /*control position of region assignment form */
    #regionform{
        position: absolute;
        top: 300px;
        left:400px;
        margin: 0 auto;
    }

    #statistics{
        position: absolute;
        top: 400px;
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
        <form method="post" action="representatives.php" id="regionform">
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
                    Assign region:
                    <select name="region" >
                        <option value ="China">China</option>
                        <option value ="Japan">Japan</option>
                        <option value="America">America</option>
                        <option value="British">British</option>
                        <option value="Korean">Korean</option>
                        <option value="Russia">Russia</option>
                    </select>
            </label>
            <br/>
            <label>
                <input type="submit" value="Confirm assignment"/>
            </label>
        </form>
    </div>
    <!--display information of representatives-->
    <table id="statistics" border="1" >
        <tr>
            <th>employeeID</th>
            <th>Representative user name</th>
            <th>Total number of orders</th>
            <th>Total number of masks</th>
            <th>Total amount(￥)</th>
            <th>Region</th>
            <th>Tel</th>
        </tr>
        <?php
        //get China time
        $timezone_out = date_default_timezone_get();    
        date_default_timezone_set('Asia/Shanghai');
        $now = date('Y-m-d H:i:s');
        date_default_timezone_set($timezone_out);
        
        $rep_query = "SELECT * FROM representative ";
        $rep_result = $conn->query($rep_query);
        while($row = $rep_result->fetch_assoc())
        {
            
            
            //get details of the customer
            $employeeID = $row['employeeID'];
            $username = $row['username'];
            $quantity = 0;
            $amount = 0;
            $region = $row['region'];
            $tel = $row['tel'];
            $num_order = 0;
            $num_mask = 0;
            $total_amount = 0;
            $order_query = "SELECT * FROM ordering WHERE employeeID = '$employeeID' ";
            $order_result = $conn->query($order_query);

            while($order_row = $order_result->fetch_assoc())
            {
                if(((floor((strtotime($now)-strtotime($order_row['orderedTime']))/86400)) >= 1) === true)
                {
                    $num_order++;
                    $num_mask += $order_row['quantity'];
                    $total_amount += $order_row['amount'];
                }
            }


            echo "<tr>".
                    "<td>$employeeID</td>".
                    "<td>$username</td>".
                    "<td>$num_order</td>".
                    "<td>$num_mask</td>".
                    "<td>$total_amount</td>".
                    "<td>$region</td>".
                    "<td>$tel</td>".
                 "</tr>";
        }
        
        ?>
    </table>

</body>
</html>