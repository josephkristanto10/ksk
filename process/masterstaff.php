<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'nik',
        'namakaryawan',
        'branch',
        'department',
        'rank',
        'email',
        'deskripsipegawai',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "select lbranch.idbranch, lsc.id as idsister, divisi.id as iddivisi, k.nik, k.description as deskripsipegawai, k.status as statuspegawai, k.email, rank.rank, k.nama as namakaryawan,  lsc.name as sistername, lbranch.branch, depa.department, depa.id as iddepart, rank.id as idrank  FROM karyawan k inner join location_sister_company lsc on lsc.id = k.idsistercompany inner join location_branch lbranch on lbranch.idbranch = k.idbranch inner join department depa on depa.id = k.iddepartment inner join rank on rank.id = k.idrank inner join divisi on divisi.id = k.iddivisi
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select lbranch.idbranch, lsc.id as idsister, divisi.id as iddivisi, k.nik, k.description as deskripsipegawai, k.status as statuspegawai, k.email, rank.rank, k.nama as namakaryawan,  lsc.name as sistername, lbranch.branch, depa.department, depa.id as iddepart, rank.id as idrank  FROM karyawan k inner join location_sister_company lsc on lsc.id = k.idsistercompany inner join location_branch lbranch on lbranch.idbranch = k.idbranch inner join department depa on depa.id = k.iddepartment inner join rank on rank.id = k.idrank inner join divisi on divisi.id = k.iddivisi  ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select lbranch.idbranch, lsc.id as idsister, divisi.id as iddivisi, k.nik, k.description as deskripsipegawai, k.status as statuspegawai, k.email, rank.rank, k.nama as namakaryawan,  lsc.name as sistername, lbranch.branch, depa.department, depa.id as iddepart, rank.id as idrank  FROM karyawan k inner join location_sister_company lsc on lsc.id = k.idsistercompany inner join location_branch lbranch on lbranch.idbranch = k.idbranch inner join department depa on depa.id = k.iddepartment inner join rank on rank.id = k.idrank inner join divisi on divisi.id = k.iddivisi ");
    } else {
        $query_data = mysqli_query($conn, "select lbranch.idbranch, lsc.id as idsister, divisi.id as iddivisi, k.nik, k.description as deskripsipegawai, k.status as statuspegawai, k.email, rank.rank, k.nama as namakaryawan,  lsc.name as sistername, lbranch.branch, depa.department, depa.id as iddepart, rank.id as idrank  FROM karyawan k inner join location_sister_company lsc on lsc.id = k.idsistercompany inner join location_branch lbranch on lbranch.idbranch = k.idbranch inner join department depa on depa.id = k.iddepartment inner join rank on rank.id = k.idrank inner join divisi on divisi.id = k.iddivisi 
        WHERE k.nik LIKE '%$search%' 
        OR k.nama LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR depa.department LIKE '%$search%'
        OR k.description LIKE '%$search%'
        OR rank.rank LIKE '%$search%'
        OR k.email LIKE '%$search%'
        OR k.status LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "lbranch.idbranch, select lsc.id as idsister, divisi.id as iddivisi, k.nik, k.description as deskripsipegawai, k.status as statuspegawai, k.email, rank.rank, k.nama as namakaryawan,  lsc.name as sistername, lbranch.branch, depa.department, depa.id as iddepart, rank.id as idrank FROM karyawan k inner join location_sister_company lsc on lsc.id = k.idsistercompany inner join location_branch lbranch on lbranch.idbranch = k.idbranch inner join department depa on depa.id = k.iddepartment inner join rank on rank.id = k.idrank inner join divisi on divisi.id = k.iddivisi  
         WHERE k.nik LIKE '%$search%' 
         OR k.nama LIKE '%$search%'
         OR lbranch.branch LIKE '%$search%'
         OR depa.department LIKE '%$search%'
         OR k.description LIKE '%$search%'
         OR rank.rank LIKE '%$search%'
         OR k.email LIKE '%$search%'
         OR k.status LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['statuspegawai'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['nik']."-".$myactionsetto."')><i class='icon-check'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['nik']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label > - </label>",
                "<label id ='nik".$row['nik']."'>".$row['nik']."</label>",
                "<label id ='name".$row['nik']."'>".$row['namakaryawan']."</label>",
                "<label id ='branch".$row['nik']."'>".$row['branch']."</label>",
                "<label id ='department".$row['nik']."'>".$row['department']."</label>",
                "<label id ='rank".$row['nik']."'>".$row['rank']."</label>",
                "<label id ='description".$row['nik']."'>".$row['deskripsipegawai']."</label>",
                "<label id ='email".$row['nik']."'>".$row['email']."</label>",
                "<label id ='status".$row['nik']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['nik'].'-'.$row['idsister'].'-'.$row['idbranch'].'-'.$row['iddivisi'].'-'.$row['iddepart'].'-'.$row['idrank'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
    $nik = $_POST['mynik'];
    $name = $_POST['myname'];
    $sister = $_POST['mysister'];
    $branch = $_POST['mybranch'];
    $divisi = $_POST['mydivisi'];
    $depart = $_POST['mydepart'];
    $rank = $_POST['myrank'];
    $email = $_POST['myemail'];
    $desc = $_POST['mydescription'];

    $sql = "INSERT into karyawan values('".$nik."', '".$name."', '".$sister."', '".$branch."', '".$divisi."', '".$depart."', '".$rank."', '".$email."', '".$desc."', 'Active')";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
}
else if($tipe == "changedata")
{
    $id  = $_POST['myid'];
    $nik = $_POST['mynik'];
    $name = $_POST['myname'];
    $sister = $_POST['mysister'];
    $branch = $_POST['mybranch'];
    $divisi = $_POST['mydivisi'];
    $depart = $_POST['mydepart'];
    $rank = $_POST['myrank'];
    $email = $_POST['myemail'];
    $desc = $_POST['mydesc'];
    $sql = "update karyawan set 
           nik = '".$nik."', 
           nama = '".$name."', 
           idsistercompany = '".$sister."',
           idbranch = '".$branch."',
           iddivisi = '".$divisi."',
           iddepartment = '".$depart."',
           idrank = '".$rank."',
           email = '".$email."',
           description = '".$desc."' 
            where nik = '".$id."'";
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
    $sql = "update karyawan set status = '".$stat."' where nik = '".$myid."'";
    $res = $conn->query($sql);
}
else if($tipe == "getbranch")
{
    $getid = $_POST['idbranch'];
    $sql = "select *, lbranch.idbranch as branchid from location_setup_sister_branch lssc inner join location_branch lbranch on  lssc.idbranch = lbranch.idbranch where lssc.idsistercompany = '".$getid."' and lssc.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['branchid']."' >".$r['branch']."</option>";
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