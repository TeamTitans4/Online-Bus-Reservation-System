<?php
define('DBSERVER', 'localhost');
define('DBUSERNAME', 'root');
define('DBPASSWORD', '');
define('DBNAME', 'bus');
$db=mysqli_connect(DBSERVER,DBUSERNAME,DBPASSWORD,DBNAME);
if($db===false){
    die("Error: connection error.".mysql_connect_error());
}
require_once "session.php";
$error='';
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['login'])){
    $username =trim($_POST['username']);
    $password =trim($_POST['password']);
            //validate if email is empty
            if(empty($username)){
               $error='<p class="error">Please enter username</p>';
            }
            //validate if password is empty
            if(empty($password)){
                $error='<p class="error">Please enter the password</p>';
            }
            if(empty($error)){
                $query1="SELECT driver_password FROM driver WHERE driver_id ='$username'";
                $res=mysqli_query($db,$query1);
                if($row = mysqli_fetch_row($res)){
                    if(password_verify($password,$row[0])){
                        $query2="SELECT bus_no FROM bus WHERE driver_id ='$username'";
                        echo $query2;
                        $res1=mysqli_query($db,$query2);
                        $row1 = mysqli_fetch_row($res1);
                        header("location:driver.php?bus_no=$row1[0]");

                        
                        
                        
                        

                    }
                }
                else{
                if($query = $db->prepare("SELECT password FROM customer WHERE username =? ")){
                   $query->bind_param('s',$username);
                   $query->execute();
                   $query->bind_result($temp);
                   $row = $query->fetch();
                   if($row){
                       if(password_verify($password,$temp)){
                           $_session["username"]='username';
                           if($username=="saivenkatesh")
                           header("location:admin/adminhome.html");
                           else
                           header("location:mainpage.html");
                           exit;
                       }else{
                           $error='<p class="error">The password is not vaild</p>';
                           echo "error";
                       }
                   }
                    else{
                    $error='<p class="error">No user exists with the given details</p>';
                }
            }}

    }
mysqli_close($db);
}