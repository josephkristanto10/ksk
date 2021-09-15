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
    "SELECT lsbf.status, lsbf.idlocationsetupbuildingfloor as idsetupfloor,lsc.name as sistername, lbranch.branch as branchname, lsbf.code, lbuilding.id as idbuilding, lbuilding.buildingname, lbuilding.idsetupsisterbranch, 
    lbuilding.buildingname,lfloor.id as idfloor,  lfloor.floor FROM location_setup_building_floor lsbf 
    inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
    inner join location_floor lfloor on lfloor.id = lsbf.idfloor
    inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch
    inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
    inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
    where lsc.id = '".$sessionidsister."'
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT lsbf.status, lsbf.idlocationsetupbuildingfloor as idsetupfloor,lsc.name as sistername, lbranch.branch as branchname, lsbf.code, lbuilding.id as idbuilding, lbuilding.buildingname, lbuilding.idsetupsisterbranch, 
        lbuilding.buildingname,lfloor.id as idfloor,  lfloor.floor FROM location_setup_building_floor lsbf 
        inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
        inner join location_floor lfloor on lfloor.id = lsbf.idfloor
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
        where lsc.id = '".$sessionidsister."'  ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT lsbf.status, lsbf.idlocationsetupbuildingfloor as idsetupfloor,lsc.name as sistername, lbranch.branch as branchname, lsbf.code, lbuilding.id as idbuilding, lbuilding.buildingname, lbuilding.idsetupsisterbranch, 
        lbuilding.buildingname,lfloor.id as idfloor,  lfloor.floor FROM location_setup_building_floor lsbf 
        inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
        inner join location_floor lfloor on lfloor.id = lsbf.idfloor
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
        where lsc.id = '".$sessionidsister."'");

    } else {
        $query_data = mysqli_query($conn, "SELECT lsbf.status, lsbf.idlocationsetupbuildingfloor as idsetupfloor,lsc.name as sistername, lbranch.branch as branchname, lsbf.code, lbuilding.id as idbuilding, lbuilding.buildingname, lbuilding.idsetupsisterbranch, 
        lbuilding.buildingname,lfloor.id as idfloor,  lfloor.floor FROM location_setup_building_floor lsbf 
        inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
        inner join location_floor lfloor on lfloor.id = lsbf.idfloor
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
        where lsc.id = '".$sessionidsister."' and (
        lbuilding.buildingname LIKE '%$search%'
        OR lsc.name LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR lsbf.code LIKE '%$search%'
        OR lfloor.floor LIKE '%$search%'
        OR lsbf.status LIKE '%$search%' ) 
        ORDER BY $order $dir LIMIT $start, $length ");
    
        $total_filtered = mysqli_query($conn, "SELECT lsbf.status, lsbf.idlocationsetupbuildingfloor as idsetupfloor,lsc.name as sistername, lbranch.branch as branchname, lsbf.code, lbuilding.id as idbuilding, lbuilding.buildingname, lbuilding.idsetupsisterbranch, 
        lbuilding.buildingname,lfloor.id as idfloor,  lfloor.floor FROM location_setup_building_floor lsbf 
        inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding 
        inner join location_floor lfloor on lfloor.id = lsbf.idfloor
        inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch
        inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
        inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
        where lsc.id = '".$sessionidsister."' and (
        lbuilding.buildingname LIKE '%$search%'
        OR lsc.name LIKE '%$search%'
        OR lfloor.floor LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR lsbf.code LIKE '%$search%'
        OR lsbf.status LIKE '%$search%' )");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['status'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idsetupfloor']."-".$myactionsetto."')><i class='icon-check'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idsetupfloor']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label id ='code".$row['idsetupfloor']."'>".$row['code']."</label>",
                "<label id ='code".$row['idsetupfloor']."'>".ucfirst($row['branchname'])."</label>",
                "<label id ='name".$row['idsetupfloor']."'>".$row['buildingname']."</label>",
                "<label id ='floor".$row['idsetupfloor']."'>".$row['floor']."</label>",
                "<label id ='status".$row['idsetupfloor']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['idsetupfloor'].'-'.$row['idbuilding'].'-'.$row['idfloor'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
    // $location = $_POST['location'];
    $building = $_POST['building'];
    $floor = $_POST['floor'];
    $sql = "INSERT into location_setup_building_floor values(NULL,'".$building."', '".$floor."', '".$code."', 'Active')";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        echo "ok";
    }
    else{
        echo "tidak";
    }
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

else if($tipe == "changedata")
{
    $id  = $_POST['myid'];
    $code = $_POST['mycode'];
    $building = $_POST['mybuilding'];
    $floor = $_POST['myfloor'];
    $sql = "update location_setup_building_floor set 
           code = '".$code."', 
           idbuilding = '".$building."',
           idfloor = '".$floor."' 
            where idlocationsetupbuildingfloor = '".$id."'";
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
    $sql = "update location_setup_building_floor set status = '".$stat."' where idlocationsetupbuildingfloor = '".$myid."'";
    $res = $conn->query($sql);
}

?>