<?php
require '../connection.php';
session_start();
$myses = $_SESSION['idsister'];
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'notransaction',
        'approval'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "SELECT tm.*, lroom.room , lscfrom.name as sisterfrom, lscto.name as sisterto, lbranchfrom.branch as branchfrom, lbranchfrom.branch as branchto FROM transaction_mutation tm
    inner join location_sister_company lscfrom on lscfrom.id = tm.idsisterfrom
    inner join location_sister_company lscto on lscto.id = tm.idsisterto
    inner join location_room lroom on lroom.id = tm.idroomfrom
    inner join location_branch lbranchfrom on lbranchfrom.idbranch = tm.idbranchfrom
    inner join location_branch lbranchto on lbranchto.idbranch = tm.idbranchto
    where lscfrom.id = '$myses'
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT tm.*, lroom.room , lscfrom.name as sisterfrom, lscto.name as sisterto, lbranchfrom.branch as branchfrom, lbranchfrom.branch as branchto FROM transaction_mutation tm
        inner join location_sister_company lscfrom on lscfrom.id = tm.idsisterfrom
        inner join location_sister_company lscto on lscto.id = tm.idsisterto
        inner join location_room lroom on lroom.id = tm.idroomfrom
        inner join location_branch lbranchfrom on lbranchfrom.idbranch = tm.idbranchfrom
        inner join location_branch lbranchto on lbranchto.idbranch = tm.idbranchto
        where lscfrom.id = '$myses' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT * from transaction_dispose  where idsister = '$myses'");
    } else {
        $query_data = mysqli_query($conn, "SELECT tm.*, lroom.room , lscfrom.name as sisterfrom, lscto.name as sisterto, lbranchfrom.branch as branchfrom, lbranchfrom.branch as branchto FROM transaction_mutation tm
        inner join location_sister_company lscfrom on lscfrom.id = tm.idsisterfrom
        inner join location_sister_company lscto on lscto.id = tm.idsisterto
        inner join location_room lroom on lroom.id = tm.idroomfrom
        inner join location_branch lbranchfrom on lbranchfrom.idbranch = tm.idbranchfrom
        inner join location_branch lbranchto on lbranchto.idbranch = tm.idbranchto
        where lscfrom.id = '$myses' and (
            tm.notransaction LIKE '%$search%' 
            OR lbranchfrom.branch LIKE '%$search%'
            OR lbranchto.branch LIKE '%$search%'
            OR lroom.room LIKE '%$search%'
            OR lscfrom.name LIKE '%$search%'
            OR lscto.name LIKE '%$search%'
            OR tm.mydate LIKE '%$search%'
        OR tm.mydate LIKE '%$search%'
        OR tm.approval LIKE '%$search%' )  ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT tm.*, lroom.room , lscfrom.name as sisterfrom, lscto.name as sisterto, lbranchfrom.branch as branchfrom, lbranchfrom.branch as branchto FROM transaction_mutation tm
        inner join location_sister_company lscfrom on lscfrom.id = tm.idsisterfrom
        inner join location_sister_company lscto on lscto.id = tm.idsisterto
        inner join location_room lroom on lroom.id = tm.idroomfrom
        inner join location_branch lbranchfrom on lbranchfrom.idbranch = tm.idbranchfrom
        inner join location_branch lbranchto on lbranchto.idbranch = tm.idbranchto
        where lscfrom.id = '$myses' and (
            tm.notransaction LIKE '%$search%' 
            OR lbranchfrom.branch LIKE '%$search%'
            OR lbranchto.branch LIKE '%$search%'
            OR lroom.room LIKE '%$search%'
            OR lscfrom.name LIKE '%$search%'
            OR lscto.name LIKE '%$search%'
            OR tm.mydate LIKE '%$search%'
        OR tm.mydate LIKE '%$search%'
        OR tm.approval LIKE '%$search%' )");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $myapproval = "";
            if($row['approval'] == "pending")
            {
                $myapproval = "<span style = 'color:#e37e02'><i class='mi-info'></i> &nbsp Pending </span>";
            }
            else if($row['approval'] == "rejected")
            {
                $myapproval = "<span style = 'color:#e32702'><i class='mi-cancel'></i> &nbsp Rejected </span>";
            }
            else if($row['approval'] == "accepted")
            {
                $myapproval = "<span style = 'color:#2aa602'><i class='mi-check-box'></i> &nbspAccepted </span>";
            }
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
                "<b><label id ='statusapproval".$row['id']."'  >".$myapproval."</label></b>",
                "<label id ='mydate".$row['id']."'>".$row['mydate']."</label>",
                "<a href = '#myModalDetailTransaction' id = '".$row['id']."' onclick = openmodaldetailtransaction(this) data-toggle='modal'><label id ='notransaction".$row['id']."'>".$row['notransaction']."</label></a>",
                "<label id ='sisterfrom".$row['id']."'>".$row['sisterfrom']."</label>",
                "<label id ='branchfrom".$row['id']."'>".$row['branchfrom']."</label>",
                "<label id ='room".$row['id']."'>".$row['room']."</label>",
                "<label id ='sisterto".$row['id']."'>".$row['sisterto']."</label>",
                "<label id ='branchto".$row['id']."'>".$row['branchto']."</label>"
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
else if($tipe == "getassetdesc")
{
    $assetid = $_POST['assetid'];
    $sql = "select asset.id, asset.noasset, asset.name, c.name as conditions, ic.initial_condition from asset
     inner join conditions c on c.id = asset.idcondition 
    inner join initial_condition ic on ic.id = asset.idinitialcondition where asset.id = '$assetid'";
    $res = $conn->query($sql);
    $row = mysqli_fetch_array($res);
    
    $mystring = $row['noasset']."~~".$row['name']."~~".$row['conditions']."~~".$row['initial_condition'];
    echo $mystring;
}
else if($tipe == "getassetlist")
{
    $idgroup = $_POST['idgroup'];
    $sql = "select asset.id, asset.noasset, asset.name from asset where asset.idgroup = '$idgroup' and asset.idsistercompany = '$myses'";
    $res = $conn->query($sql);
    // $row = mysqli_fetch_array($res);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."'> ".$r['noasset']."-".$r['name']."</option>";
        }
    }
    echo $mystring;
}
else if($tipe == "getdetailuser")
{
    $iduser = $_POST['iduser'];
    $sql = "select karyawan.*, rank.rank from karyawan inner join rank on rank.id = karyawan.idrank where nik = '$iduser' ";
    $res = $conn->query($sql);
    $row = mysqli_fetch_array($res);
    $mystring = $row['nik']."~~".$row['nama']."~~".$row['email']."~~".$row['rank'];
    echo $mystring;
}
else if($tipe == "getuser")
{
    $idbranch = $_POST['idbranch'];
    $iddepartment = $_POST['iddepartment'];
    $sql = "select * from karyawan where idbranch = '$idbranch' and iddepartment = '$iddepartment'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        $myuser = "";
        while($r = mysqli_fetch_array($res))
        {
          
            $mystring .= "<option value = '".$r['nik']."'> ".$r['nik']."-".$r['nama']."</option>";
        }
        echo $mystring;
    }
    else
    {
        echo "none";
    }
 

}
else if($tipe == "gettemplatecategory")
{
    $idcategory = $_POST['idcategory'];
    $sql = "select template.id, template.template from kategori_categorysubgroup kcs inner join template on template.id = kcs.idtemplate where kcs.id = '$idcategory'";
    $res = $conn->query($sql);
    $row = mysqli_fetch_array($res);
    
    if($res->num_rows>0)
    {
        $idtemplate = $row['id'];
        $nametemplate = $row['template'];
        echo $idtemplate."~~~";
        echo $nametemplate."~~~";
        $sqls = "select folder_custom.*, custom_to_template.id as idquestion  from custom_to_template inner join folder_custom on folder_custom.id = custom_to_template.idcustom where custom_to_template.idtemplate = '$idtemplate'"; 
        $ress = $conn->query($sqls);
        // echo $sqls;
        if($ress -> num_rows>0)
        {
            $mystring = "";
            $mycode = "";
            $myindex = 0 ;
            while($r = mysqli_fetch_array($ress))
            {
                if($myindex == 0)
                {
                    $mycode .= $r['id'];
                }
                else{
                    $mycode .= ",".$r['id'];
                }
                $myindex++;
               
                $mystring .=  '
                <div class="row">
                  <div class="col-md-12">
                        <div class="form-group">
                            <label>'.$r['name'].' </label>
                            <input type="text" name="custom'.$r['idquestion'].'" placeholder="Enter '.$r['name'].'" class="form-control required" id = "startwarranty"><br>
                        </div>
                    </div>
                </div>';
            }
            echo $mycode."~~".$mystring;
        }
        else{
            echo "none";
        }
    }
    else{
        echo "another";
    }

}
else if($tipe == "getallanswer")
{

    $idasset = $_POST['idassets'];
    $sql = "select folder_custom.name as namequestion, custom_template_answer.answer from custom_template_answer 
    inner join custom_to_template on custom_to_template.id = custom_template_answer.id_custom_to_template
    inner join folder_custom on folder_custom.id = custom_to_template.idcustom
    where custom_template_answer.idasset = '$idasset'";
  
    $res = $conn->query($sql);
    if($res -> num_rows>0)
    {
        // echo $sql;
        $mystring = "";
        while($r = mysqli_fetch_array($res))
        {
        
            $mystring .=  '
            <div class="row">
              <div class="col-md-12">
                    <div class="form-group">
                        <label>'.$r['namequestion'].' </label><br>
                        <b><label>'.$r['answer'].'</label></b>
                    </div>
                </div>
            </div>';
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
else if($tipe == "getcustomquestion")
{
    $idtemplate = $_POST['idtemplate'];
    $sql = "select folder_custom.*, custom_to_template.id as idquestion  from custom_to_template inner join folder_custom on folder_custom.id = custom_to_template.idcustom where custom_to_template.idtemplate = '$idtemplate'"; 
    $res = $conn->query($sql);
    if($res -> num_rows>0)
    {
        $mystring = "";
        $mycode = "";
        $myindex = 0 ;
        while($r = mysqli_fetch_array($res))
        {
            if($myindex == 0)
            {
                $mycode .= $r['id'];
            }
            else{
                $mycode .= ",".$r['id'];
            }
            $myindex++;
           
            $mystring .=  '
            <div class="row">
              <div class="col-md-12">
                    <div class="form-group">
                        <label>'.$r['name'].' </label>
                        <input type="text" name="custom'.$r['idquestion'].'" placeholder="Enter '.$r['name'].'" class="form-control required" id = "startwarranty"><br>
                    </div>
                </div>
            </div>';
        }
        echo $mycode."~~".$mystring;
    }
    else{
        echo "none";
    }

}
else if($tipe == "getroom")
{
    $idbranch = $_POST['idbranch'];
    $sql = "SELECT lroom.* FROM location_room lroom 
    inner join location_setup_building_floor lsbf on lsbf.idlocationsetupbuildingfloor = lroom.idsetupbuildingfloor
    inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding
    inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch
    inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
    where lbranch.idbranch = '$idbranch'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."'> ".$r['room']."</option>";
        }
    }
    echo $mystring;
}

else if($tipe == "add"){

   
    $mybranchfrom = $_POST['mybranchfrom'];
    $myroom = $_POST['myroom'];
    $mysisterto = $_POST['mysisterto'];
    $mybranchto = $_POST['mybranchto'];
    $myselectedlist = $_POST['myselected'];
    date_default_timezone_set("Asia/Bangkok");
    $mydate = date("Y-m-d");
    $sql = "INSERT INTO `transaction_mutation` VALUES (NULL,'$myses','$mybranchfrom','$myroom','$mysisterto','$mybranchto', '$mydate', 'TRX-11111', 'pending')";
    $res = $conn->query($sql);
    $last_id = $conn->insert_id;
    for($i = 0 ;  $i < count($myselectedlist) ; $i++)
    {
        $sqlupdate  = "UPDATE asset set status_transaction = 'placed' where id = '".$myselectedlist[$i]."'";
        $resupdate =  $conn->query($sqlupdate);
        $sqls = "INSERT INTO `transaction_mutation_log` VALUES (NULL, '$last_id', '".$myselectedlist[$i]."')";
        $ress = $conn->query($sqls);
      
    }
    // echo $sql;
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
    // echo $sql;
}
else if($tipe == "changedata")
{
    $id  = $_POST['myid'];
    $idsister = $_SESSION['idsister'];
    $group = $_POST['group'];
    $subgroup = $_POST['subgroup'];
    $category = $_POST['category'];
    $initialcondition = $_POST['initialcondition'];
    $condition = $_POST['condition'];
    $noasset = $_POST['noasset'];
    $name = $_POST['name'];
    $sql = "update asset set 
           idsistercompany = '".$idsister."', 
           idgroup = '".$group."', 
           idsubgroup = '".$subgroup."',
           idcategory = '".$category."',
           idinitialcondition = '".$initialcondition."',
           idcondition = '".$condition."',
           noasset = '".$noasset."',
           name = '".$name."' 
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
    $sql = "update asset set status = '".$stat."' where id = '".$myid."'";
    $res = $conn->query($sql);
}
else if($tipe == "getassetdesc")
{
    $assetid = $_POST['assetid'];
    $sql = "select asset.id, asset.noasset, asset.name, c.name as conditions, ic.initial_condition from asset
     inner join conditions c on c.id = asset.idcondition 
    inner join initial_condition ic on ic.id = asset.idinitialcondition where asset.id = '$assetid'";
    $res = $conn->query($sql);
    $row = mysqli_fetch_array($res);
    
    $mystring = $row['noasset']."~~".$row['name']."~~".$row['conditions']."~~".$row['initial_condition'];
    echo $mystring;
}
else if($tipe == "getassetlist")
{
    $idgroup = $_POST['idgroup'];
    $sql = "select asset.id, asset.noasset, asset.name from asset where asset.idgroup = '$idgroup' and asset.idsistercompany = '$myses'";
    $res = $conn->query($sql);
    // $row = mysqli_fetch_array($res);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."'> ".$r['noasset']."-".$r['name']."</option>";
        }
    }
    echo $mystring;
}
else if($tipe == "getroom")
{
    $idbranch = $_POST['idbranch'];
    $sql = "SELECT lroom.* FROM location_room lroom 
    inner join location_setup_building_floor lsbf on lsbf.idlocationsetupbuildingfloor = lroom.idsetupbuildingfloor
    inner join location_building lbuilding on lbuilding.id = lsbf.idbuilding
    inner join location_setup_sister_branch lssb on lssb.idsetupsisterbranch = lbuilding.idsetupsisterbranch
    inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch
    where lbranch.idbranch = '$idbranch'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."'> ".$r['room']."</option>";
        }
    }
    echo $mystring;
}
else if($tipe =="getbranch"){
    $idsister = $_POST['idsister'];
    $sql = "select lbranch.idbranch, lbranch.branch from location_setup_sister_branch lssb 
    inner join location_branch lbranch on lssb.idbranch=lbranch.idbranch where lssb.idsistercompany = '$idsister'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['idbranch']."'> ".$r['branch']."</option>";
        }
    }
    echo $mystring;
}
else if($tipe == "getdetailtransaction")
{
    $idtransaction = $_POST['idtransaction'];
    $sql = "select td.*, asset.name as assetname, asset.noasset  from transaction_mutation_log td inner join asset on asset.id = td.idasset where idtransaksi = '$idtransaction'";
    $res = $conn->query($sql);
    $mystring = "";
    $mycountasset = 0;
    $mynumber = 1;
    if($res->num_rows>0)
    {
        $mycounter = 1;
        while($r = mysqli_fetch_array($res))
        {
            $mycountasset += 1;
            $mystring .= "<div class = 'row' style = 'margin-left:5px;'><label style = 'display:block;float:left;heigth:100px;font-size:12pt;' ><b>$mynumber. </b> &nbsp </label><label style = 'display:block;float:left' >".$r['assetname']."<br>".$r['noasset']."</label></div><br>";
            $mynumber ++;
            
        }
        echo $mycountasset."||".$mystring;
    }
    else
    {
        echo "";
    }

}
else if($tipe == "getasset")
{
    $idcategory = $_POST['idcategory'];
    $sql =  "select * from asset where idcategory = '$idcategory' and status_transaction = 'placed'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res->num_rows>0)
    {
        $mycounter = 1;
        while($r = mysqli_fetch_array($res))
        {
            if($mycounter == 1)
            {
                $mystring .= "<div class = 'row'><div class = 'col-md-6'><input class = 'mycheckbox' type = 'checkbox' value = '".$r['id']."-".$r['name']."' > ".$r['name']."</div>";
                $mycounter = 2;
            }
            else{
                $mystring .= "<div class = 'col-md-6'><input class = 'mycheckbox' type = 'checkbox' value = '".$r['id']."-".$r['name']."' > ".$r['name']."</div></div><br>";
                $mycounter = 1;
            }
            
        }
        echo $mystring;
    }
    else
    {
        echo "";
    }
   

}
else if($tipe == "getsubgroup")
{
    $idgroup = $_POST['idgroup'];
    $sql = "SELECT ks.* from kategori_subgroup ks inner join kategori_asset ka on ka.id = ks.idkategoriaset
     where ka.id = '$idgroup'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."'> ".$r['subgroup']."</option>";
        }
    }
    echo $mystring;
}
else if($tipe == "getcategory")
{
    $idsubgroup = $_POST['idsubgroup'];
    $sql = "SELECT kcs.* from kategori_categorysubgroup kcs 
    where kcs.idsubgroup = '$idsubgroup'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."'> ".$r['category']."</option>";
        }
    }
    echo $mystring;
}
?>
