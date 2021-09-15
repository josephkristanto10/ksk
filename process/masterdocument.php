<?php
require '../connection.php';
session_start();
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'code',
        'name',
        'tanggaldokumen',
        'branch',
        'divisi',
        'department',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "SELECT document.*, lbranch.branch, divi.divisi, depa.department  FROM document
    inner join location_branch lbranch on lbranch.idbranch = document.idbranch
    inner join divisi divi on divi.id = document.iddivisi
    inner join department depa on depa.id = document.iddepartement
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT document.*, lbranch.branch, divi.divisi, depa.department  FROM document
        inner join location_branch lbranch on lbranch.idbranch = document.idbranch
        inner join divisi divi on divi.id = document.iddivisi
        inner join department depa on depa.id = document.iddepartement ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT document.*, lbranch.branch, divi.divisi, depa.department  FROM document
        inner join location_branch lbranch on lbranch.idbranch = document.idbranch
        inner join divisi divi on divi.id = document.iddivisi
        inner join department depa on depa.id = document.iddepartement ");
    } else {
        $query_data = mysqli_query($conn, "SELECT document.*, lbranch.branch, divi.divisi, depa.department  FROM document
        inner join location_branch lbranch on lbranch.idbranch = document.idbranch
        inner join divisi divi on divi.id = document.iddivisi
        inner join department depa on depa.id = document.iddepartement 
        WHERE document.code LIKE '%$search%' 
        OR document.name LIKE '%$search%'
        OR document.tanggaldokumen LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR divi.divisi LIKE '%$search%'
        OR depa.department LIKE '%$search%'
        OR document.status LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT document.*,lbranch.branch, divi.divisi, depa.department  FROM document
        inner join location_branch lbranch on lbranch.idbranch = document.idbranch
        inner join divisi divi on divi.id = document.iddivisi
        inner join department depa on depa.id = document.iddepartement 
        WHERE document.code LIKE '%$search%' 
        OR document.name LIKE '%$search%'
        OR document.tanggaldokumen LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR divi.divisi LIKE '%$search%'
        OR depa.department LIKE '%$search%'
        OR document.status LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['status'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['id']."-".$myactionsetto."')><i class='icon-check'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['id']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label id ='code".$row['id']."'>".$row['code']."</label>",
                "<label id ='branch".$row['id']."'>".$row['branch']."</label>",
                "<label id ='divisi".$row['id']."'>".$row['divisi']."</label>",
                "<label id ='department".$row['id']."'>".$row['department']."</label>",
                "<label id ='name".$row['id']."'>".$row['name']."</label>",
                "<label id ='tanggaldokumen".$row['id']."'>".$row['tanggaldokumen']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id'].'-'.$row['idsistercompany'].'-'.$row['idbranch'].'-'.$row['iddivisi'].'-'.$row['iddepartement'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
                            Edit</a>
                        
                        '.$myaction.'
                   
                    </div>
                </div>
            </div>'
            ];
        }
    }
    
    $response['recordsTotal'] = 0;
    if($total_data <> FALSE) {
        $response['recordsTotal'] = mysqli_num_rows($total_data);
    }
    
    $response['recordsFiltered'] = 0;
    if($total_filtered <> FALSE) {
        $response['recordsFiltered'] = mysqli_num_rows($total_filtered);
    }  
    
    echo json_encode($response);
}
else if($tipe == "add"){

    $idsister = $_SESSION['idsister'];
    $code = $_POST['code'];
    $idbranch = $_POST['idbranch'];
    $iddivisi = $_POST['iddivisi'];
    $iddepartement = $_POST['iddepartement'];
    $name = $_POST['name'];
    $tanggaldokumen = $_POST['tanggaldokumen'];

    $sql = "INSERT into document values(NULL,'".$code."','".$idsister."', '".$idbranch."', '".$iddivisi."', '".$iddepartement."', '".$name."', '".$tanggaldokumen."', 'Active')";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
    // echo $sql;
}
else if($tipe == "changedata")
{

    $id  = $_POST['myid'];
    $idsister = $_SESSION['idsister'];
    $code = $_POST['code'];
    $branch = $_POST['branch'];
    $divisi = $_POST['divisi'];
    $department = $_POST['department'];
    $name = $_POST['name'];
    $tanggal = $_POST['tanggal'];
    $sql = "update document set 
           idsistercompany = '".$idsister."', 
           idbranch = '".$branch."', 
           iddivisi = '".$divisi."',
           iddepartement = '".$department."',
           code = '".$code."',
           tanggaldokumen = '".$tanggal."',
           name = '".$name."' 
            where id = '".$id."'";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
}
else if($tipe == "setstatus")
{
    $myid = $_POST['myidchange'];
    $stat = $_POST['stat'];
    $sql = "update document set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
else if($tipe == "getdepartment")
{
    $getid = $_POST['iddivisi'];
    $sql = "select *, department.id as iddepartment from department inner join divisi on divisi.id = department.iddivisi  where divisi.id = '".$getid."' and department.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['iddepartment']."' >".$r['department']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
?>