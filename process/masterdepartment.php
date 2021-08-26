<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'divisi',
        'department',
        'description',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, "select *, department.description as depardesc, department.id as iddepartment, department.status as statdepartment from department inner join divisi on divisi.id = department.iddivisi");
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select *, department.description as depardesc , department.id as iddepartment, department.status as statdepartment from department inner join divisi on divisi.id = department.iddivisi ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, department.description as depardesc , department.id as iddepartment, department.status as statdepartment  from department inner join divisi on divisi.id = department.iddivisi");
    } else {
        $query_data = mysqli_query($conn, "select *, department.description as depardesc , department.id as iddepartment, department.status as statdepartment from department inner join divisi on divisi.id = department.iddivisi WHERE divisi.divisi LIKE '%$search%' OR department.description LIKE '%$search%' OR department.department LIKE '%$search%' OR department.status LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, department.description as depardesc , department.id as iddepartment, department.status as statdepartment from department inner join divisi on divisi.id = department.iddivisi WHERE divisi.divisi LIKE '%$search%' OR department.description LIKE '%$search%' OR department.department LIKE '%$search%' OR department.status LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['statdepartment'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['iddepartment']."-".$myactionsetto."')><i class='icon-check'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['iddepartment']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label id ='divisi".$row['iddepartment']."'>".$row['divisi']."</label>",
                "<label id ='department".$row['iddepartment']."'>".$row['department']."</label>",
                "<label id ='description".$row['iddepartment']."'>".$row['depardesc']."</label>",
                "<label id ='status".$row['iddepartment']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['iddepartment'].'-'.$row['iddivisi'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
else if($tipe == "adddepartment"){
    $mydiv = $_POST['mydiv'];
    $mydesc = $_POST['mydesc'];
    $mydepar = $_POST['mydepar'];
    $sql = "INSERT into department values(NULL, '".$mydiv."', '".$mydepar."', '".$mydesc."' , 'Active')";
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
    $department = $_POST['mydepar'];
    $description = $_POST['mydesc'];
    $divisi = $_POST['mydivision'];
    
    $sql = "update department set iddivisi = '".$divisi."', department = '".$department."', description = '".$description."' where id = '".$id."'";
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
    $sql = "update department set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
?>