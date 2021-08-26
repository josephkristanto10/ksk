<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'nama',
        'assignto',
        'description',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, "select * from kategori_asset ");
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select * from kategori_asset ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select * from kategori_asset ");
    } else {
        $query_data = mysqli_query($conn, "select * from kategori_asset WHERE nama LIKE '%$search%' OR assignto LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select * from kategori_asset WHERE nama LIKE '%$search%' OR assignto LIKE '%$search%'");
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
                "<label id ='nama".$row['id']."'>".$row['nama']."</label>",
                "<label id ='assignto".$row['id']."'>".$row['assignto']."</label>",
                "<label id ='description".$row['id']."'>".$row['description']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#editModal" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id'].'"  onclick = "openmodal(this)"><i class="icon-check"></i>
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
    $group = $_POST['mygroup'];
    $description = $_POST['descrip'];
    $select = $_POST['myselect'];
    $myselect = count($select);
    $pilihan = "";
    for($i = 0 ; $i < $myselect; $i++)
    {
        if($i == ($myselect-1))
        {
            $pilihan .= $select[$i];
        }
        else{
            $pilihan .= $select[$i].", ";
        }
    }
    $sql = "INSERT into kategori_asset values(NULL, '".$group."', '".$pilihan."', '".$description."' , 'Active')";
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
    $select = $_POST['myselect'];
    $myselect = count($select);
    $pilihan = "";
    for($i = 0 ; $i < $myselect; $i++)
    {
        if($i == ($myselect-1))
        {
            $pilihan .= $select[$i];
        }
        else{
            $pilihan .= $select[$i].", ";
        }
    }
    $sql = "update kategori_asset set nama = '".$group."', assignto = '".$pilihan."', description = '".$description."' where id = '".$id."'";
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
    $sql = "update kategori_asset set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
?>