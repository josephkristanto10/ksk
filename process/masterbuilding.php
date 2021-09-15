<?php
session_start();
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'code',
        'sistername',
        'branch',
        'telp',
        'description',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    $sessionidsister = $_SESSION['idsister'];

    $total_data = mysqli_query($conn, 
    "select lb.id, lb.idsetupsisterbranch ,  lb.status, lb.code, lb.barcode, lb.buildingname, lb.description, lsc.name, lbranch.branch from location_building lb 
    inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lb.idsetupsisterbranch 
    inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
    inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch where lsc.id = '".$sessionidsister."'
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select lb.id, lb.idsetupsisterbranch ,  lb.status, lb.code, lb.barcode, lb.buildingname, lb.description, lsc.name, lbranch.branch from location_building lb 
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lb.idsetupsisterbranch 
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch where lsc.id = '".$sessionidsister."'  ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select lb.id, lb.idsetupsisterbranch ,  lb.status, lb.code, lb.barcode, lb.buildingname, lb.description, lsc.name, lbranch.branch from location_building lb 
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lb.idsetupsisterbranch 
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch where lsc.id = '".$sessionidsister."'");

    } else {
        $query_data = mysqli_query($conn, "select lb.id, lb.idsetupsisterbranch ,  lb.status, lb.code, lb.barcode, lb.buildingname, lb.description, lsc.name, lbranch.branch from location_building lb 
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lb.idsetupsisterbranch 
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch where lsc.id = '".$sessionidsister."' and (
        lb.code LIKE '%$search%' 
        OR lb.buildingname LIKE '%$search%'
        OR lsc.name LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR lb.status LIKE '%$search%' )
        ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select lb.id, lb.idsetupsisterbranch ,  lb.status, lb.code, lb.barcode, lb.buildingname, lb.description, lsc.name, lbranch.branch from location_building lb 
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lb.idsetupsisterbranch 
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch where lsc.id = '".$sessionidsister."' and (
        lb.code LIKE '%$search%' 
        OR lb.buildingname LIKE '%$search%'
        OR lsc.name LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR lb.status LIKE '%$search%' )");
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
              
                "<label id ='name".$row['id']."'>".$row['buildingname']."</label>",
                "<label id ='branch".$row['id']."'>".$row['branch']."</label>",
                "<label id ='description".$row['id']."'>".$row['description']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id'].'-'.$row['idsetupsisterbranch'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
    $code = $_POST['code'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $desc = $_POST['desc'];


    $sql = "INSERT into location_building values(NULL,'-', '".$code."', '".$name."', '".$location."', '".$desc."', 'Active')";
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
    $code = $_POST['mycode'];
    $name = $_POST['myname'];
    $loc = $_POST['myloc'];
    $desc = $_POST['mydesc'];
    $sql = "update location_building set 
           code = '".$code."', 
           buildingname = '".$name."', 
           idsetupsisterbranch = '".$loc."',
           description = '".$desc."' 
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
    $sql = "update location_building set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
else if($tipe == "getprovince")
{
    $getid = $_POST['idcountry'];
    $sql = "select * from province where province.idcountry = '".$getid."' and province.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['name']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
else if($tipe == "getcity")
{
    $getid = $_POST['idprovince'];
    $sql = "select * from city where city.idprovince = '".$getid."' and city.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['name']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
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