<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'locationname',
        'cityname',
        'desc1',
        'desc2',
        'mocstatus'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, "select *, moc.id as otherid, moc.status as mocstatus, city.name as cityname, city.id as idcity from master_other_location moc inner join city on city.id = moc.city");
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select *, moc.id as otherid, moc.status as mocstatus, city.name as cityname, city.id as idcity from master_other_location moc inner join city on city.id = moc.city ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, moc.id as otherid, moc.status as mocstatus, city.name as cityname, city.id as idcity from master_other_location moc inner join city on city.id = moc.city");
    } else {
        $query_data = mysqli_query($conn, "select *, moc.id as otherid, moc.status as mocstatus, city.name as cityname, city.id as idcity from master_other_location moc inner join city on city.id = moc.city WHERE locationname LIKE '%$search%' OR city.name LIKE '%$search%' OR moc.status LIKE '%$search%' OR moc.desc1 LIKE '%$search%' OR moc.desc2 LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, moc.id as otherid, moc.status as mocstatus, city.name as cityname, city.id as idcity from master_other_location moc inner join city on city.id = moc.city WHERE locationname LIKE '%$search%' OR city.name LIKE '%$search%' OR moc.status LIKE '%$search%' OR moc.desc1 LIKE '%$search%' OR moc.desc2 LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['mocstatus'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['otherid']."-".$myactionsetto."')><i class='icon-check'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['otherid']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label id ='locationname".$row['otherid']."'>".$row['locationname']."</label>",
                "<label id ='cityname".$row['otherid']."'>".$row['cityname']."</label>",
                "<label id ='desc1".$row['otherid']."'>".$row['desc1']."</label>",
                "<label id ='desc2".$row['otherid']."'>".$row['desc2']."</label>",
                "<label id ='status".$row['otherid']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['otherid'].'-'.$row['idcity'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
    $name = $_POST['name'];
    $city = $_POST['city'];
    $desc1 = $_POST['desc1'];
    $desc2 = $_POST['desc2'];
    $sql = "INSERT into master_other_location values(NULL, '".$name."', '".$city."', '".$desc1."', '".$desc2."', 'Active')";
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
    $locationname = $_POST['mylocationname'];
    $city = $_POST['mycity'];
    $desc1 = $_POST['mydesc1'];
    $desc2 = $_POST['mydesc2'];
    $sql = "update master_other_location set locationname = '".$locationname."', city = '".$city."' , desc1 = '".$desc1."', desc2 = '".$desc2."' where id = '".$id."'";
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
    $sql = "update master_other_location set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
?>