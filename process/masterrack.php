<?php
require '../connection.php';
session_start();
$myses = $_SESSION['idsister'];
$mysesname = $_SESSION['namasister'];
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'code',
        'branch',
        'buildingname',
        'floor',
        'room',
        'rackname',
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
    "SELECT rack.id , rack.idsistercompany as idsister, rack.idbranch as idbranch, rack.idbuilding as idbuilding, rack.idfloor as idfloor, rack.idroom as idroom, rack.idsistercompany, rack.idbranch, rack.idbuilding, rack.idfloor, rack.idroom, rack.code, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, rack.rackname, rack.description, rack.status FROM rack 
    inner join location_sister_company lsc on lsc.id = rack.idsistercompany
    inner join location_branch lbranch on lbranch.idbranch = rack.idbranch
    inner join location_building lbuilding on lbuilding.id = rack.idbuilding
    inner join location_floor lfloor on lfloor.id = rack.idfloor
    inner join location_room lroom on lroom.id = rack.idroom
    where lsc.id = '".$sessionidsister."'
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT rack.id , rack.idsistercompany as idsister, rack.idbranch as idbranch, rack.idbuilding as idbuilding, rack.idfloor as idfloor, rack.idroom as idroom, rack.idsistercompany, rack.idbranch, rack.idbuilding, rack.idfloor, rack.idroom, rack.code, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, rack.rackname, rack.description, rack.status FROM rack 
        inner join location_sister_company lsc on lsc.id = rack.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = rack.idbranch
        inner join location_building lbuilding on lbuilding.id = rack.idbuilding
        inner join location_floor lfloor on lfloor.id = rack.idfloor
        inner join location_room lroom on lroom.id = rack.idroom where lsc.id = '".$sessionidsister."' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT rack.id, rack.idsistercompany as idsister, rack.idbranch as idbranch, rack.idbuilding as idbuilding, rack.idfloor as idfloor, rack.idroom as idroom, rack.idsistercompany, rack.idbranch, rack.idbuilding, rack.idfloor, rack.idroom,  rack.code, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, rack.rackname, rack.description, rack.status FROM rack 
        inner join location_sister_company lsc on lsc.id = rack.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = rack.idbranch
        inner join location_building lbuilding on lbuilding.id = rack.idbuilding
        inner join location_floor lfloor on lfloor.id = rack.idfloor
        inner join location_room lroom on lroom.id = rack.idroom where lsc.id = '".$sessionidsister."'");

    } else {
        $query_data = mysqli_query($conn, "SELECT rack.id, rack.idsistercompany as idsister, rack.idbranch as idbranch, rack.idbuilding as idbuilding, rack.idfloor as idfloor, rack.idroom as idroom, rack.idsistercompany, rack.idbranch, rack.idbuilding, rack.idfloor, rack.idroom,  rack.code, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, rack.rackname, rack.description, rack.status FROM rack 
        inner join location_sister_company lsc on lsc.id = rack.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = rack.idbranch
        inner join location_building lbuilding on lbuilding.id = rack.idbuilding
        inner join location_floor lfloor on lfloor.id = rack.idfloor
        inner join location_room lroom on lroom.id = rack.idroom 
        where lsc.id = '".$sessionidsister."' and (
        rack.code LIKE '%$search%' 
        OR lbranch.branch LIKE '%$search%'
        OR lbuilding.buildingname LIKE '%$search%'
        OR lfloor.floor LIKE '%$search%'
        OR lroom.room LIKE '%$search%'
        OR rack.rackname LIKE '%$search%'
        OR rack.description LIKE '%$search%'
        OR rack.status LIKE '%$search%' ) 
        ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT rack.id, rack.idsistercompany as idsister, rack.idbranch as idbranch, rack.idbuilding as idbuilding, rack.idfloor as idfloor, rack.idroom as idroom,  rack.code, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, rack.rackname, rack.description, rack.status FROM rack 
        inner join location_sister_company lsc on lsc.id = rack.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = rack.idbranch
        inner join location_building lbuilding on lbuilding.id = rack.idbuilding
        inner join location_floor lfloor on lfloor.id = rack.idfloor
        inner join location_room lroom on lroom.id = rack.idroom 
        where lsc.id = '".$sessionidsister."' and (
        rack.code LIKE '%$search%' 
        OR lbranch.branch LIKE '%$search%'
        OR lbuilding.buildingname LIKE '%$search%'
        OR lfloor.floor LIKE '%$search%'
        OR lroom.room LIKE '%$search%'
        OR rack.rackname LIKE '%$search%'
        OR rack.description LIKE '%$search%'
        OR rack.status LIKE '%$search%' )");
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
                "<span class='pointer-element badge badge-success' id ='".$row['id']."'  data-id='".$row['id']."'><i class='icon-plus3'></i></span>",
                "<label id ='code".$row['id']."'>".$row['code']."</label>",
                "<label id ='branch".$row['id']."'>".$row['branch']."</label>",
                "<label id ='building".$row['id']."'>".$row['buildingname']."</label>",
                "<label id ='floor".$row['id']."'>".$row['floor']."</label>",
                "<label id ='room".$row['id']."'>".$row['room']."</label>",
                "<label id ='rackname".$row['id']."'>".$row['rackname']."</label>",
                "<label id ='description".$row['id']."'>".$row['description']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id'].'-'.$row['idsister'].'-'.$row['idbranch'].'-'.$row['idbuilding'].'-'.$row['idfloor'].'-'.$row['idroom'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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


    $mycode = $_POST['mycode'];
    $mybranch = $_POST['mybranch'];
    $mybuilding = $_POST['mybuilding'];
    $myfloor = $_POST['myfloor'];
    $myrooms = $_POST['myrooms'];
    $myrackname = $_POST['myrackname'];
    $description = $_POST['mydescription'];
    $sql = "INSERT into rack values(NULL,'".$mycode."', '".$myses."' , '".$mybranch."' ,'".$mybuilding."' ,'".$myfloor."', '".$myrooms."' ,'".$myrackname."' , '".$description."', 'Active')";
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
else if($tipe == "addsubrack")
{
    $code = $_POST['mycode'];
    $rack = $_POST['myrack'];
    $splitter = explode("-", $code);
    $sql = "INSERT into subrack values(NULL,'".$rack."', '".$code."' , '".$splitter[0]."' ,'".$splitter[1]."' ,'".$splitter[2]."', 'Active')";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
}
else if($tipe == "loadsubrack")
{
    // echo "test";
    // echo "tests";
    $rack = $_POST['myrack'];
    $sql = "select * from subrack where idrack = '$rack'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<tr><td style = 'line-height:0.25;' >".$r['code']."</td><td>".$r['subrackname']."</td><td>".$r['rows']."</td><td>".$r['colum']."</td><td>".$r['status']."</td></tr>";
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
    $mycode = $_POST['mycode'];
    $mybranch = $_POST['mybranch'];
    $mybuilding = $_POST['mybuilding'];
    $myfloor = $_POST['myfloor'];
    $myrooms = $_POST['myrooms'];
    $myrackname = $_POST['myrackname'];
    $description = $_POST['mydescription'];
    $sql = "update rack set 
    idsistercompany = '".$myses."', 
    idbranch = '".$mybranch."', 
    idbuilding = '".$mybuilding."', 
    idfloor = '".$myfloor."', 
    idroom = '".$myrooms."', 
    rackname = '".$myrackname."', 
    description = '".$description."'
    where id = '".$id."'";
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
else if($tipe == "setstatus")
{
    $myid = $_POST['myidchange'];
    $stat = $_POST['stat'];
    $sql = "update rack set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
else if($tipe == "getbranch")
{
    
    $sql = 'SELECT lbranch.idbranch, lbranch.branch FROM `location_setup_sister_branch`
            inner join location_branch lbranch on lbranch.idbranch = location_setup_sister_branch.idbranch where location_setup_sister_branch.idsistercompany = '.$myses;
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['idbranch']."' >".$r['branch']."</option>";
        }
        echo $mystring."|".$mysesname;
    }
    else{
        echo "none"."|".$mysesname;
    }
}
else if($tipe == "getbuilding")
{
    $myid = $_POST['idbranch'];
    $sql = "SELECT id, buildingname FROM `location_building` inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = location_building.idsetupsisterbranch where lssb.idbranch = '".$myid."' and lssb.idsistercompany = ".$myses;
    $res = $conn->query($sql);
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
    $mybranchid = $_POST['idbranch'];
    $myid = $_POST['idbuilding'];
    $sql = "SELECT lfloor.floor, lfloor.id FROM location_setup_building_floor lsbf inner join location_floor lfloor on lfloor.id = lsbf.idfloor where lsbf.idbuilding = '$myid'";
    $res = $conn->query($sql);
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
else if($tipe == "getroom"){
    $mybranchid = $_POST['idbranch'];
    $myidbuilding = $_POST['idbuilding'];
    $myfloor = $_POST['idfloor'];
    $sql = "SELECT lroom.id, lroom.room FROM location_room lroom
    inner join location_setup_building_floor lsbf on lsbf.idlocationsetupbuildingfloor = lroom.idsetupbuildingfloor
    where lsbf.idbuilding  = '$myidbuilding' and lsbf.idfloor = '$myfloor'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['room']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
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