<?php
require '../connection.php';
session_start();
$tipe = $_POST['tipe'];
if($tipe == "load")
{
    $statusmust = $_POST['statusmust'];
    $params = $_POST['myparam'];
    $where_like = [
        
        'noasset',
        'name',
        'conditions',
        'initial_condition',
        'initial_condition'
        
    ];
    
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
    inner join relation on relation.id = asset.purchase_from 
    inner join kategori_asset ka on ka.id = asset.idgroup
    inner join kategori_subgroup ks on ks.id = asset.idsubgroup
    inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
    inner join conditions c on c.id = asset.idcondition
    inner join initial_condition ic on ic.id = asset.idinitialcondition
     where asset.status_transaction = '$statusmust' and asset.idcategory = '$params'
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        where asset.status_transaction = '$statusmust' and asset.idcategory = '$params' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition  where asset.status_transaction = '$statusmust' and asset.idcategory = '$params' ");
    } else {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        where (asset.status_transaction = '$statusmust' and asset.idcategory = '$params') and ( ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%' ) ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition 
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        where (asset.status_transaction = '$statusmust' and asset.idcategory = '$params') and ( ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%' )");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
       
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
                "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxasset'>",
                "<label id ='noasset".$row['id']."'>".$row['noasset']."</label>",
                "<label id ='name".$row['id']."'>".$row['name']."</label>",
                "<label id ='conditions".$row['id']."'>".$row['conditions']."</label>",
                "<label id ='initial_condition".$row['id']."'>".$row['initial_condition']."</label>"
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
else if($tipe == "loadpicked")
{
    $myid = $_POST['idtransaction'];
    $where_like = [
        
        'noasset',
        'asset.name'
        
    ];
    
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
    inner join asset on asset.id = tdnal.idasset
    inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid'
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
        inner join asset on asset.id = tdnal.idasset
        inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
        inner join asset on asset.id = tdnal.idasset
        inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid'");
    } else {
        $query_data = mysqli_query($conn, "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
        inner join asset on asset.id = tdnal.idasset
        inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid'
         and ( asset.name LIKE '%$search%' 
        OR asset.noasset LIKE '%$search%' ) ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
        inner join asset on asset.id = tdnal.idasset
        inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid'
        and ( asset.name LIKE '%$search%' 
       OR asset.noasset LIKE '%$search%' )");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
       
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
                "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxasset' checked>",
                "<label id ='noasset".$row['id']."'>".$row['noasset']."</label>",
                "<label id ='name".$row['id']."'>".$row['name']."</label>"."<input type = 'hidden' value = '".$row['idcategory']."' id = 'idcategorysummary'>"."<input type = 'hidden' value = '".$row['category']."' id = 'namecategorysummary'>"
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