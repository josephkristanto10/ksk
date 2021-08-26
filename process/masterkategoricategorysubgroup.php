<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'nama',
        'subgroup',
        'category',
        'description',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, "select c.id, ka.id as idgroup , ks.id as idsubgroup, ka.nama as namagroup, ks.subgroup as namasubgroup, c.category , c.description as categorydesc, c.status from kategori_categorysubgroup c inner join kategori_asset ka on ka.id = c.idgroup inner join kategori_subgroup ks on ks.id = c.idsubgroup");
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select c.id, ka.id as idgroup , ks.id as idsubgroup, ka.nama as namagroup, ks.subgroup as namasubgroup, c.category , c.description as categorydesc, c.status from kategori_categorysubgroup c inner join kategori_asset ka on ka.id = c.idgroup inner join kategori_subgroup ks on ks.id = c.idsubgroup ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select c.id, ka.id as idgroup , ks.id as idsubgroup, ka.nama as namagroup, ks.subgroup as namasubgroup, c.category , c.description as categorydesc, c.status from kategori_categorysubgroup c inner join kategori_asset ka on ka.id = c.idgroup inner join kategori_subgroup ks on ks.id = c.idsubgroup");
    } else {
        $query_data = mysqli_query($conn, "select c.id, ka.id as idgroup , ks.id as idsubgroup, ka.nama as namagroup, ks.subgroup as namasubgroup, c.category , c.description as categorydesc, c.status from kategori_categorysubgroup c inner join kategori_asset ka on ka.id = c.idgroup inner join kategori_subgroup ks on ks.id = c.idsubgroup WHERE ka.nama LIKE '%$search%' OR ks.subgroup LIKE '%$search%' OR c.category LIKE '%$search%' OR c.description LIKE '%$search%'   ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select c.id, ka.id as idgroup , ks.id as idsubgroup, ka.nama as namagroup, ks.subgroup as namasubgroup, c.category , c.description as categorydesc, c.status from kategori_categorysubgroup c inner join kategori_asset ka on ka.id = c.idgroup inner join kategori_subgroup ks on ks.id = c.idsubgroup WHERE ka.nama LIKE '%$search%' OR ks.subgroup LIKE '%$search%' OR c.category LIKE '%$search%' OR c.description LIKE '%$search%' ");
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
                "<label id ='nama".$row['id']."'>".$row['namagroup']."</label>",
                "<label id ='subgroup".$row['id']."'>".$row['namasubgroup']."</label>",
                "<label id ='category".$row['id']."'>".$row['category']."</label>",
                "<label id ='description".$row['id']."'>".$row['categorydesc']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id']."-".$row['idgroup']."-".$row['idsubgroup'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
else if($tipe == "addcategory"){

    $mycat = $_POST['mycategory'];
    $mygroup = $_POST['group'];
    $mysubgroup = $_POST['sub'];
    $mydesc = $_POST['desc'];
    $sql = "INSERT into kategori_categorysubgroup values(NULL, '".$mygroup."', '".$mysubgroup."', '".$mycat."', '".$mydesc."' , 'Active')";
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
    $cat = $_POST['mycategory'];
    $group = $_POST['mygroup'];
    $description = $_POST['mydesc'];
    $mysubgroup = $_POST['mysubgroup'];
    $sql = "update kategori_categorysubgroup set idgroup = '".$group."', idsubgroup = '".$mysubgroup."', category = '".$cat."', description = '".$description."' where id = '".$id."'";
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
    $sql = "update kategori_categorysubgroup set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
// ?>