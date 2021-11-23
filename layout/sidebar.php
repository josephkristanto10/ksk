<?php
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $myurl = $uriSegments[count($uriSegments)-1];
     
?>
<div class="page-content">
    <div class="sidebar sidebar-dark sidebar-main sidebar-fixed sidebar-expand-md">
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-left8"></i>
            </a>
            Navigation
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>
        <div class="sidebar-content">
            
            <div class="sidebar-user">
                <div class="card-body">
                    <div class="media">
                        

                        <div class="media-body">
                        <div class="sidebar-section sidebar-section-body user-menu-vertical text-center">
					<div class="card-img-actions d-inline-block">
						<img class="img-fluid rounded-circle" src="<?=$url;?>assets/myprofile.png" width="120" height="120" alt="">
					</div>
					<div class="sidebar-resize-hide position-relative mt-2">
                        <div class="cursor-pointer">
                            <h6 class="font-weight-semibold mb-0"><?=  $_SESSION['username'];?></h6>
                            <span class="d-block text-muted">Nexus Admin</span>
                        </div>
			    	</div>
				</div>
                        </div>

                       
                    </div>
                </div>
            </div>
            
            <!-- <div class="card card-sidebar-mobile"> -->
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    <!-- <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu"
                            title="Main"></i>
                    </li> -->
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link ">
                            <i class="icon-home4"></i>
                            <span>
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <!-- <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Asset</div> <i class="icon-menu"
                            title="Master"></i>
                    </li> -->
                    <li class="nav-item nav-item-submenu <?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" || $myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php" || $myurl == "masterfuel.php" || $myurl == "masterdrivingforce.php" || $myurl == "masterassets.php" || $myurl == "mastertemplate.php"|| $myurl == "mastercustomfield.php" ) ? " nav-item-open" : ''; ?>">
                        <a href="#" class="nav-link <?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" || $myurl == "masterfuel.php" || $myurl == "masterdrivingforce.php"|| $myurl == "masterassets.php" || $myurl == "mastertemplate.php" || $myurl == "mastercustomfield.php") ? " nav-item-open" : ''; ?>"><i class="icon-box "></i> <span>Asset</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" || $myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php" || $myurl == "masterfuel.php" || $myurl == "masterdrivingforce.php" || $myurl == "masterassets.php" || $myurl == "mastertemplate.php" || $myurl == "mastercustomfield.php") ? "display:block;" : ''; ?>">
                             <li class="nav-item"><a href="masterassets.php" class="nav-link <?php echo ($myurl == "masterassets.php"  ) ? " active" : ''; ?>">Assets</a>
                            <li class="nav-item nav-item-submenu <?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" ) ? " nav-item-open" : ''; ?>">
                                <a href="#" class="nav-link <?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" ) ? "active" : ''; ?>"> <span>Asset Group</span></a>
                                <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" ) ? "display:block;" : ''; ?>">
                                    <li class="nav-item" id = "masterkategoriassets"><a href = "masterkategoriassets.php" class="nav-link <?php echo ($myurl == "masterkategoriassets.php" ) ? "active" : ''; ?>">Group</a>
                                    </li>
                                    <li class="nav-item" id = "mastersubkategoriassets"><a href="mastersubkategoriassets.php" class="nav-link <?php echo ( $myurl == "mastersubkategoriassets.php"  ) ? "active" : ''; ?>">Sub
                                            Group</a></li>
                                    <li class="nav-item" id = "mastercategorysubgroup"><a href="mastercategorysubgroup.php"
                                            class="nav-link <?php echo ( $myurl == "mastercategorysubgroup.php" ) ? "active" : ''; ?>">Category</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu <?php echo ($myurl == "mastertemplate.php" || $myurl == "mastertemplate.php" || $myurl == "mastercustomfield.php"   ) ? " nav-item-open" : ''; ?>">
                                <a href="#" class="nav-link <?php echo ($myurl == "mastertemplate.php" || $myurl == "mastertemplate.php" || $myurl == "mastercustomfield.php"  ) ? " active" : ''; ?>"> <span>Asset Template</span></a>

                                <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "mastertemplate.php"  || $myurl == "mastercustomfield.php"  ) ? " display:block;" : ''; ?>">
                                <li class="nav-item" id = "mastertemplate"><a href="mastertemplate.php" class="nav-link <?php echo ($myurl == "mastertemplate.php"  ) ? " active" : ''; ?>">Template List</a>
                                    </li>
                                    <li class="nav-item" id = "mastercustomfield"><a href="mastercustomfield.php" class="nav-link <?php echo ($myurl == "mastercustomfield.php"  ) ? " active" : ''; ?>">Custom Field</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu <?php echo ($myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php"  ) ? " nav-item-open" : ''; ?>">
                                <a href="#" class="nav-link <?php echo ($myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php"  ) ? " active" : ''; ?>"> <span>Condition</span></a>
                                <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php"  ) ? " display:block;" : ''; ?>">
                                    <li class="nav-item" id = "masterinitialcondition"><a class="nav-link <?php echo ($myurl == "masterinitialcondition.php"  ) ? " active" : ''; ?>" href="masterinitialcondition.php">Initial
                                            Condition</a></li>
                                    <li class="nav-item"  id = "mastercondition"><a href="mastercondition.php" class="nav-link <?php echo ($myurl == "mastercondition.php"  ) ? " active" : ''; ?>">Condition</a>
                                    </li>

                                </ul>
                            </li>
                          
                           
                            
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Transaction -->
                    <!-- <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Transaction</div> <i class="icon-menu"
                            title="Master"></i>
                    </li> -->
                    <li  class="nav-item nav-item-submenu  <?php echo ($myurl == "master_transaction_disp_new_asset.php" ||$myurl == "master_transaction_disp_department.php" || $myurl == "master_transaction_disp_department_branch.php" || $myurl == "master_transaction_lend_personel.php" || $myurl == "master_transaction_lend_relation.php" || $myurl == "master_transaction_lend_other_branch.php" || $myurl == "master_transaction_lend_return.php" || $myurl == "master_transaction_lend_extension.php"  || $myurl == "master_transaction_sale.php"  || $myurl == "master_transaction_mutation.php" || $myurl == "master_transaction_dispose.php"  ) ? " nav-item-open" : ''; ?>">
                        <a href="#" class="nav-link <?php echo ($myurl == "master_transaction_disp_new_asset.php" ||$myurl == "master_transaction_disp_department.php" || $myurl == "master_transaction_disp_department_branch.php" || $myurl == "master_transaction_lend_personel.php" || $myurl == "master_transaction_lend_relation.php"  || $myurl == "master_transaction_lend_other_branch.php" || $myurl == "master_transaction_lend_return.php"  || $myurl == "master_transaction_lend_extension.php" || $myurl == "master_transaction_sale.php" || $myurl == "master_transaction_mutation.php"  || $myurl == "master_transaction_dispose.php" ) ? " active" : ''; ?>"> <i class="mi-import-export "></i><span>Transaction</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "master_transaction_disp_new_asset.php" ||$myurl == "master_transaction_disp_department.php" || $myurl == "master_transaction_disp_department_branch.php" || $myurl == "master_transaction_lend_personel.php"  || $myurl == "master_transaction_lend_relation.php" || $myurl == "master_transaction_lend_other_branch.php" || $myurl == "master_transaction_lend_extension.php" || $myurl == "master_transaction_lend_return.php" || $myurl == "master_transaction_sale.php" || $myurl == "master_transaction_mutation.php"  || $myurl == "master_transaction_dispose.php"  ) ? " display:block;" : ''; ?>">
                        <li class="nav-item" id = "master_transaction_disp_new_asset"><a href="master_transaction_disp_new_asset.php" class="nav-link <?php echo ($myurl == "master_transaction_disp_new_asset.php"  ) ? " active" : ''; ?>"> <span>Displacement New Asset</span></a></li>
                            </li>    
                        <li class="nav-item" id = "master_transaction_disp_department"><a href="master_transaction_disp_department.php" class="nav-link <?php echo ($myurl == "master_transaction_disp_department.php"  ) ? " active" : ''; ?>"> <span>Displacement 1 Departement</span></a></li>
                            </li>
                            <li class="nav-item" id = "master_transaction_disp_department_branch"><a href="master_transaction_disp_department_branch.php" class="nav-link <?php echo ($myurl == "master_transaction_disp_department_branch.php"  ) ? " active" : ''; ?>">
                                    <span>Displacement to OtherDepartement/Branch</span></a></li>
                            </li>
                            <li class="nav-item" id = "master_transaction_lend_personel"><a href="master_transaction_lend_personel.php" class="nav-link <?php echo ($myurl == "master_transaction_lend_personel.php"  ) ? " active" : ''; ?>">
                                    <span>Lend to Personel</span></a></li>
                            </li>
                            <li class="nav-item" id = "master_transaction_lend_relation"><a href="master_transaction_lend_relation.php" class="nav-link <?php echo ($myurl == "master_transaction_lend_relation.php"  ) ? " active" : ''; ?>">
                                    <span>Lend to Relation</span></a></li>
                            </li>
                            <!-- <li class="nav-item"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>">
                                    <span>Lend Document Extension</span></a></li>
                            </li>
                            <li class="nav-item"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>">
                                    <span>Retur Document</span></a></li>
                            </li> -->
                            <li class="nav-item" id = "master_transaction_lend_other_branch"><a href="master_transaction_lend_other_branch.php" class="nav-link <?php echo ($myurl == "master_transaction_lend_other_branch.php"  ) ? " active" : ''; ?>">
                                    <span>Lend To Other Departement/Branch</span></a></li>
                            </li>
                            <li class="nav-item" id = "master_transaction_lend_extension"><a href="master_transaction_lend_extension.php" class="nav-link <?php echo ($myurl == "master_transaction_lend_extension.php"  ) ? " active" : ''; ?>">
                                    <span>Lend Extension</span></a></li>
                            </li>
                            <li class="nav-item" id = "master_transaction_lend_return"><a href="master_transaction_lend_return.php" class="nav-link <?php echo ($myurl == "master_transaction_lend_return.php"  ) ? " active" : ''; ?>">
                                    <span>Return</span></a></li>
                            </li>
                            <li class="nav-item" id = "master_transaction_sale"><a href="master_transaction_sale.php" class="nav-link <?php echo ($myurl == "master_transaction_sale.php"  ) ? " active" : ''; ?>">
                                    <span>Sale</span></a></li>
                            </li>
                            <!-- <li class="nav-item"><a href="master_transaction_mutation.php" class="nav-link <?php echo ($myurl == "master_transaction_mutation.php"  ) ? " active" : ''; ?>">
                                    <span>Mutation</span></a></li>
                            </li> -->
                            <li class="nav-item" id = "master_transaction_dispose"><a href="master_transaction_dispose.php" class="nav-link <?php echo ($myurl == "master_transaction_dispose.php"  ) ? " active" : ''; ?>">
                                    <span>Dispose</span></a></li>
                            </li>
                            

                        </ul>
                        </li>


                    <!-- Document -->
                    <!-- <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Document</div> <i class="icon-menu"
                            title="Master"></i>
                    </li> -->
                    <li class="nav-item nav-item-submenu  <?php echo ($myurl == "masterdocument.php" || $myurl == "masterdocumentdisplacementnew.php" || $myurl == "masterdocumentdisplacementotherrack.php" || $myurl == "masterdocumentlend.php" || $myurl == "masterdocumentdispose.php"  ) ? " nav-item-open" : ''; ?>">
                        <a href="#" class="nav-link <?php echo ($myurl == "masterdocument.php" || $myurl == "masterdocumentdisplacementnew.php" || $myurl == "masterdocumentdisplacementotherrack.php" || $myurl == "masterdocumentlend.php"  || $myurl == "masterdocumentdispose.php" ) ? " active" : ''; ?>">  <i class="icon-files-empty "></i> <span>Document</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "masterdocument.php" || $myurl == "masterdocumentdisplacementnew.php" || $myurl == "masterdocumentdisplacementotherrack.php"  || $myurl == "masterdocumentlend.php" || $myurl == "masterdocumentdispose.php") ? " display:block;" : ''; ?>">
                            <li class="nav-item"  id = "masterdocument"><a href="masterdocument.php" class="nav-link <?php echo ($myurl == "masterdocument.php"  ) ? " active" : ''; ?>"> <span>Add Document</span></a></li>
                            </li>
                            <li class="nav-item"  id = "masterdocumentdisplacementnew"><a href="masterdocumentdisplacementnew.php" class="nav-link <?php echo ($myurl == "masterdocumentdisplacementnew.php"  ) ? " active" : ''; ?>">
                                    <span>Displacement Document</span></a></li>
                            </li>
                            <li class="nav-item"  id = "masterdocumentdisplacementotherrack"><a href="masterdocumentdisplacementotherrack.php" class="nav-link <?php echo ($myurl == "masterdocumentdisplacementotherrack.php"  ) ? " active" : ''; ?>">
                                    <span>Move to other rack</span></a></li>
                            </li>
                            <li class="nav-item"  id = "masterdocumentlend"><a href="masterdocumentlend.php" class="nav-link <?php echo ($myurl == "masterdocumentlend.php"  ) ? " active" : ''; ?>">
                                    <span>Document's Activity</span></a></li>
                            </li>
                            <!-- <li class="nav-item"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>">
                                    <span>Lend Document Extension</span></a></li>
                            </li>
                            <li class="nav-item"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>">
                                    <span>Retur Document</span></a></li>
                            </li> -->
                            <li class="nav-item"  id = "masterdocumentdispose"><a href="masterdocumentdispose.php" class="nav-link <?php echo ($myurl == "masterdocumentdispose.php"  ) ? " active" : ''; ?>">
                                    <span>Dispose Document</span></a></li>
                            </li>
                            <li class="nav-item"  id = "masterdepartment"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>">
                                    <span>Opname Document</span></a></li>
                            </li>

                        </ul>
                        </li>
                    <!-- <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Master</div> <i class="icon-menu"
                            title="Master"></i>
                    </li> -->
                    <li class="nav-item nav-item-submenu <?php 
                echo (
                      $myurl == "masterlocationBranch.php"  || 
                      $myurl == "masterlocationbuilding.php"|| 
                      $myurl == "masterlocationrooms.php"|| 
                      $myurl == "masterrack.php"|| 
                      $myurl == "masterlocationfloor.php" || $myurl == "masterlocationSetupfloor.php"  ||
                      $myurl == "mastersubrack.php"|| 
                      $myurl == "masterotherloc.php" ||
                      $myurl == "mastercountry.php" || 
                      $myurl == "masterprovince.php" || 
                      $myurl == "mastercity.php" ) ? " nav-item-open" : ''; ?>
                
                ">
                    <a href="#" class="nav-link <?php 
                echo (
                      $myurl == "masterlocationBranch.php"  || 
                      $myurl == "masterlocationbuilding.php"|| 
                      $myurl == "masterlocationrooms.php"|| 
                      $myurl == "masterrack.php"||
                       $myurl == "masterlocationfloor.php" || $myurl == "masterlocationSetupfloor.php"  ||
                      $myurl == "mastersubrack.php"|| 
                      $myurl == "masterotherloc.php" ||
                      $myurl == "mastercountry.php" || 
                      $myurl == "masterprovince.php" || 
                      $myurl == "mastercity.php" ) ? " active" : ''; ?>"><i class="icon-map4"></i> <span>Location</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = " <?php 
                                    echo (
                                    $myurl == "masterlocationBranch.php"  || 
                                    $myurl == "masterlocationbuilding.php"|| 
                                    $myurl == "masterlocationrooms.php"|| 
                                    $myurl == "masterrack.php"|| 
                                    $myurl == "masterlocationfloor.php" || $myurl == "masterlocationSetupfloor.php"  ||
                                    $myurl == "mastersubrack.php"|| 
                                    $myurl == "masterotherloc.php" ||
                                    $myurl == "mastercountry.php" || 
                                    $myurl == "masterprovince.php" || 
                                    $myurl == "mastercity.php" ) ? " display:block;" : ''; ?>"
                                   
                    
                    >
                        <!-- <li class="nav-item"><a class="nav-link">Area</a></li> -->
                        <!-- <li class="nav-item"><a href="mastercountry.php" class="nav-link <?php echo ($myurl == "mastercountry.php"  ) ? " active" : ''; ?>">
                                <span>Country</span></a></li>
                        <li class="nav-item"><a href="masterprovince.php" class="nav-link <?php echo ($myurl == "masterprovince.php"  ) ? " active" : ''; ?>">
                                <span>Province</span></a></li>
                        <li class="nav-item"><a href="mastercity.php" class="nav-link <?php echo ($myurl == "mastercity.php"  ) ? " active" : ''; ?>">
                                <span>City</span></a></li> -->
                       
                        <!-- <li class="nav-item"><a href="masterlocationBranch.php" class="nav-link <?php echo ($myurl == "masterlocationBranch.php"  ) ? " active" : ''; ?>">Branch</a></li> -->
                        <li class="nav-item" id = "masterlocationfloor" ><a href="masterlocationfloor.php" class="nav-link <?php echo ($myurl == "masterlocationfloor.php"  ) ? " active" : ''; ?>">Floor</a></li>
                       
                        <li class="nav-item" id = "masterlocationbuilding"><a href="masterlocationbuilding.php" class="nav-link <?php echo ($myurl == "masterlocationbuilding.php"  ) ? " active" : ''; ?>">Building</a>
                        </li>
                       <!-- <li class="nav-item" id = "masterlocationSetupfloor"><a href="masterlocationSetupfloor.php" class="nav-link <?php echo ($myurl == "masterlocationSetupfloor.php"  ) ? " active" : ''; ?>">Building &
                                Floor</a></li> -->
                     
                        <li class="nav-item" id = "masterlocationrooms"><a href="masterlocationrooms.php" class="nav-link <?php echo ($myurl == "masterlocationrooms.php"  ) ? " active" : ''; ?>">Rooms</a></li>
                        <li class="nav-item" id = "masterrack"><a href="masterrack.php" class="nav-link <?php echo ($myurl == "masterrack.php"  ) ? " active" : ''; ?>">Rack</a></li>
                        <!-- <li class="nav-item"><a href="mastersubrack.php" class="nav-link <?php echo ($myurl == "mastersubrack.php"  ) ? " active" : ''; ?>">Sub Rack</a></li> -->
                        
                        <!-- Document -->


                        <!-- ENd Document -->

                        <!-- <li class="nav-item"><a href="masterotherloc.php" class="nav-link <?php echo ($myurl == "masterotherloc.php"  ) ? " active" : ''; ?>">Other Location</a> -->
                        </li>
                    </ul>
                    </li>
                    <!-- <li class="nav-item"><a href = "masterholdingcompany.php" class="nav-link <?php echo ($myurl == "masterholdingcompany.php") ? "active" : ''; ?>"><i class="icon-width"></i> <span>Holding Company</span></a>
                    </li> -->
                 

                    <li class="nav-item nav-item-submenu  <?php echo ($myurl == "masterdivision.php" || $myurl == "masterdepartment.php"  ) ? " nav-item-open" : ''; ?>">
                        <a href="#" class="nav-link"><i class="icon-office "></i> <span>Department</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "masterdivision.php" || $myurl == "masterdepartment.php"  ) ? " display:block;" : ''; ?>">
                            <li class="nav-item"  id = "masterdivision"><a href="masterdivision.php" class="nav-link <?php echo ($myurl == "masterdivision.php"  ) ? " active" : ''; ?>"></i> <span>Division</span></a></li>
                            </li>
                            <li class="nav-item"  id = "masterdepartment"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>">
                                    <span>Department</span></a></li>
                            </li>

                        </ul>
                   </li>
                   <li class="nav-item nav-item-submenu  <?php echo ($myurl == "masterrank.php" || $myurl == "masterstaff.php" || $myurl == "masterreason.php" || $myurl == "masterrelation.php"  || $myurl == "mastersupplier.php"  ) ? " nav-item-open" : ''; ?>">
                        <a href="#" class="nav-link"><i class="mi-person "></i> <span>Contact</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "masterrank.php" || $myurl == "masterstaff.php" || $myurl == "masterreason.php" || $myurl == "masterrelation.php"  || $myurl == "mastersupplier.php"   ) ? " display:block;" : ''; ?>">
                        <li class="nav-item" id = "masterrank"><a href = "masterrank.php" class="nav-link <?php echo ($myurl == "masterrank.php") ? "active" : ''; ?>"> <span>Status & Personal Rank</span></a>
                    </li>
                    <li class="nav-item" id = "masterstaff"><a href="masterstaff.php" class="nav-link <?php echo ($myurl == "masterstaff.php") ? "active" : ''; ?>">
                                <span>Personel</span></a></li>
                    <li class="nav-item" id = "masterreason"><a href="masterreason.php" class="nav-link <?php echo ($myurl == "masterreason.php") ? "active" : ''; ?>">
                                <span>Reason</span></a></li>
                    <li class="nav-item" id = "masterrelation"><a href="masterrelation.php" class="nav-link <?php echo ($myurl == "masterrelation.php") ? "active" : ''; ?>">
                                <span>Relation</span></a></li>

                     <li class="nav-item" id = "mastersupplier"><a href="mastersupplier.php" class="nav-link <?php echo ($myurl == "mastersupplier.php") ? "active" : ''; ?>">
                                <span>Supplier</span></a></li>

                        </ul>
                   </li>
                   <li class="nav-item nav-item-submenu  <?php echo ($myurl == "mastersistercompanyandbranch.php"  || $myurl == "masterlocationSisterCompany.php"   ) ? " nav-item-open" : ''; ?>">
                        <a href="#" class="nav-link"><i class="mi-settings "></i> <span>Setting</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "mastersistercompanyandbranch.php"  || $myurl == "masterlocationSisterCompany.php") ? " display:block;" : ''; ?>">
                        <li class="nav-item" id = "masterlocationSisterCompany"><a href="masterlocationSisterCompany.php" class="nav-link <?php echo ($myurl == "masterlocationSisterCompany.php"  ) ? " active" : ''; ?>">Company</a></li>
                        <li class="nav-item" id = "mastersistercompanyandbranch" ><a href="mastersistercompanyandbranch.php" class="nav-link <?php echo ($myurl == "mastersistercompanyandbranch.php"  ) ? " active" : ''; ?>">Branch</a></li>
                      
                        <!-- <li class="nav-item"><a href = "masterrank.php" class="nav-link <?php echo ($myurl == "masterrank.php") ? "active" : ''; ?>"><i class="icon-width"></i> <span>Status & Personal Rank</span></a>
                    </li>
                    <li class="nav-item"><a href="masterstaff.php" class="nav-link <?php echo ($myurl == "masterstaff.php") ? "active" : ''; ?>"><i class="icon-width"></i>
                                <span>Personel</span></a></li>
                    <li class="nav-item"><a href="masterreason.php" class="nav-link <?php echo ($myurl == "masterreason.php") ? "active" : ''; ?>"><i class="icon-width"></i>
                                <span>Reason</span></a></li>
                    <li class="nav-item"><a href="masterrelation.php" class="nav-link <?php echo ($myurl == "masterrelation.php") ? "active" : ''; ?>"><i class="icon-width"></i>
                                <span>Relation</span></a></li>

                     <li class="nav-item"><a href="mastersupplier.php" class="nav-link <?php echo ($myurl == "mastersupplier.php") ? "active" : ''; ?>"><i class="icon-width"></i>
                                <span>Supplier</span></a></li> --> 
                                <!-- <li class="nav-item"><a href="mastersupplier.php" class="nav-link <?php echo ($myurl == "mastersupplier.php") ? "active" : ''; ?>"><i class="icon-width"></i>
                                <span>test</span></a></li> -->
                        </ul>
                   </li>
                 
                           
                <!-- <li class="nav-item nav-item-submenu ">
                    <a href="#" class="nav-link "><i class="icon-table2"></i> <span>User Asset</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Basic tables">
                        <li class="nav-item"><a href="masterstaff.php" class="nav-link"><i class="icon-width"></i>
                                <span>Personel</span></a></li>
                        <li class="nav-item"><a href="masterpic.php" class="nav-link"><i class="icon-width"></i>
                                <span>PIC</span></a></li>
                        <li class="nav-item"><a href="masterpicdepartment.php" class="nav-link"><i
                                    class="icon-width"></i> <span>PIC (Department)</span></a></li>
                    </ul>
                </li> -->

         

                <!-- <li class="nav-item nav-item-submenu <?php echo ($myurl == "mastercountry.php" || $myurl == "masterprovince.php"  || $myurl == "mastercity.php"  ) ? " nav-item-open" : ''; ?>">
                    <a href="#" class="nav-link "><i class="icon-table2"></i> <span>Location Group</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "mastercountry.php" || $myurl == "masterprovince.php"  || $myurl == "mastercity.php") ? " display:block;" : ''; ?>">
                        <li class="nav-item"><a href="mastercountry.php" class="nav-link <?php echo ($myurl == "mastercountry.php"  ) ? " active" : ''; ?>"><i class="icon-width"></i>
                                <span>Country</span></a></li>
                        <li class="nav-item"><a href="masterprovince.php" class="nav-link <?php echo ($myurl == "masterprovince.php"  ) ? " active" : ''; ?>"><i class="icon-width"></i>
                                <span>Province</span></a></li>
                        <li class="nav-item"><a href="mastercity.php" class="nav-link <?php echo ($myurl == "mastercity.php"  ) ? " active" : ''; ?>"><i class="icon-width"></i>
                                <span>City</span></a></li>
                    </ul>
                  </li> -->
                </ul>
            <!-- </div> -->
            
        </div>
    </div>
    

<script type="text/javascript">
    $(document).ready(function(){
          $('.nav-sidebar .nav-item .nav-link').click(function(){
            $('.nav-item .nav-link').removeClass("active");
            $(this).addClass("active");
        });
    });

    var myurlsfromtop = "<?php echo $myurl; ?>";
    var mystringlength = myurlsfromtop.length;
   
    var urlfix = myurlsfromtop.slice(0,mystringlength-4);
  
    $('.sidebar-content').animate({
    scrollTop: $("#" + urlfix).offset().top
    }, 1000);
  
</script>
