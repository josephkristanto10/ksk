<?php
session_start();
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "group"){
    header('Content-type: application/json');
    $id = $_POST['idgroup'];
    $sql = "select id as jumlahactive from kategori_subgroup where idkategoriaset ='$id' ";
    $res = $conn->query($sql);
    $jumlahquery = $res->num_rows;

    $stats = "";
    if($jumlahquery==0)
    {
        $stats = "ok";
      
        $sqldeletechild = "delete from kategori_subgroup where idkategoriaset ='$id'";
        $resdeletechild = $conn->query($sqldeletechild);
    }
    else{
        $stats = "failed";
    }
    echo  json_encode(array(
        'status'=>$stats,
        'jumlah'=>$jumlahquery,
     ));
}
else if($tipe == "subgroup"){
    header('Content-type: application/json');
    $id = $_POST['idsubgroup'];
    $sql = "select id as jumlahactive from kategori_categorysubgroup where idsubgroup ='$id' ";
    $res = $conn->query($sql);
    $jumlahquery = $res->num_rows;
    $stats = "";
    if($jumlahquery==0)
    {
        $stats = "ok";
        $sqldelete = "delete from kategori_subgroup where id = '$id'";
        $resdelete = $conn->query($sqldelete);

   
    }
    else{
        $stats = "failed";
    }
    
    echo  json_encode(array(
        'status'=>$stats,
        'jumlah'=>$jumlahquery,
     ));
}
else if($tipe == "category"){
    header('Content-type: application/json');
    $id = $_POST['idcategory'];
    $sql = "select id as jumlahactive from asset where idcategory ='$id' ";
    $res = $conn->query($sql);
    $jumlahquery = $res->num_rows;
    $stats = "";
    if($jumlahquery==0)
    {
        $stats = "ok";
        $sqldelete = "delete from kategori_categorysubgroup where id = '$id'";
        $resdelete = $conn->query($sqldelete);

   
    }
    else{
        $stats = "failed";
    }
    
    echo  json_encode(array(
        'status'=>$stats,
        'jumlah'=>$jumlahquery,
     ));
}
else if($tipe == "template"){
    header('Content-type: application/json');
    $id = $_POST['idtemplate'];
    $sql = "select id as jumlahactive from asset where idtemplate ='$id'";
    $res = $conn->query($sql);
    $jumlahquery = $res->num_rows;
    $stats = "";
    if($jumlahquery==0)
    {
        $stats = "ok";
        $sqldelete = "delete from template where id = '$id'";
        $resdelete = $conn->query($sqldelete);

      
    }
    else{
        $stats = "failed";
    }
    
    echo  json_encode(array(
        'status'=>$stats,
        'jumlah'=>$jumlahquery,
     ));
}
else if($tipe == "condition")
{
    header('Content-type: application/json');
    $id = $_POST['idcondition'];
    $sql = "select id as jumlahactive from asset where idcondition ='$id' ";
    $res = $conn->query($sql);
    $jumlahquery = $res->num_rows;
    $stats = "";
    if($jumlahquery==0)
    {
        $stats = "ok";
        $sqldelete = "delete from conditions where id = '$id'";
        $resdelete = $conn->query($sqldelete);

      
    }
    else{
        $stats = "failed";
    }
    
    echo  json_encode(array(
        'status'=>$stats,
        'jumlah'=>$jumlahquery,
     ));
}
else if($tipe == "initial_condition")
{
    header('Content-type: application/json');
    $id = $_POST['idinitialcondition'];
    $sql = "select id as jumlahactive from asset where idinitialcondition ='$id' ";
    $res = $conn->query($sql);
    $jumlahquery = $res->num_rows;
    $stats = "";
    if($jumlahquery==0)
    {
        $stats = "ok";
        $sqldelete = "delete from initial_condition where id = '$id'";
        $resdelete = $conn->query($sqldelete);

     
    }
    else{
        $stats = "failed";
    }
    
    echo  json_encode(array(
        'status'=>$stats,
        'jumlah'=>$jumlahquery,
     ));
}
?>