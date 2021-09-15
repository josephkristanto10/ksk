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
        'buildingname',
        'floor',
        'room',
        'nama',
        'name',
        'start_date',
        'end_date',
        'nik'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    "SELECT dl.*, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, karyawan.nama, document.name FROM document_lend dl
    inner join location_sister_company lsc on lsc.id = dl.idsistercompany
    inner join location_branch lbranch on lbranch.idbranch = dl.idbranch
    inner join location_building lbuilding on lbuilding.id = dl.ibuilding
    inner join location_floor lfloor on lfloor.id = dl.idfloor
    inner join location_room lroom on lroom.id = dl.idrooms
    inner join karyawan on karyawan.nik = dl.nik
    inner join document on document.id = dl.iddocument
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT dl.*, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, karyawan.nama, document.name FROM document_lend dl
        inner join location_sister_company lsc on lsc.id = dl.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = dl.idbranch
        inner join location_building lbuilding on lbuilding.id = dl.ibuilding
        inner join location_floor lfloor on lfloor.id = dl.idfloor
        inner join location_room lroom on lroom.id = dl.idrooms
        inner join karyawan on karyawan.nik = dl.nik
        inner join document on document.id = dl.iddocument ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT dl.*, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, karyawan.nama, document.name FROM document_lend dl
        inner join location_sister_company lsc on lsc.id = dl.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = dl.idbranch
        inner join location_building lbuilding on lbuilding.id = dl.ibuilding
        inner join location_floor lfloor on lfloor.id = dl.idfloor
        inner join location_room lroom on lroom.id = dl.idrooms
        inner join karyawan on karyawan.nik = dl.nik
        inner join document on document.id = dl.iddocument");

    } else {
        $query_data = mysqli_query($conn, "SELECT dl.*, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, karyawan.nama, document.name FROM document_lend dl
        inner join location_sister_company lsc on lsc.id = dl.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = dl.idbranch
        inner join location_building lbuilding on lbuilding.id = dl.ibuilding
        inner join location_floor lfloor on lfloor.id = dl.idfloor
        inner join location_room lroom on lroom.id = dl.idrooms
        inner join karyawan on karyawan.nik = dl.nik
        inner join document on document.id = dl.iddocument    
        WHERE dl.notransaction LIKE '%$search%' 
        OR dl.start_date LIKE '%$search%'
        OR dl.end_date LIKE '%$search%'
        OR dl.nik LIKE '%$search%' 
        OR karyawan.nama LIKE '%$search%' 
        OR lbranch.branch LIKE '%$search%'
        OR lbuilding.buildingname LIKE '%$search%'
        OR lfloor.floor LIKE '%$search%'
        OR lroom.room LIKE '%$search%'
        OR document.name LIKE '%$search%'
        ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT dl.*, lbranch.branch, lbuilding.buildingname, lfloor.floor, lroom.room, karyawan.nama, document.name FROM document_lend dl
        inner join location_sister_company lsc on lsc.id = dl.idsistercompany
        inner join location_branch lbranch on lbranch.idbranch = dl.idbranch
        inner join location_building lbuilding on lbuilding.id = dl.ibuilding
        inner join location_floor lfloor on lfloor.id = dl.idfloor
        inner join location_room lroom on lroom.id = dl.idrooms
        inner join karyawan on karyawan.nik = dl.nik
        inner join document on document.id = dl.iddocument    
        WHERE dl.notransaction LIKE '%$search%' 
        OR dl.start_date LIKE '%$search%'
        OR dl.end_date LIKE '%$search%'
        OR dl.nik LIKE '%$search%' 
        OR karyawan.nama LIKE '%$search%' 
        OR lbranch.branch LIKE '%$search%'
        OR lbuilding.buildingname LIKE '%$search%'
        OR lfloor.floor LIKE '%$search%'
        OR lroom.room LIKE '%$search%'
        OR document.name LIKE '%$search%'");
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
            date_default_timezone_set("Asia/Jakarta");
            $datenow = date("Y-m-d");
       
            // $dateTimestamp1 = new DateTime($datenow);
            $dateTimestamp2 = $row['end_date'];
         
             if($dateTimestamp2 < $datenow)
            {
                    $comparing = "Late";
            }
            else{
                $comparing = "clear";
            }
            $response['data'][] = [
                "<span class='pointer-element badge badge-success' style = 'height:30px; font-size:12px; padding-top:10px;background-color:#26a69a !important;' id ='detail~".$row['id']."'  data-id='".$row['id']."' >  Detail</span> <br><span  class='pointer-element badge badge-success mt-1' style = 'height:30px; font-size:12px; padding-top:10px;background-color:#26a69a !important;' id ='extend~".$row['id']."'  data-id='".$row['id']."' > Activity</span>",
                "<label id ='notransaction".$row['id']."'>".$row['notransaction']."</label>",
                "<label id ='branch".$row['id']."'>".$row['branch']."</label>",
                "<label id ='nik".$row['id']."'>".$row['nik']."</label>",
                "<label id ='nama".$row['id']."'>".$row['nama']."</label>",
                "<label id ='documentname".$row['id']."'>".$row['name']."</label>",
                "<label id ='date".$row['id']."'>".$row['start_date']." ~ ". $row['end_date']."</label> 
                <input type = 'hidden' id = 'buildingname".$row['id']."' value = '".$row['buildingname']."'>
                <input type = 'hidden' id = 'startdate".$row['id']."' value = '".$row['start_date']."'>
                <input type = 'hidden' id = 'enddate".$row['id']."' value = '".$row['end_date']."'>
                <input type = 'hidden' id = 'floor".$row['id']."' value = '".$row['floor']."'>
                <input type = 'hidden' id = 'status".$row['id']."' value = '".$comparing."'>
                <input type = 'hidden' id = 'room".$row['id']."' value = '".$row['room']."'>",
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
else if($tipe == "addreturndocument")
{
    $myid = $_POST['myidlend'];
    $nikuser = $_POST['mynikuser'];
    $nikadmin = $_POST['mynikadmin'];
    date_default_timezone_set('Asia/Jakarta');
    $mydate = date('Y-m-d H:i:s');
    $sql = "INSERT into document_return_log values(NULL, '$myid', '$nikuser', '$nikadmin', '$mydate')";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
}
else if($tipe == "getdocumentlog"){
    $nomertransaksi = $_POST['mytransaction'];
    $myid = $_POST['myidlend'];
    $mystring = '<div class="card" style = "text-align:left;"><div class="card-header header-elements-inline"><h6 class="card-title">Document Activity Timeline <br><br> <a href = "#myModalreturn"  data-toggle="modal" id = "'.$myid.'" onclick = "openmodalreturn(this)" > <button class = "btn bg-success" style = "float:left;"><i class = "icon-redo2"></i> &nbsp Return Document</button></a> <button class = "btn bg-warning" style = "margin-left:10px;float:left;"><i class = "mi-schedule"></i> &nbsp Add Extension Time</button></h6></div><div class="card-body"><div class="chart mb-3" id="bullets"></div><ul class="media-list" id = "mybody'.$myid.'">';
   
    $sqlreturn = 'SELECT drt.*, document.name, document_lend.notransaction , karyawanpengembali.nama as namapengembali, karyawanpenerima.nama as namapenerima FROM document_return_log drt inner join document_lend on document_lend.id = drt.iddocumentlend inner join karyawan karyawanpengembali on karyawanpengembali.nik = drt.nik_return inner join karyawan karyawanpenerima on karyawanpenerima.nik = drt.nik_admin inner join document on document.id = document_lend.iddocument where drt.iddocumentlend = '.$myid;
    $resreturn = $conn->query($sqlreturn);

    $sql = 'select *, document_lend_extend_log.created_at as dibikinpada from document_lend_extend_log inner join document_lend on document_lend.id = document_lend_extend_log.iddocumentlend inner join document on document.id = document_lend.iddocument where iddocumentlend = '.$myid;
    $res = $conn->query($sql);
    $jumlahdata = 0;
    //Return
    if($resreturn -> num_rows>0)
    {
        $mystring = '<div class="card" style = "text-align:left;"><div class="card-header header-elements-inline"><h6 class="card-title">Document Activity Timeline  </h6></div><div class="card-body"><div class="chart mb-3" id="bullets"></div><ul id = "mybody'.$myid.'" class="media-list">';
   
        while($r = mysqli_fetch_array($resreturn))
        {
            $mystring .= '<li class="media"><div class="mr-3"><a href="#" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon legitRipple"><i class="icon-redo2"></i></a></div><div class="media-body">'.$r['name'].' from transaction #'.$r['notransaction'].' has been returned from <b>'.$r['nik_return']."-".$r['namapengembali'].'</b> to Admin <b>'.$r['nik_admin']."-".$r['namapenerima'].'</b><div class="text-muted">This report, created on '.date("D, d F Y", strtotime($r['returnat'])).'</div>	</div></li>';
            $jumlahdata +=1;
         }
         
        // echo $mystring;
    }
    else{
        $mystring = '<div class="card" style = "text-align:left;"><div class="card-header header-elements-inline"><h6 class="card-title">Document Activity Timeline <br><br> <a href = "#myModalreturn"  data-toggle="modal" id = "'.$myid.'" onclick = "openmodalreturn(this)" > <button class = "btn bg-success" style = "float:left;"><i class = "icon-redo2"></i> &nbsp Return Document</button></a> <button class = "btn bg-warning" style = "margin-left:10px;float:left;"><i class = "mi-schedule"></i> &nbsp Add Extension Time</button></h6></div><div class="card-body"><div class="chart mb-3" id="bullets"></div><ul id = "mybody'.$myid.'" class="media-list">';
   
    }
  


    // Extend
    if($res -> num_rows>0)
    {
    while($r = mysqli_fetch_array($res))
    {
        $mystring .= '<li class="media"><div class="mr-3"><a href="#" class="btn bg-transparent border-warning text-warning rounded-round border-2 btn-icon legitRipple"><i class="mi-schedule"></i></a></div><div class="media-body">'.$r['name'].' from transaction #'.$r['notransaction'].' has been extended from <b>'.$r['extendfrom'].'</b> to <b>'.$r['extendto'].'</b><div class="text-muted">This report, created on '.date("D, d F Y", strtotime($r['dibikinpada'])).'</div>	</div></li>';
        $jumlahdata +=1;
    }
   
    }
  
    if($jumlahdata == 0)
    {
        $mystring .= '<li class="media"><div class="mr-3"><a href="#" class="btn bg-transparent border-teal text-teal rounded-round border-2 btn-icon legitRipple"><i class="icon-files-empty"></i></a></div><div class="media-body">There is no activty log right now for this document transaction</div>	</div></li>';
    }
    $mystring .= " </ul></div>";
    echo $mystring;
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