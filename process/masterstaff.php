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
    
    "select k.nik, k.description as deskripsipegawai, k.email, rank.rank, k.nama as namakaryawan, k.alamat, k.nohp, lsc.name as sistername, lbranch.branch, 
    lbuilding.description as buildingname, divi.divisi, depa.department FROM karyawan k 
    inner join location_sister_company lsc on lsc.id = k.idsistercompany
    inner join location_branch lbranch on lbranch.idbranch = k.idbranch
    inner join location_building lbuilding on lbuilding.id = k.idbuilding
    inner join divisi divi on divi.id = k.iddivisi
    inner join department depa on depa.id = k.iddepartment
    inner join rank on rank.id = k.idrank
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select k.nik, k.description as deskripsipegawai, k.status as statuspegawai, k.email, rank.rank, k.nama as namakaryawan, k.alamat, k.nohp, lsc.name as sistername, lbranch.branch, depa.department FROM karyawan k inner join location_sister_company lsc on lsc.id = k.idsistercompany inner join location_branch lbranch on lbranch.idbranch = k.idbranch inner join department depa on depa.id = k.iddepartment inner join rank on rank.id = k.idrank  ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select k.nik, k.description as deskripsipegawai, k.status as statuspegawai, k.email, rank.rank, k.nama as namakaryawan, k.alamat, k.nohp, lsc.name as sistername, lbranch.branch, depa.department FROM karyawan k inner join location_sister_company lsc on lsc.id = k.idsistercompany inner join location_branch lbranch on lbranch.idbranch = k.idbranch inner join department depa on depa.id = k.iddepartment inner join rank on rank.id = k.idrank ");
    } else {
        $query_data = mysqli_query($conn, "select k.nik, k.description as deskripsipegawai, k.status as statuspegawai, k.email, rank.rank, k.nama as namakaryawan, k.alamat, k.nohp, lsc.name as sistername, lbranch.branch, depa.department FROM karyawan k inner join location_sister_company lsc on lsc.id = k.idsistercompany inner join location_branch lbranch on lbranch.idbranch = k.idbranch inner join department depa on depa.id = k.iddepartment inner join rank on rank.id = k.idrank 
        WHERE k.nik LIKE '%$search%' 
        OR k.nama LIKE '%$search%'
        OR lbranch.branch LIKE '%$search%'
        OR depa.department LIKE '%$search%'
        OR k.description LIKE '%$search%'
        OR rank.rank LIKE '%$search%'
        OR k.email LIKE '%$search%'
        OR k.status LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select k.nik, k.description as deskripsipegawai, k.status as statuspegawai, k.email, rank.rank, k.nama as namakaryawan, k.alamat, k.nohp, lsc.name as sistername, lbranch.branch, depa.department FROM karyawan k inner join location_sister_company lsc on lsc.id = k.idsistercompany inner join location_branch lbranch on lbranch.idbranch = k.idbranch inner join department depa on depa.id = k.iddepartment inner join rank on rank.id = k.idrank 
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
                "<label id ='rank".$row['nik']."'>".$row['deskripsipegawai']."</label>",
                "<label id ='rank".$row['nik']."'>".$row['email']."</label>",
                "<label id ='status".$row['nik']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['nik'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
    $country = $_POST['mycountry'];
    $province = $_POST['myprovince'];
    $sql = "INSERT into province values(NULL, '".$country."', '".$province."', 'Active')";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
}
else if($tipe == "change")
{
    $id  = $_POST['myid'];
    $mycountry = $_POST['mycountry'];
    $myprovince = $_POST['myprovince'];
    $sql = "update province set idcountry = '".$mycountry."', name = '".$myprovince."' where id = '".$id."'";
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
    $sql = "update province set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
?>