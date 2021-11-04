<?php
require '../connection.php';
session_start();
$tipe = $_POST['tipe'];
if($tipe == "load")
{

    $where_like = [
        'id',
        '',
        'noasset',
        'name',
        'initial_condition',
        'conditions',
        'groupname',
        'subgroupname',
        'categoryname',
        'status_transaction',
        'status'
        
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
    inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
    inner join kategori_subgroup ks on ks.id = kc.idsubgroup
    inner join kategori_asset ka on ka.id = ks.idkategoriaset
    inner join conditions c on c.id = asset.idcondition
    inner join initial_condition ic on ic.id = asset.idinitialcondition
    "

);
    
    if(empty($search)) {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
        inner join relation on relation.id = asset.purchase_from 
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join kategori_subgroup ks on ks.id = kc.idsubgroup
        inner join kategori_asset ka on ka.id = ks.idkategoriaset
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
        inner join relation on relation.id = asset.purchase_from 
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join kategori_subgroup ks on ks.id = kc.idsubgroup
        inner join kategori_asset ka on ka.id = ks.idkategoriaset
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition");
    } else {
        $query_data = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
        inner join relation on relation.id = asset.purchase_from 
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join kategori_subgroup ks on ks.id = kc.idsubgroup
        inner join kategori_asset ka on ka.id = ks.idkategoriaset
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition  
        WHERE ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%' ORDER BY $order $dir LIMIT $start, $length");
    
        $total_filtered = mysqli_query($conn, "SELECT ka.nama as groupname, ks.subgroup as subgroupname, kc.category as categoryname, ic.initial_condition, c.name as conditions, relation.company as myrelation, asset.* FROM `asset`
        inner join relation on relation.id = asset.purchase_from 
        inner join kategori_categorysubgroup kc on kc.id = asset.idcategory
        inner join kategori_subgroup ks on ks.id = kc.idsubgroup
        inner join kategori_asset ka on ka.id = ks.idkategoriaset
        inner join conditions c on c.id = asset.idcondition
        inner join initial_condition ic on ic.id = asset.idinitialcondition  
        WHERE ka.nama LIKE '%$search%' 
        OR ks.subgroup LIKE '%$search%'
        OR kc.category LIKE '%$search%'
        OR ic.initial_condition LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR asset.noasset LIKE '%$search%'
        OR asset.name LIKE '%$search%'
        OR asset.status LIKE '%$search%'");
    }
    
    $response['data'] = [];
    
    if($query_data) {
        while($row = mysqli_fetch_assoc($query_data)) {
            $mystats = "";
            $myinfo = "";
            if($row['status_transaction'] == "newasset")
             { $myinfo = '<i class="mi-info" style = "color:#e37e02;"></i> &nbsp';}
            if($row['status'] == "Active")
            {
                $myactionsetto = "InActive";
                $mystats = '<span class="badge badge-success">Active</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['id']."-".$myactionsetto."')><i class='icon-cross'></i>
                Set InActive</a>'";
            }
            else
            {
                $myactionsetto = "Active";
                $mystats = '<span class="badge badge-danger">InActive</span>';
                $myaction = "<a class='dropdown-item' onclick = setstatus('".$row['id']."-".$myactionsetto."')><i class='icon-check'></i>
                Set Active</a>'";
            }
            $postingdate = date_format(date_create($row['posting_date']), "d-m-Y");
            $startdate = date_format(date_create($row['start_date']), "d-m-Y");
            $enddate = date_format(date_create($row['end_date']), "d-m-Y");
            // $myrelation = str_replace( " ", ' ', $row['myrelation'] ); 
            $response['data'][] = [
                "<label id ='idasset".$row['id']."'>".$row['id']."</label>",
                "<a href= '#myModalDisplay'  data-toggle='modal'><span class='pointer-element badge badge-success' id ='".$row['id']."' onclick = 'openmodaldisplay(this)'  data-id='".$row['id']."'><i class='icon-plus3'></i></span></a>",
                "<label id ='noasset".$row['id']."'>".$row['noasset']."</label>",
                "<label id ='name".$row['id']."'> $myinfo".$row['name']."</label>",
                "<label id ='initial".$row['id']."'>".$row['initial_condition']."</label>",
                "<label id ='condition".$row['id']."'>".$row['conditions']."</label>",
                "<label id ='group".$row['id']."'>".$row['groupname']."</label>",
                "<label id ='subgroup".$row['id']."'>".$row['subgroupname']."</label>",
                "<label id ='category".$row['id']."'>".$row['categoryname']."</label>",
                "<label id ='mystatustransaction".$row['id']."'>".$row['status_transaction']."</label>",
                "<label id ='status".$row['id']."'>".$mystats."</label>"
                ."<input type = 'hidden' id = 'nopo".$row['id']."' value = '".$row['noPo']."'>"
                ."<input type = 'hidden' id = 'relation".$row['id']."'  value = '".$row['myrelation']."'>"
                ."<input type = 'hidden' id = 'postingdate".$row['id']."'  value = '".$postingdate."'>"
                ."<input type = 'hidden' id = 'postingdateraw".$row['id']."'  value = '".$row['posting_date']."'>"
                ."<input type = 'hidden' id = 'purchaseprice".$row['id']."'  value = '".$row['purchase_price']."'>"
                ."<input type = 'hidden' id = 'ppn".$row['id']."'  value = '".$row['ppn']."'>"
                ."<input type = 'hidden' id = 'totalpurchaseprice".$row['id']."'  value = '".$row['total_purchase_price']."'>"
                ."<input type = 'hidden' id = 'economical".$row['id']."'  value = '".$row['economical']."'>"
                ."<input type = 'hidden' id = 'costpermonth".$row['id']."'  value = '".$row['cost_per_month']."'>"
                ."<input type = 'hidden' id = 'startdate".$row['id']."'  value = '".$startdate."'>"
                ."<input type = 'hidden' id = 'enddate".$row['id']."'  value = '".$enddate."'>"
                ."<input type = 'hidden' id = 'totalmonth".$row['id']."'  value = '".$row['totalmonth']."'>"
                ."<input type = 'hidden' id = 'image".$row['id']."'  value = '".$row['image']."'>",
                ' <div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>
    
                    <div class="dropdown-menu dropdown-menu-right">
                      
                        
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
    // <a href="#myModaledit" data-toggle="modal" class="dropdown-item" id ="click-'.$row['id'].'-'.$row['idgroup'].'-'.$row['idsubgroup'].'-'.$row['idcategory'].'-'.$row['idinitialcondition'].'-'.$row['idcondition'].'"  onclick = "openmodaledit(this)"><i class="icon-check"></i>
    // </a>
    echo json_encode($response);
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
else if($tipe == "addassetform")
{
 
    $statuspostingdate = "no";
    $date1= date_create($_POST['postingdate']);
   
    $date2=date_create(date("Y-m-d"));
    $diff=date_diff($date1,$date2);
    $perbedaan =  $diff->format("%m");
    if($perbedaan < 0)
    {
        $perbedaan = 0;
    }
    if(isset($_POST['statuspostingdate']))
    {
        $perbedaan+=1;
        $statuspostingdate =  "yes";
    }
    $totalmonth = $perbedaan; 
    $noasset = $_POST['noasset'];
    $assetname = $_POST['name'];
    $group = $_POST['group'];
    $initialcondition = $_POST['initialcondition'];
    $subgroup = $_POST['subgroup'];
    $condition = $_POST['condition'];
    $category = $_POST['category'];
    $nopo = $_POST['nopo'];
    $relation = $_POST['relation'];
    $postingdate = date_format(date_create($_POST['postingdate']), "Y-m-d");
    $purchaseprice = $_POST['purchaseprice'];
    $ppn = $_POST['ppn'];
    $totalpurchaseprice = $_POST['totalpurchaseprice'];
    $costpermonth = $_POST['costpermonth'];
    $economicallifetime = $_POST['economicallifetime'];

    $startwarranty = date_format(date_create($_POST['startwarranty']), "Y-m-d");
    $endwarranty = date_format(date_create($_POST['endwarranty']), "Y-m-d");
    $template = $_POST['template'];
    
    $mystartwarranty = NULL;
    $myendwarranty = NULL;
    $myfile = "";
    if(isset($_POST['startwarranty']))
    {
        $mystartwarranty = $_POST['startwarranty'];
    }
    if(isset($_POST['endwarranty']))
    {
        $myendwarranty = $_POST['endwarranty'];
    }
    if(isset($_FILES['myfile']['tmp_name']))
    {
        if(!is_dir("../assets/attach/")) {
            mkdir("../assets/attach/");
        }
        
        // echo "test";
        // echo count($_POST['myfile']);
        $jumlah = count($_FILES['myfile']['tmp_name']);
        for($i = 0 ; $i < $jumlah;$i++)
        {
            $filename = "$noasset"."_".date("Y_m_d_H_i_s")."_".$_FILES['myfile']['name'][$i];
            // $filename = $_FILES['myfile']['name'][$i];
            if($i == 0 )
            {
                $myfile .= $filename;
            }
            else{
                $myfile .= ",".$filename;
            }
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], "../assets/attach/".$filename);
       
        }
        // $file = $_FILES['myfile']['tmp_name'];
    }
    // echo $myfile;
    $mysessionsistercompany = $_SESSION['idsister'];
    $sql = "INSERT into asset values(NULL, '$mysessionsistercompany', '$group', '$subgroup', '$category', '$initialcondition', 
    '$condition', '$template','$noasset', '$assetname','$nopo', '$relation', '$postingdate', '$statuspostingdate', '$totalmonth', '$purchaseprice', '$ppn', '$totalpurchaseprice',
    '$economicallifetime', '$costpermonth', '$mystartwarranty', '$myendwarranty', '$myfile', 'Active', 'newasset')";
    $res = $conn->query($sql);
    if(($conn -> affected_rows)>0)
    {
        $last_id = $conn->insert_id;
        if($_POST['idcustomquestion']!="" && $_POST['idcustomquestion']!="none")
        {
            $splitidcustom = explode(',', $_POST['idcustomquestion']);
            for($i = 0 ;$i < count($splitidcustom); $i++)
            {
                $currentid = $splitidcustom[$i];
                $currentvalue = $_POST['custom'.$currentid];
                $sqlinsertanswer = "INSERT into custom_template_answer values(NULL, '$currentid', '$last_id' , '$currentvalue')";
                $resinsertanswer = $conn->query($sqlinsertanswer);
            }
        }
        echo "sukses";

    }
    else{
        echo "tidak";
    }
    


}
else if($tipe == "add"){

    $idsister = $_SESSION['idsister'];
    $group = $_POST['group'];
    $subgroup = $_POST['subgroup'];
    $category = $_POST['category'];
    $initialcondition = $_POST['initialcondition'];
    $condition = $_POST['condition'];
    $noasset = $_POST['noasset'];
    $name = $_POST['name'];

    $sql = "INSERT into asset values(NULL,'".$idsister."', '".$group."', '".$subgroup."', '".$category."', '".$initialcondition."', '".$condition."', '".$noasset."', '".$name."', 'Active', NULL, NULL)";
    $res = $conn->query($sql);
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
else if($tipe == "getsubgroup")
{
    $getid = $_POST['idgroup'];
    $sql = "select ks.id, ks.subgroup from kategori_subgroup ks where ks.idkategoriaset = '".$getid."' and ks.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['subgroup']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
else if($tipe == "getcategory")
{
    $getid = $_POST['idsubgroup'];
    $sql = "select kcs.id, kcs.category from kategori_categorysubgroup kcs where kcs.idsubgroup = '".$getid."' and kcs.status = 'Active'";
    $res = $conn->query($sql);
    $mystring = "";
    if($res -> num_rows>0)
    {
        while($r = mysqli_fetch_array($res))
        {
            $mystring .= "<option value = '".$r['id']."' >".$r['category']."</option>";
        }
        echo $mystring;
    }
    else{
        echo "none";
    }
}
?>