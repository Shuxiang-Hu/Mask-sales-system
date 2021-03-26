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
        //get region of customer
        $customer_query = "SELECT region FROM customer WHERE username = '$username' ";
        $result = $conn->query($customer_query);
        $row = mysqli_fetch_assoc($result);
	    $region = $row['region'];

        //if an order is submitted

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            
            //get order details
            $masktype = "undifined";
            switch($_POST['mask'])
            {
                case "4":
                    $masktype = "N95 respirator";
                break;

                case "1.5":
                    $masktype = "surgical mask";
                break;

                case "15.9":
                    $masktype = "N95 surgical respirator";
                break;

                default:
                    $masktype = "unknown";
                break;
            }

            $quantity = (int)$_POST['quantity'];
            $amount = (double)$_POST['total']; 

            //get the employee ID
            $repUsername = $_POST['rep']; 
            $employeeID_query = "SELECT * FROM representative WHERE username = '$repUsername' ";
	        $tempresult = $conn->query($employeeID_query); 			
            $result = mysqli_fetch_assoc($tempresult);
            $employeeID = (int)($result['employeeID']);
            //get the quota
            $quota = (int)($result['quota']);
            var_dump($quota);

            if($quota >= $quantity)
            {
                $status = "normal";
                $temp = ($quota - $quantity);
                
                $reduce_quota_query = "UPDATE representative SET quota = '$temp' WHERE username = '$repUsername' ";
                $conn->query($reduce_quota_query);
                
            }
            else
            {
                $status = "abnormal";
            }
	
            //get China time
            $timezone_out = date_default_timezone_get();
            date_default_timezone_set('Asia/Shanghai');
            $time = date('Y-m-d H:i:s');
            date_default_timezone_set($timezone_out);
            
            
            $ordering_query = "INSERT INTO ordering (Masktype,quantity,amount,customer,employeeID,orderStatus,orderedTime)"
                              ."VALUES ('$masktype', '$quantity', '$amount', '$username', '$employeeID', '$status', '$time') ";
            
            $conn->query($ordering_query);

           
            echo "<script> alert('Order addded successfully.');parent.location.href='Myorder.php'; </script>";


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
    .mask_img{
        width:15%;
        height:15%;
    }
    /* set the position for h2*/
    #subheader{
        position: absolute;
        top:220px;
        left: 400px;
        width: 50%;
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
    <h2 id="subheader">Woolin Auto face mask Sales Management System</h2>
    <div id="orderbox" class="mainbox" style="height: 700px;">
        <h2 style="text-align: center;">Purchase your item</h2>
        <!-- ordering form-->
        <form action="order.php" method="post" >
        Select mask type:
        <br/>
        <br/>
        <label>
            <input type="radio" name="mask" value="4" id="N95 respirator" checked="checked" onchange="computeCost();"/> 
            <b>N95 respirator</b>
            <br/>
            <img src="N95 respirator.jpg" class="mask_img" />
        </label>
        <br/>
        <br/>
        <label>
            <input type="radio" name="mask" value="1.5" id="surgical mask" onchange="computeCost();"/> 
            <b>surgical mask</b>
            <br/>
            <img src="surgical mask.jpg" class="mask_img" />
        </label>
        <br/>
        <br/>
        <label>
            <input type="radio" name="mask" value="15.9" id="N95 surgical respirator" onchange="computeCost();"/> 
            <b>N95 surgical respirator</b>
            <br/>
            <img src="surgical N95 respirator.jpg" class="mask_img" />
        </label>
        <br/>
        <br/>
        <label>
            Quantity:
            <!-- let customer choose the quantity-->
            <select id="quantity" name="quantity" onchange="computeCost();">
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
            Appoint a representative:
            <select id="rep" name="rep">
            <?php
                $repquery = "SELECT * FROM representative WHERE region = '$region' ";
                $reps = $conn->query($repquery);
                while($rows = $reps->fetch_assoc())
                {
                    $tempusername = $rows['username'];
                    $tempquota = $rows['quota'];
                    
                    echo "<option value=\"$tempusername\">$tempusername (remaining quota: $tempquota)</option>";
                }
            ?>
            </select>
        </label>
        <!-- show the amount of sales-->
        <br/>
        <br/>
        <label>
            Total:
            <input type="text" size="10" id="total" name="total" value="4" onfocus="this.blur();" />
        </label>
        <label>
            <input type="submit" value="Confirm purchase"/>
        </label>
        </form>
    </div>


</body>
</html>