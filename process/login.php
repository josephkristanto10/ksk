<?php
session_start();
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "checklogin")
{
    $username = $_POST['myusername'];
    $passwordfromuser = $_POST['mypassword'];
    $options = [
      'cost' => 11
    ];
    $sql = "select * from admin where username = '$username'";
    $res = $conn->query($sql);
    if($res->num_rows>0)
    {
        $row = mysqli_fetch_array($res);
        $passfromdb = $row['password'];
        if (password_verify($passwordfromuser, $passfromdb)) {
            $_SESSION['iduser'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            echo 'ok';
        } else {
            echo 'wrong';
        }
    }
    else{
        echo 'wrong';
    }
    // $hash = "$2y$11$/2UNEBgSo3sefqhJBgAeGeAOFiOHZcgwii2vvsGP6v4QALuThQaHm";
    
    // $mypassword =  password_hash("createyourpassword", PASSWORD_BCRYPT, $options)."\n";
    // echo $mypassword;
    // $sql = "INSERT INTO admin values(NULL, '1223456', '$username', '$mypassword')";
    // $res = $conn->query($sql);
    // echo $mypassword;
}
?>