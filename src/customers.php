<?php
session_start();

//creat connection
$conn = new mysqli('localhost','shysh1','shysh1','shysh1'); 
    
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

//if the manager logged in
if($_SESSION['username'])
{
    //get details of customers
    $customer_query = "SELECT * FROM customer";
    $customer_result = $conn->query($customer_query);
   
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

    #statistics{
        position: absolute;
        top: 300px;
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
    <table id="statistics" border="1" >
        <tr>
            <th>Customer user name</th>
            <th>Total number of orders</th>
            <th>Total number of masks</th>
            <th>Total amount(￥)</th>
            <th>Average(masks per order)</th>
            <th>Region</th>
            <th>Tel</th>
        </tr>
        <?php
        //get China time
        $timezone_out = date_default_timezone_get();    
        date_default_timezone_set('Asia/Shanghai');
        $now = date('Y-m-d H:i:s');
        date_default_timezone_set($timezone_out);

        while($row = $customer_result->fetch_assoc())
        {
            
            //get details of the customer
            $username = $row['username'];
            $quantity = 0;
            $amount = 0;
            $region = $row['region'];
            $tel = $row['tel'];
            $num_order = 0;
            $num_mask = 0;
            $total_amount = 0;
            $average = 0;
            $order_query = "SELECT * FROM ordering WHERE customer = '$username' ";
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

            if($num_order !== 0)
            {
                $average = $num_mask / $num_order;
            }

            echo "<tr>".
                    "<td>$username</td>".
                    "<td>$num_order</td>".
                    "<td>$num_mask</td>".
                    "<td>$total_amount</td>".
                    "<td>$average</td>".
                    "<td>$region</td>".
                    "<td>$tel</td>".
                 "</tr>";
        }
        
        ?>
    </table>
</body>
</html>