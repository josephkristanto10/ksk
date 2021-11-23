<?php
session_start();
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'id',
        'building_code',
        'buildingname',
        'branchname',
        'building_description',
        'building_status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    $sessionidsister = $_SESSION['idsister'];

    $total_data = mysqli_query($conn, 
    "SELECT location_setup_building_floor.*, location_floor.floor, location_building.buildingname, location_sister_company.name as sistername, location_branch.branch as branchname, location_building.idsetupsisterbranch, location_building.id,  location_building.code as building_code, location_building.status as building_status, location_building.description as building_description FROM `location_setup_building_floor` inner join location_building on location_building.id = location_setup_building_floor.idbuilding inner join location_floor on location_floor.id = location_setup_building_floor.idfloor inner join location_setup_sister_branch on location_setup_sister_branch.idsetupsisterbranch = location_building.idsetupsisterbranch inner join location_branch on location_branch.idbranch = location_setup_sister_branch.idbranch inner join location_sister_company on location_sister_company.id = location_setup_sister_branch.idsistercompany where location_sister_company.id =' ".$sessionidsister."' order by idlocationsetupbuildingfloor asc
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT location_setup_building_floor.*, location_floor.floor, location_building.buildingname, location_sister_company.name as sistername, location_branch.branch as branchname, location_building.idsetupsisterbranch, location_building.id,  location_building.code as building_code, location_building.status as building_status, location_building.description as building_description FROM `location_setup_building_floor` inner join location_building on location_building.id = location_setup_building_floor.idbuilding inner join location_floor on location_floor.id = location_setup_building_floor.idfloor inner join location_setup_sister_branch on location_setup_sister_branch.idsetupsisterbranch = location_building.idsetupsisterbranch inner join location_branch on location_branch.idbranch = location_setup_sister_branch.idbranch inner join location_sister_company on location_sister_company.id = location_setup_sister_branch.idsistercompany where location_sister_company.id =' ".$sessionidsister."' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT location_setup_building_floor.*, location_floor.floor, location_building.buildingname, location_sister_company.name as sistername, location_branch.branch as branchname, location_building.idsetupsisterbranch, location_building.id,  location_building.code as building_code, location_building.status as building_status, location_building.description as building_description FROM `location_setup_building_floor` inner join location_building on location_building.id = location_setup_building_floor.idbuilding inner join location_floor on location_floor.id = location_setup_building_floor.idfloor inner join location_setup_sister_branch on location_setup_sister_branch.idsetupsisterbranch = location_building.idsetupsisterbranch inner join location_branch on location_branch.idbranch = location_setup_sister_branch.idbranch inner join location_sister_company on location_sister_company.id = location_setup_sister_branch.idsistercompany where location_sister_company.id =' ".$sessionidsister."' ");

    } else {
        $query_data = mysqli_query($conn, "SELECT location_setup_building_floor.*, location_floor.floor, location_building.buildingname, location_sister_company.name as sistername, location_branch.branch as branchname, location_building.idsetupsisterbranch, location_building.id, location_building.code as building_code, location_building.status as building_status, location_building.description as building_description FROM `location_setup_building_floor` inner join location_building on location_building.id = location_setup_building_floor.idbuilding inner join location_floor on location_floor.id = location_setup_building_floor.idfloor inner join location_setup_sister_branch on location_setup_sister_branch.idsetupsisterbranch = location_building.idsetupsisterbranch inner join location_branch on location_branch.idbranch = location_setup_sister_branch.idbranch inner join location_sister_company on location_sister_company.id = location_setup_sister_branch.idsistercompany where location_sister_company.id =' ".$sessionidsister."'  and (
            location_building.code LIKE '%$search%' 
        OR location_building.buildingname LIKE '%$search%'
        OR location_sister_company.name LIKE '%$search%'
        OR location_branch.branch LIKE '%$search%'
        OR location_building.status LIKE '%$search%' )
         ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT location_setup_building_floor.*, location_floor.floor, location_building.buildingname, location_sister_company.name as sistername, location_branch.branch as branchname, location_building.idsetupsisterbranch, location_building.id, location_building.code as building_code, location_building.status as building_status, location_building.description as building_description FROM `location_setup_building_floor` inner join location_building on location_building.id = location_setup_building_floor.idbuilding inner join location_floor on location_floor.id = location_setup_building_floor.idfloor inner join location_setup_sister_branch on location_setup_sister_branch.idsetupsisterbranch = location_building.idsetupsisterbranch inner join location_branch on location_branch.idbranch = location_setup_sister_branch.idbranch inner join location_sister_company on location_sister_company.id = location_setup_sister_branch.idsistercompany where location_sister_company.id =' ".$sessionidsister."'  and ( 
            location_building.code LIKE '%$search%' 
            OR  location_building.buildingname LIKE '%$search%'
            OR location_sister_company.name LIKE '%$search%'
            OR location_branch.branch LIKE '%$search%'
            OR location_building.status LIKE '%$search%' )");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['building_status'] == "Active")
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
                "<label id ='id".$row['id']."'>".$row['id']."</label>",
                "<label id ='code".$row['id']."'>".$row['building_code']."</label>",
              
                "<label id ='name".$row['id']."'>".$row['buildingname']."</label>",
                "<label id ='branch".$row['id']."'>".$row['branchname']."</label>",
                "<label id ='description".$row['id']."'>".$row['building_description']."</label>",
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
    $desc = $_POST['desc'];
    $location = $_POST['branch'];
    $selectedfloor = $_POST['selectedfloor'];

    $sql = "INSERT into location_building values(NULL,'-', '".$code."', '".$name."', '".$location."', '".$desc."', 'Active')";
    $res = $conn->query($sql);
    $last_id = $conn->insert_id;
    for($i = 0 ; $i < count($selectedfloor) ; $i++)
    {
        $sqls = "INSERT into location_setup_building_floor values(NULL,'".$last_id."', '".$selectedfloor[$i]."', '".$code."', 'Active')";
        $ress = $conn->query($sqls);
    }
    echo $conn->error;
    if(($conn -> affected_rows)>0)
    {
 
        echo "sukses";

    }
    else{
        echo "tidak";
    }
    // echo $sql;
}
else if($tipe == "loadfloor"){
    $where_like = [
        
        '',
        'code',
        'floor'
        
    ];
    
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "select * from location_floor where status = 'Active'
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select * from location_floor where status = 'Active' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select * from location_floor where status = 'Active' ");
    } else {
        $query_data = mysqli_query($conn, "select * from location_floor where status = 'Active'  
        and  floor LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select * from location_floor where status = 'Active'  
        and  floor LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mcheck =  "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxfloor'>";
            // for($i = 0; $i < count($assetexisting); $i++)
            // {
            //     if($assetexisting[$i] == $row['id'])
            //     {
            //        $mcheck =  "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxassetedit' checked>";
            //     }
            
            // }
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
             
                   $mcheck ,
                "<label id ='code_".$row['id']."'>".$row['code']."</label>",
                "<label id ='floor_".$row['id']."'>".$row['floor']."</label>"
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
else if($tipe == "loadflooredit"){

    
    $notransact = $_POST['notransaction'];

    $where_like = [
        
        '',
        'code',
        'floor'
        
    ];
    
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "select * from location_room where status = 'Active'
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select * from location_floor where status = 'Active' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select * from location_floor where status = 'Active' ");
    } else {
        $query_data = mysqli_query($conn, "select * from location_floor where status = 'Active'  
        and  floor LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select * from location_floor where status = 'Active'  
        and  floor LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mcheck =  "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxfloor'>";
            // for($i = 0; $i < count($assetexisting); $i++)
            // {
            //     if($assetexisting[$i] == $row['id'])
            //     {
            //        $mcheck =  "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxassetedit' checked>";
            //     }
            
            // }
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
             
                   $mcheck ,
                "<label id ='code_".$row['id']."'>".$row['code']."</label>",
                "<label id ='floor_".$row['id']."'>".$row['floor']."</label>"
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