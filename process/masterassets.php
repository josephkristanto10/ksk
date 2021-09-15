<?php
require '../connection.php';
session_start();
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'groupname',
        'subgroupname',
        'categoryname',
        'noasset',
        'name',
        'initial_condition',
        'conditions',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, asset.* FROM `asset`
    inner join kategori_asset ka on ka.id = asset.idgroup
    inner join kategori_subgroup ks on ks.id = asset.idsubgroup
    inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
    inner join conditions c on c.id = asset.idcondition
    inner join initial_condition ic on ic.id = asset.idinitialcondition
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, asset.* FROM `asset`
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, asset.* FROM `asset`
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition ");
    } else {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, asset.* FROM `asset`
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        WHERE ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, asset.* FROM `asset`
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        WHERE ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%'");
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
                "<label id ='group".$row['id']."'>".$row['groupname']."</label>",
                "<label id ='subgroup".$row['id']."'>".$row['subgroupname']."</label>",
                "<label id ='category".$row['id']."'>".$row['categoryname']."</label>",
                "<label id ='initial".$row['id']."'>".$row['initial_condition']."</label>",
                "<label id ='condition".$row['id']."'>".$row['conditions']."</label>",
                "<label id ='noasset".$row['id']."'>".$row['noasset']."</label>",
                "<label id ='name".$row['id']."'>".$row['name']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id'].'-'.$row['idgroup'].'-'.$row['idsubgroup'].'-'.$row['idcategory'].'-'.$row['idinitialcondition'].'-'.$row['idcondition'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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

    $idsister = $_SESSION['idsister'];
    $group = $_POST['group'];
    $subgroup = $_POST['subgroup'];
    $category = $_POST['category'];
    $initialcondition = $_POST['initialcondition'];
    $condition = $_POST['condition'];
    $noasset = $_POST['noasset'];
    $name = $_POST['name'];

    $sql = "INSERT into asset values(NULL,'".$idsister."', '".$group."', '".$subgroup."', '".$category."', '".$initialcondition."', '".$condition."', '".$noasset."', '".$name."', 'Active', NULL, NULL)";
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
    $idsister = $_SESSION['idsister'];
    $group = $_POST['group'];
    $subgroup = $_POST['subgroup'];
    $category = $_POST['category'];
    $initialcondition = $_POST['initialcondition'];
    $condition = $_POST['condition'];
    $noasset = $_POST['noasset'];
    $name = $_POST['name'];
    $sql = "update asset set 
           idsistercompany = '".$idsister."', 
           idgroup = '".$group."', 
           idsubgroup = '".$subgroup."',
           idcategory = '".$category."',
           idinitialcondition = '".$initialcondition."',
           idcondition = '".$condition."',
           noasset = '".$noasset."',
           name = '".$name."' 
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
    $sql = "update asset set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
else if($tipe == "getsubgroup")
{
    $getid = $_POST['idgroup'];
    $sql = "select ks.id, ks.subgroup from kategori_subgroup ks where ks.idkategoriaset = '".$getid."' and ks.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['subgroup']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
else if($tipe == "getcategory")
{
    $getid = $_POST['idsubgroup'];
    $sql = "select kcs.id, kcs.category from kategori_categorysubgroup kcs where kcs.idsubgroup = '".$getid."' and kcs.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['category']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
?>