<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'idsubgroup',
        'nama',
        'subgroup',
        'subgroupdesc',
        'statussubgroup'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, "select *, ks.description as subgroupdesc, ks.id as idsubgroup, ks.status as statussubgroup from kategori_subgroup ks inner join kategori_asset ka on ka.id = ks.idkategoriaset order by ks.id desc");
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select *, ks.description as subgroupdesc, ks.id as idsubgroup, ks.status as statussubgroup from kategori_subgroup ks inner join kategori_asset ka on ka.id = ks.idkategoriaset ORDER BY $order $dir,  ks.id desc LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, ks.description as subgroupdesc, ks.id as idsubgroup, ks.status as statussubgroup from kategori_subgroup ks inner join kategori_asset ka on ka.id = ks.idkategoriaset");
    } else {
        $query_data = mysqli_query($conn, "select *, ks.description as subgroupdesc, ks.id as idsubgroup, ks.status as statussubgroup from kategori_subgroup ks inner join kategori_asset ka on ka.id = ks.idkategoriaset WHERE ka.nama LIKE '%$search%' OR ks.subgroup LIKE '%$search%' OR ks.description LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, ks.description as subgroupdesc, ks.id as idsubgroup, ks.status as statussubgroup from kategori_subgroup ks inner join kategori_asset ka on ka.id = ks.idkategoriaset WHERE ka.nama LIKE '%$search%' OR ks.subgroup LIKE '%$search%' OR ks.description LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['statussubgroup'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idsubgroup']."-".$myactionsetto."')><i class='icon-cross'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idsubgroup']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label id ='idsubgroup".$row['idsubgroup']."'>".$row['idsubgroup']."</label>",
                "<label id ='nama".$row['idsubgroup']."'>".$row['nama']."</label>",
                "<label id ='subgroup".$row['idsubgroup']."'>".$row['subgroup']."</label>",
                "<label id ='description".$row['idsubgroup']."'>".$row['subgroupdesc']."</label>",
                "<label id ='status".$row['idsubgroup']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['idsubgroup'].'"  onclick = "openmodaledit(this)"><i class="icon-pen"></i>
                            Edit</a>
                            <a  class="dropdown-item" id ="delete-'.$row['idsubgroup'].'"  onclick = "deleterow(this)"><i class="icon-trash"></i>
                            Delete</a>
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
    $group = $_POST['mygroup'];
    $description = $_POST['descrip'];
    $subgroup = $_POST['mysubgroup'];
    $sql = "INSERT into kategori_subgroup values(NULL, '".$group."', '".$subgroup."', '".$description."' , 'Active')";
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
    $id  = $_POST['idchange'];
    $group = $_POST['mygroup'];
    $description = $_POST['descrip'];
    $mysubgroup = $_POST['mysubgroup'];
    $sql = "update kategori_subgroup set idkategoriaset = '".$group."', subgroup = '".$mysubgroup."', description = '".$description."' where id = '".$id."'";
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
    $sql = "update kategori_subgroup set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
?>