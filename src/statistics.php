<?php
session_start();

//creat connection
$conn = new mysqli('localhost','shysh1','shysh1','shysh1'); 
    
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

//get China time
$timezone_out = date_default_timezone_get();
date_default_timezone_set('Asia/Shanghai');
$now = date('Y-m-d H:i:s');
date_default_timezone_set($timezone_out);

//total number of masks sold without abnormality
$total_normal = 0;
//total number of masks sold with abnormality
$total_abnormal = 0;
//total revenue of masks sold without abnormality
$revenue_normal = 0;
//total revenue of masks sold with abnormality
$revenue_abnormal = 0;
//total number of masks sold in the past four weeks without abnormality
$recent_total_normal = 0;
//total number of masks sold without abnormality
$recent_total_abnormal = 0;
//total number of masks under ordering without abnormality
$under_ordering_normal = 0;
//total number of masks under ordering with abnormality
$under_ordering_abnormal = 0;
//total number of abnormal orders that elapsed 24h in the past 24h
$num_abnormalies = 0; 
//the total number of masks sold in different regions
$total_China_normal = 0;
$total_China_abnormal = 0;
$total_Japan_normal = 0;
$total_Japan_abnormal = 0;
$total_America_normal = 0;
$total_America_abnormal = 0;
$total_British_normal = 0;
$total_British_abnormal = 0;
$total_Korean_normal = 0;
$total_Korean_abnormal = 0;
$total_Russia_normal = 0;
$total_Russia_abnormal = 0;
//if the manager logged in
$username = $_SESSION['username'];

if($_SESSION['username'])
{
    //get details of orders
    $order_query = "SELECT * FROM ordering INNER JOIN customer WHERE ordering.customer = customer.username";
    $order_result = $conn->query($order_query);
    while($row = $order_result->fetch_assoc())
    {
        
        //get details of the order
        $quantity = $row['quantity'];
        $amount = $row['amount'];
        $status = $row['orderStatus'];
        $orderedTime = $row['orderedTime'];
        $region = $row['region'];
        $day=floor((strtotime($now)-strtotime($orderedTime))/86400);

        //calculat statistics without abnormality
        if(($status === "normal") === true)
        {
            //24h has passed and this order is considered as sold
            if(($day >= 1) === true)
            {
                $total_normal += $quantity;
                $revenue_normal += $amount;
                
                //find the number of masks sold in the past four weeks
                if($day <= 28)
                {
                    $recent_total_normal += $quantity;
                }

                //calculate number of masks sold in different regions
                switch($region){
                    case "China" :
                        $total_China_normal+= $quantity;
                    break;

                    case "Japan" :
                        $total_Japan_normal+= $quantity;
                    break;

                    case "America" :
                        $total_America_normal+= $quantity;
                    break;

                    case "British" :
                        $total_British_normal+= $quantity;
                    break;

                    case "Korean" :
                        $total_Korean_normal+= $quantity;
                    break;

                    case "Russia" :
                        $total_Russia_normal+= $quantity;
                    break;

                }
            }
            else
            {
                $under_ordering_normal += 1;
            }
        }
        //calculate statistic with abnormality only
        else
        {
            
            if(($day >= 1) === true)
            {
                $total_abnormal += $quantity;
                $revenue_abnormal += $amount;
                
                //find the number of masks sold in the past four weeks
                if(($day <= 28) === true)
                {
                    $recent_total_abnormal += $quantity;
                }

                //calculate total number of abnormal orders that elapsed 24h in the past 24h
                if(($day <= 2) === true)
                {
                    $num_abnormalies += 1; 
                }

                //calculate number of masks sold in different regions
                switch($region){
                case "China" :
                    $total_China_abnormal+= $quantity;
                    break;
                
                case "Japan" :
                    $total_Japan_abnormal+= $quantity;
                    break;
                
                case "America" :
                    $total_America_abnormal+= $quantity;
                    break;
                
                case "British" :
                    $total_British_abnormal+= $quantity;
                    break;
                
                case "Korean" :
                    $total_Korean_abnormal+= $quantity;
                    break;
                
                case "Russia" :
                    $total_Russia_abnormal+= $quantity;
                    break;
                
                }
            }
            else
            {
                $under_ordering_abnormal += 1;
            }
        }
        


    }
    //calculate statcis with abnormality
    $total_abnormal += $total_normal;
    $revenue_abnormal += $revenue_normal;
    $recent_total_abnormal += $recent_total_normal;
    $total_China_abnormal += $total_China_normal;
    $total_Japan_abnormal += $total_Japan_normal;
    $total_America_abnormal += $total_America_normal;
    $total_British_abnormal += $total_British_normal;
    $total_Korean_abnormal += $total_Korean_normal;
    $total_Russia_abnormal += $total_Russia_normal;

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

    #statistics2{
        position: absolute;
        top: 550px;
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
            <th>General statistics</th>
            <th>total number of masks sold</th>
            <th>total revenues(￥)</th>
            <th>masks sold in past four weeks</th>
            <th>masks under ordering</th>
            <th>expired abnormal orders in last 24h</th>
        </tr>
        <tr>
            <th>without abnormality</th>
            <td><?php echo "$total_normal";?></td>
            <td><?php echo "$revenue_normal";?></td>
            <td><?php echo "$recent_total_normal";?></td>
            <td><?php echo "$under_ordering_normal";?></td>
            <td rowspan="2"><?php echo "$num_abnormalies";?></td>
        </tr>
        <tr>
            <th>with abnormality</th>
            <td><?php echo "$total_abnormal";?></td>
            <td><?php echo "$revenue_abnormal";?></td>
            <td><?php echo "$recent_total_abnormal";?></td>
            <td><?php echo "$under_ordering_abnormal";?></td>
            
        </tr>
    </table>
    <table id="statistics2" border="1" >
        <tr>
            <th>Regional statistics</th>
            <th>China</th>
            <th>Japan</th>
            <th>America</th>
            <th>British</th>
            <th>Korean</th>
            <th>Russia</th>
        </tr>
        <tr>
            <th>total quantity without abnormality</th>
            <td><?php echo "$total_China_normal";?></td>
            <td><?php echo "$total_Japan_normal";?></td>
            <td><?php echo "$total_America_normal";?></td>
            <td><?php echo "$total_British_normal";?></td>
            <td><?php echo "$total_Korean_normal";?></td>
            <td><?php echo "$total_Russia_normal";?></td>
        </tr>
        <tr>
            <th>total quantity with abnormality</th>
            <td><?php echo "$total_China_abnormal";?></td>
            <td><?php echo "$total_Japan_abnormal";?></td>
            <td><?php echo "$total_America_abnormal";?></td>
            <td><?php echo "$total_British_abnormal";?></td>
            <td><?php echo "$total_Korean_abnormal";?></td>
            <td><?php echo "$total_Russia_abnormal";?></td>
            
        </tr>
    </table>

</body>
</html>