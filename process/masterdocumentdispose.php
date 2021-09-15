<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'notransaction',
        'branch',
        'name',
        'nama',
        'reason',
        'created_at'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    "SELECT dd.*, lbranch.branch, document.name, karyawan.nama, reason.reason FROM document_dispose dd 
    inner join location_branch lbranch on lbranch.idbranch = dd.idbranch 
    inner join document on document.id = dd.iddocument 
    inner join karyawan on karyawan.nik = dd.nik_admin 
    inner join reason on reason.id = dd.reason
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT dd.*, lbranch.branch, document.name, karyawan.nama, reason.reason FROM document_dispose dd 
        inner join location_branch lbranch on lbranch.idbranch = dd.idbranch 
        inner join document on document.id = dd.iddocument 
        inner join karyawan on karyawan.nik = dd.nik_admin 
        inner join reason on reason.id = dd.reason  ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT dd.*, lbranch.branch, document.name, karyawan.nama, reason.reason FROM document_dispose dd 
        inner join location_branch lbranch on lbranch.idbranch = dd.idbranch 
        inner join document on document.id = dd.iddocument 
        inner join karyawan on karyawan.nik = dd.nik_admin 
        inner join reason on reason.id = dd.reason ");

    } else {
        $query_data = mysqli_query($conn, "SELECT dd.*, lbranch.branch, document.name, karyawan.nama, reason.reason FROM document_dispose dd 
        inner join location_branch lbranch on lbranch.idbranch = dd.idbranch 
        inner join document on document.id = dd.iddocument 
        inner join karyawan on karyawan.nik = dd.nik_admin 
        inner join reason on reason.id = dd.reason  
        WHERE  dd.notransaction LIKE '%$search%' 
        OR dd.created_at LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR document.name LIKE '%$search%'
        OR dd.nik_admin LIKE '%$search%'
        OR karyawan.nama LIKE '%$search%'
        OR reason.reason LIKE '%$search%' 
        ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT dd.*, lbranch.branch, document.name,  karyawan.nama, reason.reason FROM document_dispose dd 
        inner join location_branch lbranch on lbranch.idbranch = dd.idbranch 
        inner join document on document.id = dd.iddocument 
        inner join karyawan on karyawan.nik = dd.nik_admin 
        inner join reason on reason.id = dd.reason  
        WHERE  dd.notransaction LIKE '%$search%'
        OR dd.created_at LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR document.name LIKE '%$search%'
        OR dd.nik_admin LIKE '%$search%'
        OR karyawan.nama LIKE '%$search%'
        OR reason.reason LIKE '%$search%'");
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
            
            $response['data'][] = [
                "<label id ='branch".$row['id']."'>".ucfirst($row['branch'])."</label>",
                "<label id ='notransaction".$row['id']."'>".$row['notransaction']."</label>",
                "<label id ='document".$row['id']."'>".ucfirst($row['name'])."</label>",               
                "<label id ='createdat".$row['id']."'>".$row['created_at']."</label>",
                "<label id ='reason".$row['id']."'>".$row['reason']."</label>",
                "<label id ='nik".$row['id']."'>".$row['nik_admin']."</label>",
                "<label id ='name".$row['id']."'>".ucfirst($row['nama'])."</label>"
                
               
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
    $myreason = $_POST['myreason'];
    $mydescription = $_POST['mydescription'];
    $sql = "INSERT into reason values(NULL, '".$myreason."' , '".$mydescription."', 'Active')";
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
    $sql = "select location_floor.floor, location_floor.id  from location_setup_building_floor inner join location_floor on location_floor.id = location_setup_building_floor.idfloor  where location_setup_building_floor.idbuilding = '".$id."' and location_setup_building_floor.idsetupsisterbranch = '".$idsister."'";
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
    $myreason = $_POST['myreason'];
    $mydescription = $_POST['mydescription'];
    $sql = "update reason set 
           reason = '".$myreason."',
           description = '".$mydescription."' 
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
    $sql = "update reason set status = '".$stat."' where id = '".$myid."'";
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