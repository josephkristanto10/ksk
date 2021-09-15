<?php
require '../connection.php';
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'code',
        'sistername',
        'address',
        'telp',
        'description',
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
    
    $total_data = mysqli_query($conn, 
    "select  lsc.idholdingcompany, lsc.id as idsister , lsc.code, lsc.name as sistername, lsc.address, lsc.telp, 
    lsc.description, coun.name as countryname, coun.id as idcountry, prov.id as idprov , city.id as idcity, prov.name as provincename, 
    city.name as cityname , lsc.status as statussister from location_sister_company lsc 
    inner join country coun on coun.id = lsc.country 
    inner join province prov on prov.id = lsc.province
    inner join city city on city.id = lsc.city
    "
);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select  lsc.idholdingcompany, lsc.id as idsister , lsc.code, lsc.name as sistername, lsc.address, lsc.telp, 
        lsc.description, coun.name as countryname, coun.id as idcountry, prov.id as idprov , city.id as idcity, prov.name as provincename, 
        city.name as cityname , lsc.status as statussister from location_sister_company lsc 
        inner join country coun on coun.id = lsc.country 
        inner join province prov on prov.id = lsc.province
        inner join city city on city.id = lsc.city ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select  lsc.idholdingcompany, lsc.id as idsister , lsc.code, lsc.name as sistername, lsc.address, lsc.telp, 
        lsc.description, coun.name as countryname, coun.id as idcountry, prov.id as idprov , city.id as idcity, prov.name as provincename, 
        city.name as cityname, lsc.status as statussister from location_sister_company lsc 
        inner join country coun on coun.id = lsc.country 
        inner join province prov on prov.id = lsc.province
        inner join city city on city.id = lsc.city");

    } else {
        $query_data = mysqli_query($conn, "select  lsc.idholdingcompany, lsc.id as idsister , lsc.code, lsc.name as sistername, lsc.address, lsc.telp, 
        lsc.description, coun.name as countryname, coun.id as idcountry, prov.id as idprov , city.id as idcity, prov.name as provincename, 
        city.name as cityname, lsc.status as statussister from location_sister_company lsc 
        inner join country coun on coun.id = lsc.country 
        inner join province prov on prov.id = lsc.province
        inner join city city on city.id = lsc.city 
        WHERE lsc.code LIKE '%$search%' 
        OR lsc.name LIKE '%$search%'
        OR lsc.address LIKE '%$search%'
        OR lsc.telp LIKE '%$search%'
        OR lsc.description LIKE '%$search%'
        OR coun.name LIKE '%$search%'
        OR prov.name LIKE '%$search%'
        OR city.name LIKE '%$search%'
        OR lsc.status LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select lsc.idholdingcompany, lsc.id as idsister, lsc.code, lsc.name as sistername, lsc.address, lsc.telp, 
        lsc.description, coun.name as countryname, coun.id as idcountry, prov.id as idprov , city.id as idcity, prov.name as provincename, 
        city.name as cityname, lsc.status as statussister from location_sister_company lsc 
        inner join country coun on coun.id = lsc.country 
        inner join province prov on prov.id = lsc.province
        inner join city city on city.id = lsc.city 
        WHERE lsc.code LIKE '%$search%' 
        OR lsc.name LIKE '%$search%'
        OR lsc.address LIKE '%$search%'
        OR lsc.telp LIKE '%$search%'
        OR lsc.description LIKE '%$search%'
        OR coun.name LIKE '%$search%'
        OR prov.name LIKE '%$search%'
        OR city.name LIKE '%$search%'
        OR lsc.status LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            if($row['statussister'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idsister']."-".$myactionsetto."')><i class='icon-check'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['idsister']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            
            $response['data'][] = [
                "<label id ='code".$row['idsister']."'>".$row['code']."</label>",
                "<label id ='name".$row['idsister']."'>".$row['sistername']."</label>",
                "<label id ='desc".$row['idsister']."'>".$row['description']."</label>",
                "<label id ='address".$row['idsister']."'>".$row['address']."</label>",
                "<label id ='country".$row['idsister']."'>".$row['countryname']."</label>",
                "<label id ='province".$row['idsister']."'>".$row['provincename']."</label>",
                "<label id ='city".$row['idsister']."'>".$row['cityname']."</label>",
                "<label id ='telp".$row['idsister']."'>".$row['telp']."</label>",
                "<label id ='status".$row['idsister']."'>".$mystats."</label>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['idsister'].'-'.$row['idcountry'].'-'.$row['idprov'].'-'.$row['idcity'].'-'.$row['idholdingcompany'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
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
    $code = $_POST['code'];
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $telp = $_POST['telp'];
    $holding = $_POST['holding'];

    $sql = "INSERT into location_sister_company values(NULL,'".$holding."', '".$code."', '".$name."', '".$address."', '".$country."', '".$province."', '".$city."', '".$telp."', '".$desc."', 'Active')";
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
    $code = $_POST['mycode'];
    $name = $_POST['myname'];
    $holding = $_POST['myholding'];
    $desc = $_POST['mydesc'];
    $address = $_POST['myaddress'];
    $country = $_POST['mycountry'];
    $province = $_POST['myprovince'];
    $city = $_POST['mycity'];
    $telp = $_POST['mytelp'];
    $sql = "update location_sister_company set 
           code = '".$code."', 
           name = '".$name."', 
           idholdingcompany = '".$holding."',
           address = '".$address."',
           country = '".$country."',
           province = '".$province."',
           city = '".$city."',
           telp = '".$telp."',
           description = '".$desc."' 
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
    $sql = "update location_sister_company set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
else if($tipe == "getprovince")
{
    $getid = $_POST['idcountry'];
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
else if($tipe == "getcity")
{
    $getid = $_POST['idprovince'];
    $sql = "select * from city where city.idprovince = '".$getid."' and city.status = 'Active'";
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
else if($tipe == "getdepartment")
{
    $getid = $_POST['iddivisi'];
    $sql = "select *, department.id as iddepartment from department inner join divisi on divisi.id = department.iddivisi  where divisi.id = '".$getid."' and department.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['iddepartment']."' >".$r['department']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
?>