<?php
	//Check if a user is logged in
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    }

    $user = $_SESSION['user'];

    if(!empty($accesslevel)){
        if($_SESSION['rank'] >= $accesslevel) 
        {

        }else{
            $_SESSION['message'] = "You do not have permission to access $page!";
            $url = $_SERVER['REQUEST_URI'];
            $message = "employee number " . $user . " tried accessing " . $url . " at " . date("Y/m/d h:i:sa");
            $sql="INSERT INTO errorlog (message) VALUES ('$message')";
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                $_SESSION['errmessage'] = "Error: $sql mysqli_error($conn)";
            }

            header("Location: index.php");
            die("redirecting to index.php");
        }
    }
?>
<div>User ID:<?php echo $user; ?></div>

<button class="button" onclick="location.href='login.php';">Logout</button>

<div id=systemMessage><b>System Message:</b><br> <?php echo $_SESSION['message']; ?></div>