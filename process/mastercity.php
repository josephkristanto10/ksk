<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'countryname',
        'provincename',
        'cityname',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, "select *, city.idprovince  as idprovince, province.idcountry as idcountry, city.id as idcity,province.name as provincename, city.name as cityname, city.status as statuscity, country.name as countryname from city inner join province on province.id = city.idprovince inner join country on country.id = province.idcountry");
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select *, city.idprovince  as idprovince, province.idcountry as idcountry, city.id as idcity,province.name as provincename, city.name as cityname, city.status as statuscity, country.name as countryname from city inner join province on province.id = city.idprovince inner join country on country.id = province.idcountry ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, city.idprovince  as idprovince, province.idcountry as idcountry, city.id as idcity,province.name as provincename, city.name as cityname, city.status as statuscity, country.name as countryname from city inner join province on province.id = city.idprovince inner join country on country.id = province.idcountry");
    } else {
        $query_data = mysqli_query($conn, "select *, city.idprovince  as idprovince, province.idcountry as idcountry, city.id as idcity,province.name as provincename, city.name as cityname, city.status as statuscity, country.name as countryname from city inner join province on province.id = city.idprovince inner join country on country.id = province.idcountry WHERE country.name LIKE '%$search%' OR province.name LIKE '%$search%' OR city.name LIKE '%$search%' OR city.status LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select *, city.idprovince  as idprovince, province.idcountry as idcountry, city.id as idcity,province.name as provincename, city.name as cityname, city.status as statuscity, country.name as countryname from city inner join province on province.id = city.idprovince inner join country on country.id = province.idcountry WHERE country.name LIKE '%$search%' OR province.name LIKE '%$search%' OR city.name LIKE '%$search%' OR city.status LIKE '%$search%' ");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['statuscity'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idcity']."-".$myactionsetto."')><i class='icon-check'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idcity']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label id ='country".$row['idcity']."'>".$row['countryname']."</label>",
                "<label id ='province".$row['idcity']."'>".$row['provincename']."</label>",
                "<label id ='city".$row['idcity']."'>".$row['cityname']."</label>",
                "<label id ='status".$row['idcity']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['idcity'].'-'.$row['idcountry'].'-'.$row['idprovince'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
    $city = $_POST['mycity'];
    $sql = "INSERT into city values(NULL, '".$province."', '".$city."', 'Active')";
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
    $mycity = $_POST['mycity'];
    $sql = "update city set idprovince = '".$myprovince."', name = '".$mycity."' where id = '".$id."'";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
}
else if($tipe == "getprovince")
{
    $getid = $_POST['idprovince'];
    $sql = "select * from province where province.idcountry = '".$getid."' and province.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['name']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
else if($tipe == "setstatus")
{
    $myid = $_POST['myidchange'];
    $stat = $_POST['stat'];
    $sql = "update city set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
?>