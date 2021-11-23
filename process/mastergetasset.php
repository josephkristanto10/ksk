<?php
require '../connection.php';
session_start();
$myses = $_SESSION['idsister'];
$tipe = $_POST['tipe'];
if($tipe == "load")
{
    $statusmust = $_POST['statusmust'];
    $params = $_POST['myparam'];
    $where_like = [
        
        'noasset',
        'name',
        'conditions',
        'initial_condition',
        'initial_condition'
        
    ];
    
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
    inner join relation on relation.id = asset.purchase_from 
    inner join kategori_asset ka on ka.id = asset.idgroup
    inner join kategori_subgroup ks on ks.id = asset.idsubgroup
    inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
    inner join conditions c on c.id = asset.idcondition
    inner join initial_condition ic on ic.id = asset.idinitialcondition
     where asset.status_transaction = '$statusmust' and asset.idcategory = '$params'
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        where asset.status_transaction = '$statusmust' and asset.idcategory = '$params' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition  where asset.status_transaction = '$statusmust' and asset.idcategory = '$params' ");
    } else {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        where (asset.status_transaction = '$statusmust' and asset.idcategory = '$params') and ( ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%' ) ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition 
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        where (asset.status_transaction = '$statusmust' and asset.idcategory = '$params') and ( ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%' )");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
       
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
                "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxasset'>",
                "<label id ='noasset_".$row['id']."'>".$row['noasset']."</label>",
                "<label id ='name_".$row['id']."'>".$row['name']."</label>",
                "<label id ='conditions_".$row['id']."'>".$row['conditions']."</label>",
                "<label id ='initial_condition_".$row['id']."'>".$row['initial_condition']."</label>"
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
else if($tipe == "loadexisting")
{
    $assetexisting = $_POST['assetexisting'];
    $statusmust = $_POST['statusmust'];
    $params = $_POST['myparam'];
    $where_like = [
        
        'noasset',
        'name',
        'conditions',
        'initial_condition',
        'initial_condition'
        
    ];
    
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
    inner join relation on relation.id = asset.purchase_from 
    inner join kategori_asset ka on ka.id = asset.idgroup
    inner join kategori_subgroup ks on ks.id = asset.idsubgroup
    inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
    inner join conditions c on c.id = asset.idcondition
    inner join initial_condition ic on ic.id = asset.idinitialcondition
     where asset.status_transaction = '$statusmust' and asset.idcategory = '$params'
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        where asset.status_transaction = '$statusmust' and asset.idcategory = '$params' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition  where asset.status_transaction = '$statusmust' and asset.idcategory = '$params' ");
    } else {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        where (asset.status_transaction = '$statusmust' and asset.idcategory = '$params') and ( ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%' ) ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
         inner join relation on relation.id = asset.purchase_from 
        inner join kategori_asset ka on ka.id = asset.idgroup
        inner join kategori_subgroup ks on ks.id = asset.idsubgroup
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join conditions c on c.id = asset.idcondition 
        inner join initial_condition ic on ic.id = asset.idinitialcondition 
        where (asset.status_transaction = '$statusmust' and asset.idcategory = '$params') and ( ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%' )");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $truecheck = "False";
            $mcheck =  "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxassetedit'>";
            for($i = 0; $i < count($assetexisting); $i++)
            {
                if($assetexisting[$i] == $row['id'])
                {
                   $mcheck =  "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxassetedit' checked>";
                   $truecheck = "True";
                }
            
            }
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
             
                   $mcheck ,
                "<label id ='noassetedit_".$row['id']."'>".$row['noasset']."</label>",
                "<label id ='nameedit_".$row['id']."'>".$row['name']."</label>",
                "<label id ='conditionsedit_".$row['id']."'>".$row['conditions']."</label>",
                "<label id ='initial_conditionedit_".$row['id']."'>".$row['initial_condition']."</label>",
                $truecheck
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
else if($tipe == "edit")
{
    $idsister = $myses;

    $mybranch = $_POST['mybranch'];
    $myroom = $_POST['myroom'];
    $myselectedlist = $_POST['myselected'];
    $nikuser = $_SESSION['nik'];
    $mytable = $_POST['mytable'];
    $mytabletransactioninput = $_POST['mytable'];
    $mytabletransaction = str_replace("_log", "", $mytabletransactioninput);
    $mytransaction = $_POST['mytransaction'];
    $sql = "update ".$mytabletransaction." set idbranch = '$mybranch', idroom = '$myroom' where id = '$mytransaction'";
    $res = $conn->query($sql);
    echo $sql;
    $sql = "delete from ".$mytable." where idtransaksi = '$mytransaction'";
    $res = $conn->query($sql);

  

    for($i = 0 ; $i< count($myselectedlist); $i++)
    {
        $sql = "insert into ".$mytable." values(NULL, '$mytransaction', '".$myselectedlist[$i]."')";
        $ress = $conn->query($sql);
    }
}
else if($tipe == "getassettransaction")
{
    $arrayid = array();
    $idtransac = $_POST['myidtransaction'];
    $sql = "select asset.id, asset.noasset, asset.name from transaction_displacement_new_asset_log tdasl inner join asset on asset.id = tdasl.idasset where tdasl.idtransaksi = '$idtransac'";
    $res = $conn->query($sql);
    $mystring = "<table class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Name</th></tr>";
    if($res->num_rows >0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $arrayid[] = $r['id'];
            $mystring .= "<tr><td>".$r['noasset']."</td><td>".$r['name']."</td></tr>";
        }
    }
    $mystring .= "</table>";
    // echo print($arrayid)."||".$mystring;
    $response["data"] = array(
        'mystring' => $mystring,
        'myarray' => $arrayid
    );
    echo json_encode($response);

}

else if($tipe == "getassettransactiondepartment")
{
    $arrayid = array();
    $idtransac = $_POST['myidtransaction'];
    $sql = "select asset.id, asset.noasset, asset.name from transaction_displacement_department_log tdasl inner join asset on asset.id = tdasl.idasset where tdasl.idtransaksi = '$idtransac'";
    $res = $conn->query($sql);
    $mystring = "<table class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Name</th></tr>";
    if($res->num_rows >0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $arrayid[] = $r['id'];
            $mystring .= "<tr><td>".$r['noasset']."</td><td>".$r['name']."</td></tr>";
        }
    }
    $mystring .= "</table>";
    // echo print($arrayid)."||".$mystring;
    $response["data"] = array(
        'mystring' => $mystring,
        'myarray' => $arrayid
    );
    echo json_encode($response);

}
else if($tipe == "getassettransactiondepartmentbranch")
{
    $arrayid = array();
    $idtransac = $_POST['myidtransaction'];
    $sql = "select asset.id, asset.noasset, asset.name from transaction_displacement_other_department_log tdasl inner join asset on asset.id = tdasl.idasset where tdasl.idtransaksi = '$idtransac'";
    $res = $conn->query($sql);
    $mystring = "<table class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Name</th></tr>";
    if($res->num_rows >0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $arrayid[] = $r['id'];
            $mystring .= "<tr><td>".$r['noasset']."</td><td>".$r['name']."</td></tr>";
        }
    }
    $mystring .= "</table>";
    // echo print($arrayid)."||".$mystring;
    $response["data"] = array(
        'mystring' => $mystring,
        'myarray' => $arrayid
    );
    echo json_encode($response);
}
else if($tipe  == "getassettransactionlendpersonel")
{
    $arrayid = array();
    $idtransac = $_POST['myidtransaction'];
    $sql = "select asset.id, asset.noasset, asset.name from transaction_lend_to_personal_log tdasl inner join asset on asset.id = tdasl.idasset where tdasl.idtransaksi = '$idtransac'";
    $res = $conn->query($sql);
    $mystring = "<table class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Name</th></tr>";
    if($res->num_rows >0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $arrayid[] = $r['id'];
            $mystring .= "<tr><td>".$r['noasset']."</td><td>".$r['name']."</td></tr>";
        }
    }
    $mystring .= "</table>";
    // echo print($arrayid)."||".$mystring;
    $response["data"] = array(
        'mystring' => $mystring,
        'myarray' => $arrayid
    );
    echo json_encode($response);
}
else if($tipe  == "getassettransactionlendrelation")
{
    $arrayid = array();
    $idtransac = $_POST['myidtransaction'];
    $sql = "select asset.id, asset.noasset, asset.name from transaction_lend_to_relation_log tdasl inner join asset on asset.id = tdasl.idasset where tdasl.idtransaksi = '$idtransac'";
    $res = $conn->query($sql);
    $mystring = "<table class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Name</th></tr>";
    if($res->num_rows >0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $arrayid[] = $r['id'];
            $mystring .= "<tr><td>".$r['noasset']."</td><td>".$r['name']."</td></tr>";
        }
    }
    $mystring .= "</table>";
    // echo print($arrayid)."||".$mystring;
    $response["data"] = array(
        'mystring' => $mystring,
        'myarray' => $arrayid
    );
    echo json_encode($response);
}
else if($tipe == "getassettransactionsale")
{
    $arrayid = array();
    $idtransac = $_POST['myidtransaction'];
    $sql = "select asset.id, asset.noasset, asset.name, tdasl.harga from transaction_sale_log tdasl inner join asset on asset.id = tdasl.idasset where tdasl.idtransaksi = '$idtransac'";
    $res = $conn->query($sql);
    $counter = 1;
    $mypricestring = "";
    $mystring = "<table class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Name</th></tr>";
    if($res->num_rows >0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $arrayid[] = $r['id'];
            
            $mystring .= "<tr><td>".$r['noasset']."</td><td>".$r['name']."</td></tr>";
            $mypricestring .="<label><b>".$counter . "</b>." . $r['name'] .
            "</label> <input type = 'text' class = 'form-control' id = 'priceedit" .
            $r['id'] . "' placeholder = 'Place price here' value = '". $r['harga']."'> <br><br>";
            $counter++;
        }
    }
    $mystring .= "</table>";
    // echo print($arrayid)."||".$mystring;
    $response["data"] = array(
        'mystring' => $mystring,
        'myarray' => $arrayid,
        'myprice' => $mypricestring
    );
    echo json_encode($response);
}
else if($tipe  == "getassettransactiondispose")
{
    $arrayid = array();
    $idtransac = $_POST['myidtransaction'];
    $sql = "select asset.id, asset.noasset, asset.name from transaction_dispose_log tdasl inner join asset on asset.id = tdasl.idasset where tdasl.idtransaksi = '$idtransac'";
    $res = $conn->query($sql);
    $mystring = "<table class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Name</th></tr>";
    if($res->num_rows >0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $arrayid[] = $r['id'];
            $mystring .= "<tr><td>".$r['noasset']."</td><td>".$r['name']."</td></tr>";
        }
    }
    $mystring .= "</table>";
    // echo print($arrayid)."||".$mystring;
    $response["data"] = array(
        'mystring' => $mystring,
        'myarray' => $arrayid
    );
    echo json_encode($response);
}
else if($tipe == "getassettransactionlendotherdepartment")
{
    $arrayid = array();
    $idtransac = $_POST['myidtransaction'];
    $sql = "select asset.id, asset.noasset, asset.name from transaction_lend_to_department_log tdasl inner join asset on asset.id = tdasl.idasset where tdasl.idtransaksi = '$idtransac'";
    $res = $conn->query($sql);
    $mystring = "<table class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Name</th></tr>";
    if($res->num_rows >0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $arrayid[] = $r['id'];
            $mystring .= "<tr><td>".$r['noasset']."</td><td>".$r['name']."</td></tr>";
        }
    }
    $mystring .= "</table>";
    // echo print($arrayid)."||".$mystring;
    $response["data"] = array(
        'mystring' => $mystring,
        'myarray' => $arrayid
    );
    echo json_encode($response);
}
else if($tipe == "loadpicked")
{
    $myid = $_POST['idtransaction'];
    $where_like = [
        
        'noasset',
        'asset.name'
        
    ];
    
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
    inner join asset on asset.id = tdnal.idasset
    inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid'
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
        inner join asset on asset.id = tdnal.idasset
        inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
        inner join asset on asset.id = tdnal.idasset
        inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid'");
    } else {
        $query_data = mysqli_query($conn, "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
        inner join asset on asset.id = tdnal.idasset
        inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid'
         and ( asset.name LIKE '%$search%' 
        OR asset.noasset LIKE '%$search%' ) ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT tdnal.*, asset.name, asset.noasset, ksc.id as idcategory, ksc.category FROM transaction_displacement_new_asset_log tdnal 
        inner join asset on asset.id = tdnal.idasset
        inner join kategori_categorysubgroup ksc on ksc.id = asset.idcategory where idtransaksi = '$myid'
        and ( asset.name LIKE '%$search%' 
       OR asset.noasset LIKE '%$search%' )");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
       
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
                "<input type = 'checkbox' id = 'check_".$row['id']."' class = 'checkboxasset' checked>",
                "<label id ='noasset".$row['id']."'>".$row['noasset']."</label>",
                "<label id ='name".$row['id']."'>".$row['name']."</label>"."<input type = 'hidden' value = '".$row['idcategory']."' id = 'idcategorysummary'>"."<input type = 'hidden' value = '".$row['category']."' id = 'namecategorysummary'>"
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