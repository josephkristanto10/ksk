<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'code',
        'branch',
        'description',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, "select * from location_branch");
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select * from location_branch ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select * from location_branch");
    } else {
        $query_data = mysqli_query($conn, "select * from location_branch WHERE branch LIKE '%$search%' OR description LIKE '%$search%' OR status LIKE '%$search%'  ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select * from location_branch WHERE branch LIKE '%$search%' OR description LIKE '%$search%' OR status LIKE '%$search%' ");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['status'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idbranch']."-".$myactionsetto."')><i class='icon-check'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idbranch']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label id ='code".$row['idbranch']."'>".$row['code']."</label>",
                "<label id ='branch".$row['idbranch']."'>".$row['branch']."</label>",
                "<label id ='description".$row['idbranch']."'>".$row['description']."</label>",
                "<label id ='status".$row['idbranch']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['idbranch'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
    $code = $_POST['mycode'];
    $branch = $_POST['mybranch'];
    $desc = $_POST['mydescription'];
    $sql = "INSERT into location_branch values(NULL, '".$code."', '".$branch."', '".$desc."' , 'Active')";
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
    $code = $_POST['mycode'];
    $branch = $_POST['mybranch'];
    $desc = $_POST['mydesc'];
    
    $sql = "update location_branch set code = '".$code."', branch = '".$branch."', description = '".$desc."' where idbranch = '".$id."'";
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
    $sql = "update location_branch set status = '".$stat."' where idbranch = '".$myid."'";
    $res = $conn->query($sql);
}
?>