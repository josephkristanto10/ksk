<?php
require '../connection.php';
session_start();
$myses = $_SESSION['idsister'];
$tipe = $_POST['tipe'];
if($tipe == "load")
{
    $mychoice = $_POST['choice'];
    $where_like = [
        
        "mydate",
        'transactionreturn',
        "notransaction"
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $sql1 = "";
    if($mychoice == "personal")
    {
        $sql1 = "SELECT * FROM transaction_extension_personal tep 
        inner join transaction_lend_to_personal tltp on tep.transactionlend = tltp.id
        inner join location_setup_sister_branch lssb on tltp.idbranch = lssb.idbranch
        where lssb.idsistercompany = '$myses' group by tep.id ";
    }
    else if($mychoice == "department")
    {
        $sql1 = "SELECT * FROM transaction_extension_department ted
        inner join transaction_lend_to_department tltd on ted.transactionlend = tltd.id
        inner join location_setup_sister_branch lssb on tltd.idbranch = lssb.idbranch
        where lssb.idsistercompany = '$myses' group by ted.id  ";
    }
    else if($mychoice == "relation")
    {
        $sql1 = "SELECT * FROM transaction_extension_relation ter
        inner join transaction_lend_to_relation tltr on ter.transactionlend = tltr.id
        inner join location_setup_sister_branch lssb on tltr.idbranch = lssb.idbranch
        where lssb.idsistercompany = '$myses' group by ter.id ";
    }
    $total_data = mysqli_query($conn, 
    
    $sql1
    

);
    
    if(empty($search)) {

        $sql2 = "";
        $alldata = "";
        if($mychoice == "personal")
        {
            $alldata  = "SELECT * FROM transaction_extension_personal tep 
            inner join transaction_lend_to_personal tltp on tep.transactionlend = tltp.id
            inner join location_setup_sister_branch lssb on tltp.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' group by tep.id ";
            $sql2 = "SELECT * FROM transaction_extension_personal tep 
            inner join transaction_lend_to_personal tltp on tep.transactionlend = tltp.id
            inner join location_setup_sister_branch lssb on tltp.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' group by tep.id   ORDER BY $order $dir LIMIT $start, $length";
        }
        else if($mychoice == "department")
        {
            $alldata = "SELECT * FROM transaction_extension_department ted
            inner join transaction_lend_to_department tltd on ted.transactionlend = tltd.id
            inner join location_setup_sister_branch lssb on tltd.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' group by ted.id ";
            $sql2 = "SELECT * FROM transaction_extension_department ted
            inner join transaction_lend_to_department tltd on ted.transactionlend = tltd.id
            inner join location_setup_sister_branch lssb on tltd.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' group by ted.id   ORDER BY $order $dir LIMIT $start, $length";
            
        }
        else if($mychoice == "relation")
        {
            $alldata = "SELECT * FROM transaction_extension_relation ter
            inner join transaction_lend_to_relation tltr on ter.transactionlend = tltr.id
            inner join location_setup_sister_branch lssb on tltr.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' group by ter.id";

            $sql2 = "SELECT * FROM transaction_extension_relation ter
            inner join transaction_lend_to_relation tltr on ter.transactionlend = tltr.id
            inner join location_setup_sister_branch lssb on tltr.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' group by ter.id ORDER BY $order $dir LIMIT $start, $length";
        }
        $query_data = mysqli_query($conn, $sql2);
    
        $total_filtered = mysqli_query($conn, $alldata);
    } else {

        $sql3 = "";
        $alldata = "";
        if($mychoice == "personal")
        {
            $alldata  = "SELECT * FROM transaction_extension_personal tep 
            inner join transaction_lend_to_personal tltp on tep.transactionlend = tltp.id
            inner join location_setup_sister_branch lssb on tltp.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' and (
                tep.transactionreturn LIKE '%$search%' 
            OR tltp.notransaction LIKE '%$search%' )  group by tep.id ";
            $sql3 = "SELECT * FROM transaction_extension_personal tep 
            inner join transaction_lend_to_personal tltp on tep.transactionlend = tltp.id
            inner join location_setup_sister_branch lssb on tltp.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' and (
                tep.transactionreturn LIKE '%$search%' 
            OR tltp.notransaction LIKE '%$search%' )  group by tep.id  
            ORDER BY $order $dir LIMIT $start, $length";
        }
        else if($mychoice == "department")
        {
            $alldata = "SELECT * FROM transaction_extension_department ted
            inner join transaction_lend_to_department tltd on ted.transactionlend = tltd.id
            inner join location_setup_sister_branch lssb on tltd.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' and (
                ted.transactionreturn LIKE '%$search%' 
            OR tltd.notransaction LIKE '%$search%' ) group by ted.id " ;
            $sql3 = "SELECT * FROM transaction_extension_department ted
            inner join transaction_lend_to_department tltd on ted.transactionlend = tltd.id
            inner join location_setup_sister_branch lssb on tltd.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' and (
                ted.transactionreturn LIKE '%$search%' 
            OR tltd.notransaction LIKE '%$search%' ) group by ted.id  ORDER BY $order $dir LIMIT $start, $length";
            
        }
        else if($mychoice == "relation")
        {
            $alldata = "SELECT * FROM transaction_extension_relation ter
            inner join transaction_lend_to_relation tltr on ter.transactionlend = tltr.id
            inner join location_setup_sister_branch lssb on tltr.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' and (
                ter.transactionreturn LIKE '%$search%' 
            OR tltr.notransaction LIKE '%$search%' ) group by ter.id";

            $sql3 = "SELECT * FROM transaction_extension_relation ter
            inner join transaction_lend_to_relation tltr on ter.transactionlend = tltr.id
            inner join location_setup_sister_branch lssb on tltr.idbranch = lssb.idbranch
            where lssb.idsistercompany = '$myses' and (
                ter.transactionreturn LIKE '%$search%' 
            OR tltr.notransaction LIKE '%$search%' ) group by ter.id ORDER BY $order $dir LIMIT $start, $length";
        }
        $query_data = mysqli_query($conn, $sql3);
    
        $total_filtered = mysqli_query($conn, $alldata);
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $myapproval = "";
            if($row['status_approval_extension'] == "pending")
            {
                $myapproval = "<span style = 'color:#e37e02'><i class='mi-info'></i> &nbsp Pending </span>";
            }
            else if($row['status_approval_extension'] == "rejected")
            {
                $myapproval = "<span style = 'color:#e32702'><i class='mi-cancel'></i> &nbsp Rejected </span>";
            }
            else if($row['status_approval_extension'] == "accepted")
            {
                $myapproval = "<span style = 'color:#2aa602'><i class='mi-check-box'></i> &nbspAccepted </span>";
            }
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
     
                "<b><label id ='statusapproval".$row['id']."'  >".$myapproval."</label></b>",
                // "<a href = '#myModalDetailTransaction' id = '".$row['id']."' onclick = openmodaldetailtransaction(this) data-toggle='modal'><label id ='notransaction".$row['id']."'>".$row['transactionreturn']."</label></a>",
                "<label id ='notransactionreturn".$row['id']."'>".$row['transactionextension']."</label>",
                 "<label id ='notransactionlend".$row['id']."'>".$row['notransaction']."</label>",
                 "<label id ='due_date".$row['id']."'>".$row['due_date']."</label>",
                 "<label id ='add_date".$row['id']."'>".$row['add_date']."</label>",
                 "<label id ='extended_due_date".$row['id']."'>".$row['extended_due_date']."</label>"
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
            
        }
        echo $mycountasset."||".$mystring;
    }
    else
    {
        echo "";
    }

}
else if($tipe == "getdetailtransactionadd")
{
    $idtransaction = $_POST['idtransaction'];
    $mytrans = $_POST['mytransaction'];
    $sql = "";
    if($mytrans == "personal")
    {
        $sql = "select tltp.*, asset.name as assetname, asset.noasset  from transaction_lend_to_personal_log tltp inner join asset on asset.id = tltp.idasset where idtransaksi = '$idtransaction'";
    }
    else if($mytrans == "department")
    {
        $sql = "select tltd.*, asset.name as assetname, asset.noasset  from transaction_lend_to_department_log tltd inner join asset on asset.id = tltd.idasset where idtransaksi = '$idtransaction'";
    }
    else if($mytrans == "relation")
    {
        $sql = "select tltr.*, asset.name as assetname, asset.noasset  from transaction_lend_to_relation_log tltr inner join asset on asset.id = tltr.idasset where idtransaksi = '$idtransaction'";
    }

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
            if($mycounter == 1)
            {
                $mystring .= "<div class = 'row'><div class = 'col-md-6'><label style = 'display:block;float:left;heigth:100px;font-size:12pt;' ><b>$mynumber. </b> &nbsp </label><label style = 'display:block;float:left' >".$r['assetname']."<br>".$r['noasset']."</label></div>";
                $mycounter = 2;
            }
            else{
                $mystring .= "<div class = 'col-md-6'><label style = 'display:block;float:left;heigth:100px;font-size:12pt;' ><b>$mynumber. </b> &nbsp </label><label style = 'display:block;float:left' >".$r['assetname']."<br>".$r['noasset']."</label></div></div><br>";
                $mycounter = 1;
            }
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
else if($tipe == "gettransactionlend")
{
    $mytrans = $_POST['transaction'];
    $sql = "";
    if($mytrans == "personal")
    {
        $sql = 'select * from transaction_lend_to_personal tltp where status != "returned" and approval = "approved"';
    }
    else if($mytrans == "department")
    {
        $sql = 'select * from transaction_lend_to_department tltd where status != "returned" and approval = "approved"';
    }
    else if($mytrans == "relation")
    {
        $sql = 'select * from transaction_lend_to_relation tltr where status != "returned" and approval = "approved"';
    }
 
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."'> ".$r['notransaction']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "";
    }
    
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
