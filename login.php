<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email=$_POST["email"];
    $pwd = isset($_POST["pwd"]) ? $_POST["pwd"] : "";
}

if (!empty($email) || !empty($pwd)){
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "test";

    //create connection 
    $conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);

    if(mysqli_connect_error()){
        die('Connection Error('.mysqli_connect_errno().')'.mysqli_connect_errno());
    } else {

        $SELECT = "SELECT email from register where email = ?";
        $stmt = $conn ->prepare($SELECT);
        $stmt ->bind_param("s",$email);
        $stmt ->execute();
        $stmt_result = $stmt->get_result();
        if($stmt_result->num_rows > 0)
        {
            $data = $stmt_result->fetch_assoc();
            if($data['email']=='adminstrator123@gmail.com'){
                echo "<script type='text/javascript'>
                alert('Admin Login success!!');
                window.location.href = 'admin-dashboard.html';
            </script>";
            }
            else if($data['email'] === $email){
                echo "<script type='text/javascript'>
                alert('Login success!!');
                window.location.href = 'home.html';
            </script>";
            } else{
                echo "<h2>invalid  email or password</h2>";
            }
        }else{
            echo "<h2>invalid email or password</h2>";
        }
    }
}
?>