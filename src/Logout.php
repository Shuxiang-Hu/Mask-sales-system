<?php
    session_start();
    
    //if a use logged in
    if($_SESSION['username'])
    {   
            header("location: index.php");
            session_destroy();

    }
    

?>
