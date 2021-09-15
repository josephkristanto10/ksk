<?php
require '../connection.php';
session_start();
$myses = $_SESSION['idsister'];
$mysesname = $_SESSION['namasister'];
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'company',
        'description',
        'address',
        'countryname',
        'provincename',
        'cityname',
        'officetelp',
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
    "select s.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  from supplier s 
    inner join country on country.id = s.idcountry
    inner join province on province.id = s.idprovince
    inner join city on city.id = s.idcity
    inner join rank on rank.id = s.idrank
    inner join department on department.id = s.iddepartment
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select s.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  from supplier s 
        inner join country on country.id = s.idcountry
        inner join province on province.id = s.idprovince
        inner join city on city.id = s.idcity
        inner join rank on rank.id = s.idrank
        inner join department on department.id = s.iddepartment ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select s.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  from supplier s 
        inner join country on country.id = s.idcountry
        inner join province on province.id = s.idprovince
        inner join city on city.id = s.idcity
        inner join rank on rank.id = s.idrank
        inner join department on department.id = s.iddepartment");

    } else {
        $query_data = mysqli_query($conn, "select s.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  from supplier s 
        inner join country on country.id = s.idcountry
        inner join province on province.id = s.idprovince
        inner join city on city.id = s.idcity
        inner join rank on rank.id = s.idrank
        inner join department on department.id = s.iddepartment 
        WHERE s.company LIKE '%$search%' 
        OR s.description LIKE '%$search%'
        OR s.address LIKE '%$search%'
        OR country.name LIKE '%$search%'
        OR province.name LIKE '%$search%'
        OR city.name LIKE '%$search%'
        OR s.officetelp LIKE '%$search%'
        OR s.contactname LIKE '%$search%'
        OR s.remark LIKE '%$search%'
        OR s.status LIKE '%$search%'
        OR department.department LIKE '%$search%'
        OR rank.rank LIKE '%$search%'
        ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select s.*, department.department, rank.rank, country.name as countryname, province.name as provincename, city.name as cityname  from supplier s 
        inner join country on country.id = s.idcountry
        inner join province on province.id = s.idprovince
        inner join city on city.id = s.idcity
        inner join rank on rank.id = s.idrank
        inner join department on department.id = s.iddepartment 
        WHERE s.company LIKE '%$search%' 
        OR s.description LIKE '%$search%'
        OR s.address LIKE '%$search%'
        OR country.name LIKE '%$search%'
        OR province.name LIKE '%$search%'
        OR city.name LIKE '%$search%'
        OR s.officetelp LIKE '%$search%'
        OR s.contactname LIKE '%$search%'
        OR s.remark LIKE '%$search%'
        OR department.department LIKE '%$search%'
        OR rank.rank LIKE '%$search%'
        OR s.status LIKE '%$search%'");
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
                "<label id ='Company".$row['id']."'>".$row['company']."</label>",
                "<label id ='Description".$row['id']."'>".$row['description']."</label>",
                "<label id ='Address".$row['id']."'>".$row['address']."</label>",
                "<label id ='Country".$row['id']."'>".$row['countryname']."</label>",
                "<label id ='Province".$row['id']."'>".$row['provincename']."</label>",
                "<label id ='City".$row['id']."'>".$row['cityname']."</label>",
                "<label id ='Phone".$row['id']."'>".$row['officetelp']."</label>",
                "<label id ='Contactname".$row['id']."'>".$row['contactname']."</label>",
                "<label id ='Remark".$row['id']."'>".$row['remark']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                    <a href="#myModalshow" data-toggle="modal" class="dropdown-item" id ="show|'.$row['hp1'].'|'.$row['hp2'].'|'.$row['email1'].'|'.$row['email2'].'|'.$row['company'].'|'.$row['rank'].'|'.$row['department'].'|'.$row['contactname'].'"  onclick = "opendetail(this)"><i class="icon-check"></i>
                            Show Detail</a>   
                    <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id'].'-'.$row['idcountry'].'-'.$row['idprovince'].'-'.$row['idcity'].'-'.$row['idrank'].'-'.$row['iddepartment'].'-'.$row['hp1'].'-'.$row['hp2'].'-'.$row['email1'].'-'.$row['email2'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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

    $mycompany  = $_POST['mycompany'];
    $mydescription = $_POST['mydescription'];
    $myaddress = $_POST['myaddress'];
    $mycountry = $_POST['mycountry'];
    $myprovince = $_POST['myprovince'];
    $mycity = $_POST['mycity'];
    $myrank = $_POST['myrank'];
    $mydepartment = $_POST['mydepartment'];
    $myphone = $_POST['myphone'];
    $mycontactname = $_POST['mycontactname'];
    $myhp1 = $_POST['myhp1'];
    $myhp2 = $_POST['myhp2'];
    $myemail1 = $_POST['myemail1'];
    $myemail2 = $_POST['myemail2'];
    $myremark = $_POST['myremark'];

    
    $sql = "INSERT into supplier values(NULL,'".$mycompany."', '".$mydescription."' , '".$myaddress."' ,'".$mycountry."' ,'".
    $myprovince."', '".$mycity."' ,'".$myrank."' , '".$mydepartment."' , '".$myphone."' , '".$mycontactname."' , '".$myhp1."' , '".
    $myhp2."' , '".$myemail1."' , '".$myemail2."' , '".$myremark."', 'Active')";
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
    $mydescription = $_POST['mydescription'];
    $myaddress = $_POST['myaddress'];
    $mycountry = $_POST['mycountry'];
    $myprovince = $_POST['myprovince'];
    $mycity = $_POST['mycity'];
    $myrank = $_POST['myrank'];
    $mydepartment = $_POST['mydepartment'];
    $myphone = $_POST['myphone'];
    $mycontactname = $_POST['mycontactname'];
    $myhp1 = $_POST['myhp1'];
    $myhp2 = $_POST['myhp2'];
    $myemail1 = $_POST['myemail1'];
    $myemail2 = $_POST['myemail2'];
    $myremark = $_POST['myremark'];
    $sql = "update supplier set 
    description = '".$mydescription."', 
    address = '".$myaddress."', 
    idcountry = '".$mycountry."', 
    idprovince = '".$myprovince."', 
    idcity = '".$mycity."', 
    idrank = '".$myrank."', 
    iddepartment = '".$mydepartment."', 
    officetelp = '".$myphone."', 
    contactname = '".$mycontactname."', 
    hp1 = '".$myhp1."', 
    hp2 = '".$myhp2."', 
    email1 = '".$myemail1."', 
    email2 = '".$myemail2."', 
    remark = '".$myremark."' 
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
    $sql = "update supplier set status = '".$stat."' where id = '".$myid."'";
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