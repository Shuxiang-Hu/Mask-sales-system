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
        //get China time
        $timezone_out = date_default_timezone_get();
        date_default_timezone_set('Asia/Shanghai');
        $now = date('Y-m-d H:i:s');
        date_default_timezone_set($timezone_out);

        //if a delete request is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //get the ordering ID to be deleted
            $deletedID = $_POST['orderingID'];
            //determine if this order is deletable
            $order_query = "SELECT * FROM ordering WHERE orderingID = '$deletedID' AND customer = '$username' ";
            
            $result = $conn->query($order_query);
            
            $nrows = $result->num_rows;
            
            if(($nrows === 1) === true)
            {
                $row = $result->fetch_assoc();
                $orderedTime = $row['orderedTime'];
                $day=floor((strtotime($now)-strtotime($orderedTime))/86400);
                //if 24 has passed
                if(($day >= 1) === true)
                {
                    echo "<script> alert('order cannot be deleted');parent.location.href='Myorder.php'; </script>";

                }
                else
                {
                    //delete this order
                    $delete_order_query = "DELETE FROM ordering WHERE orderingID = $deletedID";
                    $result = $conn->query($delete_order_query);
                    
                    //return quota to the representaitve
                    $employeeID = $row['employeeID'];
                    $quantity = $row['quantity'];
                    $status = $row['orderStatus'];
                    //when a normal quota is cancelled within 24h
                    //the quota is returned to the representative
                    if($status === "normal")
                    {
                        
                        //get current quota
                        $get_quota_query = "SELECT quota FROM representative WHERE employeeID = '$employeeID' ";
                        $result = $conn->query($get_quota_query);
			$tempresult = $result->fetch_assoc(); 
                        $quota = $tempresult['quota'];
                        $temp = $quota + $quantity;
                        $return_quota_query = "UPDATE representative SET quota = '$temp'  WHERE employeeID = '$employeeID' ";
                        $conn->query($return_quota_query);
                    }
                    echo "<script> alert('order deleted');parent.location.href='Myorder.php'; </script>";

                }
		
            }
            else
            {
                
                echo "<script> alert('order not found');parent.location.href='Myorder.php'; </script>";

            }

            

        }


    }
    else
    {
        header("location: index.php");
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Woolin Auto face mask Sales Management System</title>
    <link rel="stylesheet" type="text/css" href="index.css"></link>
    <script type="text/javascript" src="order.js"></script>
    <style>
    #myorder{
        position: absolute;
        top: 400px;
        left:400px;
        background-color: cyan;
        width: 50%;
        margin: 0 auto;
        border: solid 1px #ff0000
    }
    #deleteform{
        position: absolute;
        top: 300px;
        left:400px;
        margin: 0 auto;
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
        <li><a href="order.php">Order</a></li>
        <li><a href="Myorder.php">My orderings</a></li>
        <li><a href="customerAccount.php">Account</a></li>
        <li><a href="Logout.php">Logout</a></li>
    </ul>
    </div> 
    <h2 id="subheader" >Your orders</h2>
    <div>
        <!-- customer orders-->
        <div>
            <?php
            //get order details
            $order_query = "SELECT * FROM ordering INNER JOIN representative  ON customer = '$username' AND ordering.employeeID = representative.employeeID";
            $result = $conn->query($order_query);
            
            //display all the orders
            echo "<table id=\"myorder\" border=\"1\">";
            echo "<tr>".
                    "<th>order ID</th>".
                    "<th>mask type</th>".
                    "<th>quantity</th>".
                    "<th>amount</th>".
                    "<th>representative</th>".
                    "<th>representative contact</th>".
                    "<th>orderStatus</th>".
                    "<th>time</th>".
                    "<th>if deletable</th>".
                "</tr>";
            while($row = $result->fetch_assoc())
            {
                //fetch all details of current order
                $orderID = $row['orderingID'];
                $masktype = $row['Masktype'];
                $quantity = $row['quantity'];
                $amount = $row['amount'];
                $representative = $row['username'];
                $repTel = $row['tel'];
                $status = $row['orderStatus'];
                $time = $row['orderedTime'];
                //display details in a table
                echo "<tr>".
                        "<td>$orderID</td>".
                        "<td>$masktype</td>".
                        "<td>$quantity</td>".
                        "<td>$amount</td>".
                        "<td>$representative</td>".
                        "<td>$repTel</td>".
                        "<td>$status</td>".
                        "<td>$time</td>";
                        
                //determine if this order is deletable

                $day=floor((strtotime($now)-strtotime($time))/86400);
                if(($day>=1) === true)
                {
                    echo "<td>Not deletable</td>";
                }
                else
                {
                    echo "<td>deletable</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
        <br/>
        <form action="Myorder.php" method="post" id="deleteform" >
            <label>
                Enter the order id you want to delete(a deletable one).
                <input type="text" size="20" name="orderingID" id="deletedID"/>
            </label>
            <br/>
            <label>
                Confirm your delete:
                <input type="submit" value="delete"/>
            </label>
        </form>
    </div>


</body>
</html>