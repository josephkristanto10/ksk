<?php
require '../connection.php';
session_start();
$myses = $_SESSION['idsister'];
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'id',
        'branch',
        'room',
        'nik',
        'nama',
        'start_date',
        'due_date',
        'approval',
        'status'
        
    ];
    
    $response = $_REQUEST;
    $start    = $response['start'];
    $length   = $response['length'];
    $order    = $where_like[$response['order'][0]['column']];
    $dir      = $response['order'][0]['dir'];
    $search   = $response['search']['value'];
    
    $total_data = mysqli_query($conn, 
    
    "select tltp.*, lbranch.branch, lbranchroom.branch as branchroom, karyawan.nama, karyawan.email, rank.rank, lroom.room , asset.idgroup, asset.idsubgroup, asset.idcategory  FROM transaction_lend_to_personal tltp
    inner join location_setup_sister_branch lbranchsetup on lbranchsetup.idbranch = tltp.idbranch
    inner join location_branch lbranch on lbranch.idbranch = lbranchsetup.idbranch 
    inner join location_branch lbranchroom on lbranchroom.idbranch = lbranchsetup.idbranch 
    inner join karyawan on karyawan.nik = tltp.nik
        inner join rank on rank.id = karyawan.idrank
    inner join location_room lroom on lroom.id = tltp.room
    inner join transaction_lend_to_personal_log tlotpl on tlotpl.idtransaksi =  tltp.id
    inner join asset on asset.id = tlotpl.idasset   
    where lbranchsetup.idsistercompany = '$myses' group by tltp.id
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "select tltp.*, lbranch.branch, lbranchroom.branch as branchroom, karyawan.nama, karyawan.email, rank.rank, lroom.room , asset.idgroup, asset.idsubgroup, asset.idcategory  FROM transaction_lend_to_personal tltp
        inner join location_setup_sister_branch lbranchsetup on lbranchsetup.idbranch = tltp.idbranch
        inner join location_branch lbranch on lbranch.idbranch = lbranchsetup.idbranch 
        inner join location_branch lbranchroom on lbranchroom.idbranch = lbranchsetup.idbranch 
        inner join karyawan on karyawan.nik = tltp.nik
            inner join rank on rank.id = karyawan.idrank
        inner join location_room lroom on lroom.id = tltp.room
        inner join transaction_lend_to_personal_log tlotpl on tlotpl.idtransaksi =  tltp.id
        inner join asset on asset.id = tlotpl.idasset   
        where lbranchsetup.idsistercompany = '$myses'  group by tltp.id ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select tltp.*, lbranch.branch, lbranchroom.branch as branchroom, karyawan.nama, karyawan.email, rank.rank, lroom.room , asset.idgroup, asset.idsubgroup, asset.idcategory  FROM transaction_lend_to_personal tltp
        inner join location_setup_sister_branch lbranchsetup on lbranchsetup.idbranch = tltp.idbranch
        inner join location_branch lbranch on lbranch.idbranch = lbranchsetup.idbranch 
        inner join location_branch lbranchroom on lbranchroom.idbranch = lbranchsetup.idbranch 
        inner join karyawan on karyawan.nik = tltp.nik
            inner join rank on rank.id = karyawan.idrank
        inner join location_room lroom on lroom.id = tltp.room
        inner join transaction_lend_to_personal_log tlotpl on tlotpl.idtransaksi =  tltp.id
        inner join asset on asset.id = tlotpl.idasset   
        where lbranchsetup.idsistercompany = '$myses' group by tltp.id");
    } else {
        $query_data = mysqli_query($conn, "select tltp.*, lbranch.branch, lbranchroom.branch as branchroom, karyawan.nama, karyawan.email, rank.rank, lroom.room , asset.idgroup, asset.idsubgroup, asset.idcategory  FROM transaction_lend_to_personal tltp
        inner join location_setup_sister_branch lbranchsetup on lbranchsetup.idbranch = tltp.idbranch
        inner join location_branch lbranch on lbranch.idbranch = lbranchsetup.idbranch 
        inner join location_branch lbranchroom on lbranchroom.idbranch = lbranchsetup.idbranch 
        inner join karyawan on karyawan.nik = tltp.nik
            inner join rank on rank.id = karyawan.idrank
        inner join location_room lroom on lroom.id = tltp.room
        inner join transaction_lend_to_personal_log tlotpl on tlotpl.idtransaksi =  tltp.id
        inner join asset on asset.id = tlotpl.idasset   
        where lbranchsetup.idsistercompany = '$myses' and (
            tltp.notransaction LIKE '%$search%' 
        OR lbranch.branch LIKE '%$search%'
        OR karyawan.nama LIKE '%$search%'
        OR lroom.room LIKE '%$search%' 
        OR tltp.approval LIKE '%$search%'
        OR tltp.status LIKE '%$search%' ) group by tltp.id  ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "select tltp.*, lbranch.branch, lbranchroom.branch as branchroom, karyawan.nama, karyawan.email, rank.rank, lroom.room , asset.idgroup, asset.idsubgroup, asset.idcategory  FROM transaction_lend_to_personal tltp
        inner join location_setup_sister_branch lbranchsetup on lbranchsetup.idbranch = tltp.idbranch
        inner join location_branch lbranch on lbranch.idbranch = lbranchsetup.idbranch 
        inner join location_branch lbranchroom on lbranchroom.idbranch = lbranchsetup.idbranch 
        inner join karyawan on karyawan.nik = tltp.nik
            inner join rank on rank.id = karyawan.idrank
        inner join location_room lroom on lroom.id = tltp.room
        inner join transaction_lend_to_personal_log tlotpl on tlotpl.idtransaksi =  tltp.id
        inner join asset on asset.id = tlotpl.idasset  
        where lbranchsetup.idsistercompany = '$myses' and (
            tltp.notransaction LIKE '%$search%' 
        OR lbranch.branch LIKE '%$search%'
        OR karyawan.nama LIKE '%$search%'
        OR lroom.room LIKE '%$search%' 
        OR tltp.approval LIKE '%$search%'
        OR tltp.status LIKE '%$search%' ) group by tltp.id ");
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
                "<b><label id ='id".$row['id']."'  >".$row['id']."</label></b>",
                "<span class='pointer-element badge badge-success' id ='".$row['id']."' data-id='".$row['id']."'><i class='icon-plus3'></i></span>",
                "<b><label id ='statusapproval".$row['id']."'  >".$myapproval."</label></b>",
                "<label id ='mydate".$row['id']."'>".$row['mydate']."</label>",
                "<a href = '#myModalDetailTransaction' id = '".$row['id']."' onclick = openmodaldetailtransaction(this) data-toggle='modal'><label id ='notransaction".$row['id']."'>".$row['notransaction']."</label></a>",
                "<label id ='branch".$row['id']."'>".$row['branch']."</label>",
                "<label id ='room".$row['id']."'>".$row['room']."</label>",
                "<label id ='nik".$row['id']."'>".$row['nik']."</label>",
                "<label id ='namakaryawan".$row['id']."'>".$row['nama']."</label>",
                "<label id ='startdate".$row['id']."'>".$row['start_date']."</label>",
                "<label id ='duedate".$row['id']."'>".$row['due_date']."</label>".
                "<input type = 'hidden' id = 'category_".$row['id']."' value = '".$row['idcategory']."'>".
                "<input type = 'hidden' id = 'subgroup_".$row['id']."' value = '".$row['idsubgroup']."'>".
                "<input type = 'hidden' id = 'group_".$row['id']."' value = '".$row['idgroup']."'>".
                "<input type = 'hidden' id = 'branchroom_".$row['id']."' value = '".$row['idbranchroom']."'>".
                "<input type = 'hidden' id = 'idroom_".$row['id']."' value = '".$row['room']."'>"
                ."<input type = 'hidden' id = 'idbranchpersonel_".$row['id']."' value = '".$row['idbranch']."'>"
                ."<input type = 'hidden' id = 'iddepartment_".$row['id']."' value = '".$row['id_department']."'>",
                "<label id ='status".$row['id']."'>".$row['status']."</label>"
                ."<input type = 'hidden' id = 'email".$row['id']."' value = '".$row['email']."'>"
                ."<input type = 'hidden' id = 'rank".$row['id']."' value = '".$row['rank']."'>"
                ."<input type = 'hidden' id = 'branchroom".$row['id']."' value = '".$row['branchroom']."'>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#myModalEditTransactions"  data-toggle="modal" class="dropdown-item" id ="click-'.$row['id'].'"  onclick = "openmodaledits(this)"><i class="icon-check"></i>
                            Edit</a>
                        
                   
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

    $myselectedlist = $_POST['myselected'];
    $idsister = $myses;
    $mybranchpersonel = $_POST['mybranchpersonel'];
    $mydepartment = $_POST['mydepartment'];
    $myuser = $_POST['myuser'];
    $mybranchroom = $_POST['mybranchroom'];
    $myroom = $_POST['myroom'];
    $mystart = $_POST['mystart'];
    $myend = $_POST['myend'];
    date_default_timezone_set("Asia/Bangkok");
    $datestart=date_create($mystart);
    $dateend=date_create($myend);
    $convertstart = date_format($datestart,"Y-m-d");
    $convertend = date_format($dateend,"Y-m-d");
    $mydate = date("Y-m-d");
    $sql = "INSERT INTO `transaction_lend_to_personal`
    VALUES (NULL, 'TRX-0000', '$mydepartment', '$mybranchpersonel', '$myuser', '$mybranchroom', '$myroom', '$convertstart', '$convertend', 'pending', 'waiting', '$mydate');";
    $res = $conn->query($sql);
    $last_id = $conn->insert_id;
    for($i = 0 ;  $i < count($myselectedlist) ; $i++)
    {
        $sqlupdate  = "UPDATE asset set status_transaction = 'placed' where id = '".$myselectedlist[$i]."'";
        $resupdate =  $conn->query($sqlupdate);
        $sqls = "INSERT INTO `transaction_lend_to_personal_log` VALUES (NULL, '$last_id', '".$myselectedlist[$i]."')";
        $ress = $conn->query($sqls);
      
    }
    if(($conn -> affected_rows)>0)
    {
        echo "sukses";
    }
    else{
        echo "tidak";
    }
    // echo $sql;
}
else if($tipe == "edit")
{

    $myselectedlist = $_POST['myselected'];
    $idsister = $myses;
    $mybranchpersonel = $_POST['mybranchpersonel'];
    $mydepartment = $_POST['mydepartment'];
    $myuser = $_POST['myuser'];
    $mybranchroom = $_POST['mybranchroom'];
    $myroom = $_POST['myroom'];
    $mystart = $_POST['mystart'];
    $myend = $_POST['myend'];
    date_default_timezone_set("Asia/Bangkok");
    $datestart=date_create($mystart);
    $dateend=date_create($myend);
    $convertstart = date_format($datestart,"Y-m-d");
    $convertend = date_format($dateend,"Y-m-d");
    $mydate = date("Y-m-d");
    $mytransactions = $_POST['mytransactions'];

    $sql = "update transaction_lend_to_personal set id_department = '$mydepartment', idbranch = '$mybranchpersonel', nik = '$myuser', idbranchroom = '$mybranchroom', room = '$myroom' , start_date = '$convertstart', due_date = '$convertend' where id = '$mytransactions'";
    $res = $conn->query($sql);
    // echo $sql;
    $sql = "delete from transaction_lend_to_personal_log where idtransaksi = '$mytransactions'";
    $res = $conn->query($sql);

  

    for($i = 0 ; $i< count($myselectedlist); $i++)
    {
        $sql = "insert into transaction_lend_to_personal_log values(NULL, '$mytransactions', '".$myselectedlist[$i]."')";
        $ress = $conn->query($sql);
    }
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
else if($tipe == "getdetailtransaction")
{
    $idtransaction = $_POST['idtransaction'];
    $sql = "select tltp.*, asset.name as assetname, asset.noasset  from transaction_lend_to_personal_log tltp inner join asset on asset.id = tltp.idasset where idtransaksi = '$idtransaction'";
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
                $mystring .= "<div class = 'row'><div class = 'col-md-6'><input class = 'mycheckbox' type = 'checkbox' value = '".$r['id']."' > ".$r['name']."</div>";
                $mycounter = 2;
            }
            else{
                $mystring .= "<div class = 'col-md-6'><input class = 'mycheckbox' type = 'checkbox' value = '".$r['id']."' > ".$r['name']."</div></div><br>";
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