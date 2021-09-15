<?php
require '../connection.php';
session_start();
$myses = $_SESSION['idsister'];
$mysesname = $_SESSION['namasister'];
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'notransaction',
        'divisi',
        'department',
        'name',
        'tanggalpindah',
        'branchto',
        'roomto',
        'racknameto',
        'codeto'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    "SELECT dpnto.*, divisi.divisi, department.department, document.name,
    rackfrom.rackname as racknamefrom,
    subrackfrom.code as codefrom,
    lroomfrom.room as roomfrom, 
    lbranchfrom.branch as branchfrom, 
    
    lbranchto.branch as branchto, 
    lroomto.room as roomto, 
    rackto.rackname as racknameto, 
    subrackto.code as codeto 
    
    FROM document_displacement_to_other_rack dpnto
        inner join divisi on divisi.id = dpnto.iddivisi
        inner join department on department.id = dpnto.iddepartment
        inner join document on document.id = dpnto.iddocument
        inner join location_branch lbranchto on lbranchto.idbranch = dpnto.id_branch_to 
        inner join location_room lroomto on lroomto.id = dpnto.id_room_to
        inner join rack rackto on rackto.id = dpnto.id_rack_to
        inner join subrack subrackto on subrackto.id = dpnto.id_subrack_to
        inner join location_branch lbranchfrom on lbranchfrom.idbranch = dpnto.id_branch_from 
        inner join location_room lroomfrom on lroomfrom.id = dpnto.id_room_from
        inner join rack rackfrom on rackfrom.id = dpnto.id_rack_from
        inner join subrack subrackfrom on subrackfrom.id = dpnto.id_subrack_from
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT dpnto.*, divisi.divisi, department.department, document.name,
        rackfrom.rackname as racknamefrom,
        subrackfrom.code as codefrom,
        lroomfrom.room as roomfrom, 
        lbranchfrom.branch as branchfrom, 
        
        lbranchto.branch as branchto, 
        lroomto.room as roomto, 
        rackto.rackname as racknameto, 
        subrackto.code as codeto 
        
        FROM document_displacement_to_other_rack dpnto
            inner join divisi on divisi.id = dpnto.iddivisi
            inner join department on department.id = dpnto.iddepartment
            inner join document on document.id = dpnto.iddocument
            inner join location_branch lbranchto on lbranchto.idbranch = dpnto.id_branch_to 
            inner join location_room lroomto on lroomto.id = dpnto.id_room_to
            inner join rack rackto on rackto.id = dpnto.id_rack_to
            inner join subrack subrackto on subrackto.id = dpnto.id_subrack_to
            inner join location_branch lbranchfrom on lbranchfrom.idbranch = dpnto.id_branch_from 
            inner join location_room lroomfrom on lroomfrom.id = dpnto.id_room_from
            inner join rack rackfrom on rackfrom.id = dpnto.id_rack_from
            inner join subrack subrackfrom on subrackfrom.id = dpnto.id_subrack_from ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT dpnto.*, divisi.divisi, department.department, document.name,
        rackfrom.rackname as racknamefrom,
        subrackfrom.code as codefrom,
        lroomfrom.room as roomfrom, 
        lbranchfrom.branch as branchfrom, 
        
        lbranchto.branch as branchto, 
        lroomto.room as roomto, 
        rackto.rackname as racknameto, 
        subrackto.code as codeto 
        
        FROM document_displacement_to_other_rack dpnto
            inner join divisi on divisi.id = dpnto.iddivisi
            inner join department on department.id = dpnto.iddepartment
            inner join document on document.id = dpnto.iddocument
            inner join location_branch lbranchto on lbranchto.idbranch = dpnto.id_branch_to 
            inner join location_room lroomto on lroomto.id = dpnto.id_room_to
            inner join rack rackto on rackto.id = dpnto.id_rack_to
            inner join subrack subrackto on subrackto.id = dpnto.id_subrack_to
            inner join location_branch lbranchfrom on lbranchfrom.idbranch = dpnto.id_branch_from 
            inner join location_room lroomfrom on lroomfrom.id = dpnto.id_room_from
            inner join rack rackfrom on rackfrom.id = dpnto.id_rack_from
            inner join subrack subrackfrom on subrackfrom.id = dpnto.id_subrack_from");

    } else {
        $query_data = mysqli_query($conn, "SELECT dpnto.*, divisi.divisi, department.department, document.name,
        rackfrom.rackname as racknamefrom,
        subrackfrom.code as codefrom,
        lroomfrom.room as roomfrom, 
        lbranchfrom.branch as branchfrom, 
        
        lbranchto.branch as branchto, 
        lroomto.room as roomto, 
        rackto.rackname as racknameto, 
        subrackto.code as codeto 
        
        FROM document_displacement_to_other_rack dpnto
            inner join divisi on divisi.id = dpnto.iddivisi
            inner join department on department.id = dpnto.iddepartment
            inner join document on document.id = dpnto.iddocument
            inner join location_branch lbranchto on lbranchto.idbranch = dpnto.id_branch_to 
            inner join location_room lroomto on lroomto.id = dpnto.id_room_to
            inner join rack rackto on rackto.id = dpnto.id_rack_to
            inner join subrack subrackto on subrackto.id = dpnto.id_subrack_to
            inner join location_branch lbranchfrom on lbranchfrom.idbranch = dpnto.id_branch_from 
            inner join location_room lroomfrom on lroomfrom.id = dpnto.id_room_from
            inner join rack rackfrom on rackfrom.id = dpnto.id_rack_from
            inner join subrack subrackfrom on subrackfrom.id = dpnto.id_subrack_from 
        WHERE dpnto.notransaction LIKE '%$search%' 
        OR dpnto.tanggalpindah LIKE '%$search%'
        OR document.name LIKE '%$search%' 
        OR divisi.divisi LIKE '%$search%'
        OR department.department LIKE '%$search%'
        OR lbranchfrom.branchfrom LIKE '%$search%'
        OR lroomfrom.roomfrom LIKE '%$search%'
        OR rackfrom.racknamefrom LIKE '%$search%'
        OR subrackfrom.codefrom LIKE '%$search%'
        OR lbranchto.branchto LIKE '%$search%'
        OR lroomto.roomto LIKE '%$search%'
        OR rackto.racknameto LIKE '%$search%'
        OR subrackto.codeto LIKE '%$search% 
        ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT dpnto.*, divisi.divisi, department.department, document.name,
        rackfrom.rackname as racknamefrom,
        subrackfrom.code as codefrom,
        lroomfrom.room as roomfrom, 
        lbranchfrom.branch as branchfrom, 
        
        lbranchto.branch as branchto, 
        lroomto.room as roomto, 
        rackto.rackname as racknameto, 
        subrackto.code as codeto 
        
        FROM document_displacement_to_other_rack dpnto
            inner join divisi on divisi.id = dpnto.iddivisi
            inner join department on department.id = dpnto.iddepartment
            inner join document on document.id = dpnto.iddocument
            inner join location_branch lbranchto on lbranchto.idbranch = dpnto.id_branch_to 
            inner join location_room lroomto on lroomto.id = dpnto.id_room_to
            inner join rack rackto on rackto.id = dpnto.id_rack_to
            inner join subrack subrackto on subrackto.id = dpnto.id_subrack_to
            inner join location_branch lbranchfrom on lbranchfrom.idbranch = dpnto.id_branch_from 
            inner join location_room lroomfrom on lroomfrom.id = dpnto.id_room_from
            inner join rack rackfrom on rackfrom.id = dpnto.id_rack_from
            inner join subrack subrackfrom on subrackfrom.id = dpnto.id_subrack_from 
        WHERE dpnto.notransaction LIKE '%$search%' 
        OR dpnto.tanggalpindah LIKE '%$search%'
        OR document.name LIKE '%$search%' 
        OR divisi.divisi LIKE '%$search%'
        OR department.department LIKE '%$search%'
        OR lbranchfrom.branchfrom LIKE '%$search%'
        OR lroomfrom.roomfrom LIKE '%$search%'
        OR rackfrom.racknamefrom LIKE '%$search%'
        OR subrackfrom.codefrom LIKE '%$search%'
        OR lbranchto.branchto LIKE '%$search%'
        OR lroomto.roomto LIKE '%$search%'
        OR rackto.racknameto LIKE '%$search%'
        OR subrackto.codeto LIKE '%$search%");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            // if($row['status'] == "Active")
            // {
            //     $myactionsetto = "InActive";
            //     $mystats = '<span class="badge badge-success">Active</span>';
            //     $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['id']."-".$myactionsetto."')><i class='icon-check'></i>
            //     Set InActive</a>'";
            // }
            // else
            // {
            //     $myactionsetto = "Active";
            //     $mystats = '<span class="badge badge-danger">InActive</span>';
            //     $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['id']."-".$myactionsetto."')><i class='icon-check'></i>
            //     Set Active</a>'";
            // }
            // ['notransaction'].$row['branch'].$row['room'].$row['rackname'].$row['code']
            // $datashowdetail = "openmodaldisplacement('1-".$row['notransaction']."~".$row['room']."~".$row['branch']."~".$row['rackname']."~".$row['code']."')";
            // $datashowdetail = strval($row['room']) ;
            $response['data'][] = [
                "<a href='#myModalshowdetail' data-toggle='modal'><span class='pointer-element badge badge-success' style = 'background-color:#26a69a !important;' id ='".$row['id']."'  data-id='".$row['id']."' onclick = 'openmodaldisplacement(this)'> <i class='icon-eye'></i></span></a>",
                "<label id ='notransaction".$row['id']."'>".$row['notransaction']."</label>",
                "<label id ='divisi".$row['id']."'>".$row['divisi']."</label>",
                "<label id ='department".$row['id']."'>".$row['department']."</label>",
                "<label id ='documentname".$row['id']."'>".$row['name']."</label>",
                "<label id ='tanggalpindah".$row['id']."'>".$row['tanggalpindah']."</label> 
                <input type = 'hidden' id = 'transaction".$row['id']."' value = '".$row['notransaction']."'>
                <input type = 'hidden' id = 'branchfrom".$row['id']."' value = '".$row['branchfrom']."'>
                <input type = 'hidden' id = 'roomfrom".$row['id']."' value = '".$row['roomfrom']."'>
                <input type = 'hidden' id = 'rackfrom".$row['id']."' value = '".$row['racknamefrom']."'>
                <input type = 'hidden' id = 'codefrom".$row['id']."' value = '".$row['codefrom']."'>
                <input type = 'hidden' id = 'branchto".$row['id']."' value = '".$row['branchto']."'>
                <input type = 'hidden' id = 'roomto".$row['id']."' value = '".$row['roomto']."'>
                <input type = 'hidden' id = 'rackto".$row['id']."' value = '".$row['racknameto']."'>
                <input type = 'hidden' id = 'codeto".$row['id']."' value = '".$row['codeto']."'>",
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