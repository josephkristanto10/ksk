<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'countryname',
        'provincename',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, "select *, province.name as provincename, country.name as countryname, province.idcountry as idcountry, province.id as idprovince, province.status as statusprovince   from province inner join country on country.id = province.idcountry");
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select *, province.name as provincename, country.name as countryname, province.idcountry as idcountry, province.id as idprovince, province.status as statusprovince   from province inner join country on country.id = province.idcountry ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, province.name as provincename, country.name as countryname, province.idcountry as idcountry, province.id as idprovince, province.status as statusprovince   from province inner join country on country.id = province.idcountry");
    } else {
        $query_data = mysqli_query($conn, "select *, province.name as provincename, country.name as countryname, province.idcountry as idcountry, province.id as idprovince, province.status as statusprovince   from province inner join country on country.id = province.idcountry WHERE country.name LIKE '%$search%' OR province.name LIKE '%$search%' OR province.status LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, province.name as provincename, country.name as countryname, province.idcountry as idcountry, province.id as idprovince, province.status as statusprovince  from province inner join country on country.id = province.idcountry WHERE country.name LIKE '%$search%' OR province.name LIKE '%$search%' OR province.status LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['statusprovince'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idprovince']."-".$myactionsetto."')><i class='icon-check'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idprovince']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label id ='country".$row['idprovince']."'>".$row['countryname']."</label>",
                "<label id ='province".$row['idprovince']."'>".$row['provincename']."</label>",
                "<label id ='status".$row['idprovince']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['idprovince'].'-'.$row['idcountry'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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