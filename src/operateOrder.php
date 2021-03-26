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

        //get details of logged-in representative
        $rep_query = "SELECT * FROM representative WHERE username = '$username' ";
        $result = $conn->query($rep_query);
        $rep_row = $result->fetch_assoc();
        $employeeID = $rep_row['employeeID'];

        //if a delete request is submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //get the ordering ID to be deleted
            $deletedID = $_POST['orderingID'];
            //determine if this order is deletable
            $order_query = "SELECT * FROM ordering WHERE orderingID = '$deletedID' AND employeeID = '$employeeID' ";
            
            $result = $conn->query($order_query);
            
            $nrows = $result->num_rows;
            
            if(($nrows === 1) === true)
            {
                $row = $result->fetch_assoc();
                $orderedTime = $row['orderedTime'];
                $status = $row['orderStatus'];
                $day=floor((strtotime($now)-strtotime($orderedTime))/86400);
                //if 24h has passed
                if(((($day>=1) === true) || ($status === "normal") ) === true)
                {
                    echo "<script> alert('order cannot be deleted');parent.location.href='operateOrder.php'; </script>";
                }
                else
                {
                    //delete this order
                    $delete_order_query = "DELETE FROM ordering WHERE orderingID = $deletedID";
                    $result = $conn->query($delete_order_query);
                    echo "<script> alert('order deleted');parent.location.href='operateOrder.php'; </script>";                    

                    
                }

            }
            else
            {
                
                echo "<script> alert('order not found');parent.location.href='operateOrder.php'; </script>";
            }

            

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
    <script type="text/javascript" src="order.js"></script>
    <style>
    /* set the position for h2*/
    #subheader{
        position: absolute;
        top:220px;
        left: 400px;
        width: 50%;
        text-align: center;
    }
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
        <li><a href="operateOrder.php">Order</a></li>
        <li><a href="requestQuota.php">Request Quota</a></li>
        <li><a href="repAccount.php">Account</a></li>
        <li><a href="Logout.php">Logout</a></li>
    </ul>
    </div> 
    <h2 id="subheader">Your order</h2>
    <div>
        <!-- customer orders-->
        <div>
            <?php
            //get order details
            $order_query = "SELECT * FROM ordering INNER JOIN customer ON employeeID = '$employeeID' AND ordering.customer = customer.username";
            $result = $conn->query($order_query);
            
            //display all the orders
            echo "<table id=\"myorder\" border=\"1\">";
            echo "<tr>".
                    "<th>order ID</th>".
                    "<th>mask type</th>".
                    "<th>quantity</th>".
                    "<th>amount(￥)</th>".
                    "<th>customer</th>".
                    "<th>customer contact</th>".
                    "<th>orderStatus</th>".
                    "<th>time</th>".
                    "<th>click to delete</th>".
                "</tr>";
            while($row = $result->fetch_assoc())
            {
                
                //fetch all details of current order
                $orderID = $row['orderingID'];
                $masktype = $row['Masktype'];
                $quantity = $row['quantity'];
                $amount = $row['amount'];
                $customer = $row['customer'];
                $customerTel = $row['tel'];
                $status = $row['orderStatus'];
                $time = $row['orderedTime'];
                //display details in a table
                echo "<tr>".
                        "<td>$orderID</td>".
                        "<td>$masktype</td>".
                        "<td>$quantity</td>".
                        "<td>$amount</td>".
                        "<td>$customer</td>".
                        "<td>$customerTel</td>".
                        "<td>$status</td>".
                        "<td>$time</td>";
                        
                //determine if this order is deletable
                // an order is deletable for the representative
                //if and only if it exceeds the quota and is within 24h
                $day=floor((strtotime($now)-strtotime($time))/86400);
                if(((($day<1) === true) && ($status === "abnormal") ) === true)
                {
                    echo "<td>deletable</td>";
                }
                else
                {
                    echo "<td>Not deletable</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
        <br/>
        <form action="operateOrder.php" method="post" id="deleteform" >
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