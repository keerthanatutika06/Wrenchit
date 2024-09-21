<html>
    <head>
</head>
<body>
<?php
$username = $_POST['uname'];
$email = $_POST['email'];
$pwd = $_POST['pwd'];
$confirmpassword = $_POST['confirm-pwd'];


if (!empty($username) || !empty($email) || !empty($pwd) || !empty($confirmpassword)){
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "test";

    //create connection 
    $conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);

    if(mysqli_connect_error()){
        die('Connection Error('.mysqli_connect_errno().')'.mysqli_connect_errno());
    } else {
        $SELECT = "SELECT email from register where email = ? Limit 1";
        $INSERT = "INSERT  into register (username,email,pwd,confirmpassword) values(?,?,?,?)";

        $stmt = $conn ->prepare($SELECT);
        $stmt ->bind_param("s",$email);
        $stmt ->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum==0){
            $stmt ->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss",$username,$email,$pwd,$confirmpassword);
            $stmt->execute();
            if($stmt){
                echo "<script type='text/javascript'>
                alert('Registration successful!');
                window.location.href = 'index.html';
            </script>";
                exit();
            }
        }
        else{
            echo "Someone already registered using this email";
        }
        $stmt->close();
        $conn->close();
    }
}
else{
    echo "All fields are required";
    die();
}

?>
</body>
</html>