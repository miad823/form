<!DOCTYPE html>
<html>
    
<head>
    <title>Form</title>
 
    <style>
    


.container {
    display: grid;
     grid-template-rows: [row1-start] 20% [row1-end row2-start] 60% [row2-end row3-start] 20% [row3-end];
    padding: 10%; 
    justify-content: center;
      background-color: #b98fc0; 
    margin-top: 10%;
    margin-bottom: 10%;
    margin-left: 30%;
    margin-right: 30%;
}

.name, .fav, .submit,  {
  grid-column-start: 1;
  grid-column-end: 3;
  grid-row-start: row1-start grid-row-end: 3;
     font-family: 'Nunito Sans', sans-serif; 
    padding: 2%;
    text-align: center;
}

    </style>
    
    <?php
session_start();
if ($_SERVER[REQUEST_METHOD] == 'POST') {
// Check password
$password = trim($_POST['password']);
if ($password == "mypassword") {
$_SESSION['login'] = TRUE;
// Go to password protected page
header ('Location: index.php');
} else {
$_SESSION['login'] = FALSE;
// Set an error
$error = "<p style=\"color:red\">Sorry, the password is incorrect.</p>";
}
}
?>
    
</head>
    
<body>
    
    <?php
    echo "<pre>", print_r($_POST, true), "</pre>";   
    
    if(isset($_POST['submit'])) 
    
    {
    
    $name = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING); 
    
        $to = 'mia.doyon@gmail.com';
        $subject = 'New sign in!!!';
        $message = "Someone is attempting to sign in.\n\n" 
                   ."Name: $name\n\n";
        $result = mail ($to, $subject, $message);
        
        // Connect to Database 
        $dbhostname = 'localhost';
        $dbusername ='miadoyon_MeezyD';
        $dbpassword = 'Gelato';
        $dbdatabase = 'miadoyon_userform';
            
        $mysqli = new mysqli($dbhostname, $dbusername, $dbpassword, $dbdatabase);
        if ($mysqli->connect_errno){
            echo "<p>MySQL Error" . $mysqli->error;  
        }else{
            echo'database connection success!!';
        }
            
            $name = $mysqli->real_escape_string($name);
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO `account` (`accountid`, `name`, `password`) VALUES (NULL, '$name', '$password')";
        
        if ($mysqli->query($query)){
            echo 'Insert Data Successful';
        } else {
            echo "<p>Insert Error" . $mysqli->error;
        }
        }
    
    ?>

<div class="container">
    
<form method="post">
<div class="name"> 
        Username:<br>
  <input type="text" name="username">
  <br>
</div>
 
<div class="fav">
    Password:<br>
  <input type="text" name="password">
  <br><br>
</div>
    
    <div class="submit"> 
  <input type="submit" name="submit" value="Submit">
</div>
    
</div>
</form> 

</body>
</html>

