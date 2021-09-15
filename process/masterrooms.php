<?php
session_start();
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'code',
        'room',
        'descriptionroom',
        'statusroom',
        'sistername',
        'branch',
        'buildingname',
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
    "select  lroom.idsetupbuildingfloor , lroom.id,lroom.barcode, lroom.code, lroom.room, lroom.description as descriptionroom, lroom.status as statusroom, lsc.name as sistername, lbranch.branch, lbuilding.buildingname, lfloor.floor, lbuilding.id as idbuilding, lfloor.id as idfloor from location_room lroom 
	inner join location_setup_building_floor lsbf on lroom.idsetupbuildingfloor = lsbf.idlocationsetupbuildingfloor 
    inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
    inner join location_floor lfloor on lfloor.id = lsbf.idfloor 
    inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch 
    inner join location_sister_company lsc on lsc.id = lssb.idsistercompany
    inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
     where lsc.id = '".$sessionidsister."'
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select  lroom.idsetupbuildingfloor , lroom.id,lroom.barcode, lroom.code, lroom.room, lroom.description as descriptionroom, lroom.status as statusroom, lsc.name as sistername, lbranch.branch, lbuilding.buildingname, lfloor.floor, lbuilding.id as idbuilding, lfloor.id as idfloor from location_room lroom 
        inner join location_setup_building_floor lsbf on lroom.idsetupbuildingfloor = lsbf.idlocationsetupbuildingfloor 
        inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
        inner join location_floor lfloor on lfloor.id = lsbf.idfloor 
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch 
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
         where lsc.id = '".$sessionidsister."'  ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select  lroom.idsetupbuildingfloor , lroom.id,lroom.barcode, lroom.code, lroom.room, lroom.description as descriptionroom, lroom.status as statusroom, lsc.name as sistername, lbranch.branch, lbuilding.buildingname, lfloor.floor, lbuilding.id as idbuilding, lfloor.id as idfloor from location_room lroom 
        inner join location_setup_building_floor lsbf on lroom.idsetupbuildingfloor = lsbf.idlocationsetupbuildingfloor 
        inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
        inner join location_floor lfloor on lfloor.id = lsbf.idfloor 
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch 
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
         where lsc.id = '".$sessionidsister."' ");

    } else {
        $query_data = mysqli_query($conn, "select  lroom.idsetupbuildingfloor , lroom.id,lroom.barcode, lroom.code, lroom.room, lroom.description as descriptionroom, lroom.status as statusroom, lsc.name as sistername, lbranch.branch, lbuilding.buildingname, lfloor.floor, lbuilding.id as idbuilding, lfloor.id as idfloor from location_room lroom 
        inner join location_setup_building_floor lsbf on lroom.idsetupbuildingfloor = lsbf.idlocationsetupbuildingfloor 
        inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
        inner join location_floor lfloor on lfloor.id = lsbf.idfloor 
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch 
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
         where lsc.id = '".$sessionidsister."' and (
        lbuilding.buildingname LIKE '%$search%'
        OR lfloor.floor LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR lsc.name LIKE '%$search%'
        OR lroom.code LIKE '%$search%'
        OR lroom.room LIKE '%$search%'
        OR lroom.description LIKE '%$search%'
        OR lroom.status LIKE '%$search%' )
        ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select  lroom.idsetupbuildingfloor , lroom.id,lroom.barcode, lroom.code, lroom.room, lroom.description as descriptionroom, lroom.status as statusroom, lsc.name as sistername, lbranch.branch, lbuilding.buildingname, lfloor.floor, lbuilding.id as idbuilding, lfloor.id as idfloor from location_room lroom 
        inner join location_setup_building_floor lsbf on lroom.idsetupbuildingfloor = lsbf.idlocationsetupbuildingfloor 
        inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
        inner join location_floor lfloor on lfloor.id = lsbf.idfloor 
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch 
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
         where lsc.id = '".$sessionidsister."' and (
        lbuilding.buildingname LIKE '%$search%'
        OR lfloor.floor LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR lsc.name LIKE '%$search%'
        OR lroom.code LIKE '%$search%'
        OR lroom.room LIKE '%$search%'
        OR lroom.description LIKE '%$search%'
        OR lroom.status LIKE '%$search%')");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['statusroom'] == "Active")
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
                "<label id ='buildingname".$row['id']."'>".$row['buildingname']."</label>",
                "<label id ='floor".$row['id']."'>".$row['floor']."</label>",
                // "<b>".$row['buildingname']."</b> <br><span class='badge badge-success'  style = 'background-color:#26a69a !important;font-size:12px;'>".$row['floor']."</span>",
                "<label id ='room".$row['id']."'>".$row['room']."</label>",
                "<label id ='description".$row['id']."'>".$row['descriptionroom']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id']."-".$row['idbuilding'].'-'.$row['idfloor'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
    $location = $_POST['location'];
    $building = $_POST['building'];
    $floor = $_POST['floor'];
    $rooms = $_POST['rooms'];
    $desc = $_POST['desc'];
    $sqlcodesetupbuildingfloor = "select location_setup_building_floor.idlocationsetupbuildingfloor as id from location_setup_building_floor where idbuilding = '$building' and idfloor = '$floor'";
    $ressetup = $conn->query($sqlcodesetupbuildingfloor);
    $rowid = mysqli_fetch_array($ressetup);
    $id = $rowid['id'];
    $sql = "INSERT into location_room values(NULL,'-', '".$code."' , '".$id."', '".$rooms."' , '".$desc."', 'Active')";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
    // echo $conn -> error;
    // echo "test";
    // echo $sql;
}
else if($tipe == "getbuilding")
{
    $id = $_POST['idsetup'];
    $sql = "select * from location_building where idsetupsisterbranch = '".$id."'";
    $res = $conn->query($sql);
    $listbuilding = array();
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['buildingname']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
else if($tipe == "getfloor")
{
    $idsister = $_POST['idsister'];
    $id = $_POST['idbuilding'];
    $sql = "select location_floor.floor, location_floor.id  from location_setup_building_floor 
    inner join location_floor on location_floor.id = location_setup_building_floor.idfloor  
    where location_setup_building_floor.idbuilding = '$id'";
    $res = $conn->query($sql);
    $listbuilding = array();
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['floor']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
else if($tipe == "changedata")
{

    $id  = $_POST['myid'];
    $code = $_POST['mycode'];
    $location = $_POST['mylocation'];
    $building = $_POST['mybuilding'];
    $floor = $_POST['myfloor'];
    $rooms = $_POST['myrooms'];
    $desc = $_POST['mydesc'];

    $sqlcodesetupbuildingfloor = "select location_setup_building_floor.idlocationsetupbuildingfloor as id from location_setup_building_floor where idbuilding = '$building' and idfloor = '$floor'";
    $ressetup = $conn->query($sqlcodesetupbuildingfloor);
    $rowid = mysqli_fetch_array($ressetup);
    $setupid = $rowid['id'];

    $sql = "update location_room set 
           idsetupbuildingfloor = '".$setupid."', 
           room = '".$rooms."',
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
    $sql = "update location_room set status = '".$stat."' where id = '".$myid."'";
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