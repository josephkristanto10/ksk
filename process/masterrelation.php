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
        'company',
        'description',
        'address',
        'countryname',
        'provincename',
        'cityname',
        'department',
        'rank',
        'contactname',
        'remark',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    "SELECT r.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  FROM relation r
    inner join country on country.id = r.idcountry
    inner join province on province.id = r.idprovince
    inner join city on city.id = r.idcity
    inner join rank on rank.id = r.idrank
    inner join department on department.id = r.iddepartment
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT r.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  FROM relation r
        inner join country on country.id = r.idcountry
        inner join province on province.id = r.idprovince
        inner join city on city.id = r.idcity
        inner join rank on rank.id = r.idrank
        inner join department on department.id = r.iddepartment ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT r.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  FROM relation r
        inner join country on country.id = r.idcountry
        inner join province on province.id = r.idprovince
        inner join city on city.id = r.idcity
        inner join rank on rank.id = r.idrank
        inner join department on department.id = r.iddepartment");

    } else {
        $query_data = mysqli_query($conn, "SELECT r.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  FROM relation r
        inner join country on country.id = r.idcountry
        inner join province on province.id = r.idprovince
        inner join city on city.id = r.idcity
        inner join rank on rank.id = r.idrank
        inner join department on department.id = r.iddepartment 
        WHERE r.code LIKE '%$search%' 
        OR r.contactname LIKE '%$search%'
        OR r.description LIKE '%$search%'
        OR r.hp1 LIKE '%$search%'
        OR r.hp2 LIKE '%$search%'
        OR r.email1 LIKE '%$search%'
        OR r.email2 LIKE '%$search%'
        OR r.status LIKE '%$search%'
        OR r.address LIKE '%$search%'
        OR r.company LIKE '%$search%'
        OR r.remark LIKE '%$search%'
        OR department.department LIKE '%$search%'
        OR rank.rank LIKE '%$search%'
        OR country.name LIKE '%$search%'
        OR province.name LIKE '%$search%'
        OR city.name LIKE '%$search%' 
        ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT r.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  FROM relation r
        inner join country on country.id = r.idcountry
        inner join province on province.id = r.idprovince
        inner join city on city.id = r.idcity
        inner join rank on rank.id = r.idrank
        inner join department on department.id = r.iddepartment 
        WHERE r.code LIKE '%$search%' 
        OR r.contactname LIKE '%$search%'
        OR r.description LIKE '%$search%'
        OR r.hp1 LIKE '%$search%'
        OR r.hp2 LIKE '%$search%'
        OR r.email1 LIKE '%$search%'
        OR r.email2 LIKE '%$search%'
        OR r.status LIKE '%$search%'
        OR r.address LIKE '%$search%'
        OR r.company LIKE '%$search%'
        OR r.remark LIKE '%$search%'
        OR department.department LIKE '%$search%'
        OR rank.rank LIKE '%$search%'
        OR country.name LIKE '%$search%'
        OR province.name LIKE '%$search%'
        OR city.name LIKE '%$search%'");
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
                "<label id ='company".$row['id']."'>".$row['company']."</label>",
                "<label id ='contactname".$row['id']."'>".$row['contactname']."</label>",
                "<label id ='description".$row['id']."'>".$row['description']."</label>",
                "<label id ='rank".$row['id']."'>".$row['rank']."</label>",
                "<label id ='department".$row['id']."'>".$row['department']."</label>",
                "<label id ='hp1".$row['id']."'>".$row['hp1']."</label>",
                "<label id ='hp2".$row['id']."'>".$row['hp2']."</label>",
                "<label id ='email1".$row['id']."'>".$row['email1']."</label>",
                "<label id ='email2".$row['id']."'>".$row['email2']."</label>",
                "<label id ='address".$row['id']."'>".$row['address']."</label>",
                "<label id ='country".$row['id']."'>".$row['countryname']."</label>",
                "<label id ='province".$row['id']."'>".$row['provincename']."</label>",
                "<label id ='city".$row['id']."'>".$row['cityname']."</label>",
                "<label id ='remark".$row['id']."'>".$row['remark']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                  
                    <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id'].'-'.$row['idcountry'].'-'.$row['idprovince'].'-'.$row['idcity'].'-'.$row['idrank'].'-'.$row['iddepartment'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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

    // $id = $_POST['id'];  
    $code = $_POST['code'];  
    $contactname = $_POST['contactname'];  
    $description = $_POST['description'];  
    $idrank = $_POST['rank'];  
    $iddepartment = $_POST['department'];  
    $hp1 = $_POST['hp1'];  
    $hp2 = $_POST['hp2'];  
    $email1 = $_POST['email1'];  
    $email2 = $_POST['email2'];  
    $address = $_POST['address'];  
    $idcountry = $_POST['country'];  
    $idprovince = $_POST['province'];  
    $idcity = $_POST['city'];  
    $company = $_POST['company'];  
    $remark = $_POST['remark'];  
    
    $sql = "INSERT INTO `relation` values(NULL, 
    '".$code."'
    , '".$contactname."'
    , '".$description."'
    , '".$idrank."'
    , '".$iddepartment."'
    , '".$hp1."'
    , '".$hp2."'
    , '".$email1."'
    , '".$email2."'
    , '".$address."'
    , '".$idcountry."'
    , '".$idprovince."'
    , '".$idcity."'
    , '".$company."'
    , '".$remark."', 'Active')";
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
    $code = $_POST['code'];  
    $contactname = $_POST['contactname'];  
    $description = $_POST['description'];  
    $idrank = $_POST['rank'];  
    $iddepartment = $_POST['department'];  
    $hp1 = $_POST['hp1'];  
    $hp2 = $_POST['hp2'];  
    $email1 = $_POST['email1'];  
    $email2 = $_POST['email2'];  
    $address = $_POST['address'];  
    $idcountry = $_POST['country'];  
    $idprovince = $_POST['province'];  
    $idcity = $_POST['city'];  
    $company = $_POST['company'];  
    $remark = $_POST['remark'];  
    $query = " UPDATE relation SET contactname = '$contactname',  description = '$description',  idrank = '$idrank',  iddepartment = '$iddepartment',  hp1 = '$hp1',  hp2 = '$hp2',  email1 = '$email1',  email2 = '$email2',  address = '$address',  idcountry = '$idcountry',  idprovince = '$idprovince',  idcity = '$idcity',  company = '$company',  remark = '$remark' WHERE id  = '$id' ";
    $res = $conn->query($query);
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
    $sql = "update relation set status = '".$stat."' where id = '".$myid."'";
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
    $sql = "SELECT location_floor.id, location_floor.floor FROM `location_setup_building_floor` inner join location_setup_sister_branch on location_setup_sister_branch.idsetupsisterbranch = location_setup_building_floor.idsetupsisterbranch inner join location_floor on location_floor.id = location_setup_building_floor.idfloor where location_setup_building_floor.idbuilding = '".$myid."' and location_setup_sister_branch.idbranch = '".$mybranchid."' and location_setup_sister_branch.idsistercompany = ".$myses;
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
    $sql = "SELECT location_room.id , location_room.room FROM location_room inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = location_room.idsetupsisterbranch inner join location_building lbuilding on lbuilding.id = location_room.idbuilding inner join location_floor lfloor on lfloor.id = location_room.idfloor inner join location_sister_company lsc on lsc.id = lssb.idsistercompany inner join location_branch on location_branch.idbranch = lssb.idbranch where location_room.idfloor = '".$myfloor."' and location_room.idbuilding = '".$myidbuilding."' and lssb.idsistercompany = '".$myses."' and lssb.idbranch = '".$mybranchid."'";
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