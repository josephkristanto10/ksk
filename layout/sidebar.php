<?php
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $myurl = $uriSegments[2];
     
?>
<div class="page-content">
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
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
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu"
                            title="Main"></i>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link ">
                            <i class="icon-home4"></i>
                            <span>
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Asset</div> <i class="icon-menu"
                            title="Master"></i>
                    </li>
                    <li class="nav-item nav-item-submenu <?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" || $myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php" || $myurl == "masterfuel.php" || $myurl == "masterdrivingforce.php" || $myurl == "masterassets.php" || $myurl == "mastertemplate.php" ) ? " nav-item-open" : ''; ?>">
                        <a href="#" class="nav-link <?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" || $myurl == "masterfuel.php" || $myurl == "masterdrivingforce.php"|| $myurl == "masterassets.php" || $myurl == "mastertemplate.php" ) ? " nav-item-open" : ''; ?>"><i class="icon-table2"></i> <span>Asset</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" || $myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php" || $myurl == "masterfuel.php" || $myurl == "masterdrivingforce.php" || $myurl == "masterassets.php" || $myurl == "mastertemplate.php") ? "display:block;" : ''; ?>">
                             <li class="nav-item"><a href="masterassets.php" class="nav-link <?php echo ($myurl == "masterassets.php"  ) ? " active" : ''; ?>">Assets</a>
                            <li class="nav-item nav-item-submenu <?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" ) ? " nav-item-open" : ''; ?>">
                                <a href="#" class="nav-link <?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" ) ? "active" : ''; ?>"> <span>Asset Group</span></a>
                                <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "masterkategoriassets.php" || $myurl == "mastersubkategoriassets.php" || $myurl == "mastercategorysubgroup.php" ) ? "display:block;" : ''; ?>">
                                    <li class="nav-item"><a href = "masterkategoriassets.php" class="nav-link <?php echo ($myurl == "masterkategoriassets.php" ) ? "active" : ''; ?>">Group</a>
                                    </li>
                                    <li class="nav-item"><a href="mastersubkategoriassets.php" class="nav-link <?php echo ( $myurl == "mastersubkategoriassets.php"  ) ? "active" : ''; ?>">Sub
                                            Group</a></li>
                                    <li class="nav-item"><a href="mastercategorysubgroup.php"
                                            class="nav-link <?php echo ( $myurl == "mastercategorysubgroup.php" ) ? "active" : ''; ?>">Category</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu <?php echo ($myurl == "mastertemplate.php" || $myurl == "mastertemplate.php"  ) ? " nav-item-open" : ''; ?>">
                                <a href="#" class="nav-link <?php echo ($myurl == "mastertemplate.php" || $myurl == "mastertemplate.php"  ) ? " active" : ''; ?>"> <span>Asset Template</span></a>

                                <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "mastertemplate.php" || $myurl == "masterinitialcondition.php"  ) ? " display:block;" : ''; ?>">
                                <li class="nav-item"><a href="mastertemplate.php" class="nav-link <?php echo ($myurl == "mastertemplate.php"  ) ? " active" : ''; ?>">Template List</a>
                                    </li>
                                <?php $sql = "select * from template"; $res = $conn->query($sql);
                                if($res->num_rows>0)
                                {
                                    while($r = mysqli_fetch_array($res))
                                    {
                                        echo '<li class="nav-item"><a class="nav-link" >'.$r['template'].'</a></li>';
                                    }
                              
                                }
                                ?>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-submenu <?php echo ($myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php"  ) ? " nav-item-open" : ''; ?>">
                                <a href="#" class="nav-link <?php echo ($myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php"  ) ? " active" : ''; ?>"> <span>Condition</span></a>
                                <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "mastercondition.php" || $myurl == "masterinitialcondition.php"  ) ? " display:block;" : ''; ?>">
                                    <li class="nav-item"><a class="nav-link <?php echo ($myurl == "masterinitialcondition.php"  ) ? " active" : ''; ?>" href="masterinitialcondition.php">Initial
                                            Condition</a></li>
                                    <li class="nav-item"><a href="mastercondition.php" class="nav-link <?php echo ($myurl == "mastercondition.php"  ) ? " active" : ''; ?>">Condition</a>
                                    </li>

                                </ul>
                            </li>
                          
                           
                            
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Document</div> <i class="icon-menu"
                            title="Master"></i>
                    </li>
                    <li class="nav-item nav-item-submenu  <?php echo ($myurl == "masterdocument.php" || $myurl == "masterdocumentdisplacementnew.php" || $myurl == "masterdocumentdisplacementotherrack.php" || $myurl == "masterdocumentlend.php" || $myurl == "masterdocumentdispose.php"  ) ? " nav-item-open" : ''; ?>">
                        <a href="#" class="nav-link <?php echo ($myurl == "masterdocument.php" || $myurl == "masterdocumentdisplacementnew.php" || $myurl == "masterdocumentdisplacementotherrack.php" || $myurl == "masterdocumentlend.php"  || $myurl == "masterdocumentdispose.php" ) ? " active" : ''; ?>"> <span>Document</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "masterdocument.php" || $myurl == "masterdocumentdisplacementnew.php" || $myurl == "masterdocumentdisplacementotherrack.php"  || $myurl == "masterdocumentlend.php" || $myurl == "masterdocumentdispose.php") ? " display:block;" : ''; ?>">
                            <li class="nav-item"><a href="masterdocument.php" class="nav-link <?php echo ($myurl == "masterdocument.php"  ) ? " active" : ''; ?>"> <span>Add Document</span></a></li>
                            </li>
                            <li class="nav-item"><a href="masterdocumentdisplacementnew.php" class="nav-link <?php echo ($myurl == "masterdocumentdisplacementnew.php"  ) ? " active" : ''; ?>">
                                    <span>Displacement Document</span></a></li>
                            </li>
                            <li class="nav-item"><a href="masterdocumentdisplacementotherrack.php" class="nav-link <?php echo ($myurl == "masterdocumentdisplacementotherrack.php"  ) ? " active" : ''; ?>">
                                    <span>Move to other rack</span></a></li>
                            </li>
                            <li class="nav-item"><a href="masterdocumentlend.php" class="nav-link <?php echo ($myurl == "masterdocumentlend.php"  ) ? " active" : ''; ?>">
                                    <span>Document's Activity</span></a></li>
                            </li>
                            <!-- <li class="nav-item"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>">
                                    <span>Lend Document Extension</span></a></li>
                            </li>
                            <li class="nav-item"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>">
                                    <span>Retur Document</span></a></li>
                            </li> -->
                            <li class="nav-item"><a href="masterdocumentdispose.php" class="nav-link <?php echo ($myurl == "masterdocumentdispose.php"  ) ? " active" : ''; ?>">
                                    <span>Dispose Document</span></a></li>
                            </li>
                            <li class="nav-item"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>">
                                    <span>Opname Document</span></a></li>
                            </li>

                        </ul>
                        </li>
                    <li class="nav-item-header">
                        <div class="text-uppercase font-size-xs line-height-xs">Master</div> <i class="icon-menu"
                            title="Master"></i>
                    </li>
                    <li class="nav-item nav-item-submenu <?php 
                echo ($myurl == "masterlocationSisterCompany.php" || 
                      $myurl == "masterlocationBranch.php"  || 
                      $myurl == "mastersistercompanyandbranch.php"|| 
                      $myurl == "masterlocationbuilding.php"|| 
                      $myurl == "masterlocationfloor.php"|| 
                      $myurl == "masterlocationSetupfloor.php"|| 
                      $myurl == "masterlocationrooms.php"|| 
                      $myurl == "masterrack.php"|| 
                      $myurl == "mastersubrack.php"|| 
                      $myurl == "masterotherloc.php" ||
                      $myurl == "mastercountry.php" || 
                      $myurl == "masterprovince.php" || 
                      $myurl == "mastercity.php" ) ? " nav-item-open" : ''; ?>
                
                ">
                    <a href="#" class="nav-link <?php 
                echo ($myurl == "masterlocationSisterCompany.php" || 
                      $myurl == "masterlocationBranch.php"  || 
                      $myurl == "mastersistercompanyandbranch.php"|| 
                      $myurl == "masterlocationbuilding.php"|| 
                      $myurl == "masterlocationfloor.php"|| 
                      $myurl == "masterlocationSetupfloor.php"|| 
                      $myurl == "masterlocationrooms.php"|| 
                      $myurl == "masterrack.php"|| 
                      $myurl == "mastersubrack.php"|| 
                      $myurl == "masterotherloc.php" ||
                      $myurl == "mastercountry.php" || 
                      $myurl == "masterprovince.php" || 
                      $myurl == "mastercity.php" ) ? " active" : ''; ?>"><i class="icon-map4"></i> <span>Location</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = " <?php 
                                    echo ($myurl == "masterlocationSisterCompany.php" || 
                                    $myurl == "masterlocationBranch.php"  || 
                                    $myurl == "mastersistercompanyandbranch.php"|| 
                                    $myurl == "masterlocationbuilding.php"|| 
                                    $myurl == "masterlocationfloor.php"|| 
                                    $myurl == "masterlocationSetupfloor.php"|| 
                                    $myurl == "masterlocationrooms.php"|| 
                                    $myurl == "masterrack.php"|| 
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
                        <li class="nav-item"><a href="masterlocationSisterCompany.php" class="nav-link <?php echo ($myurl == "masterlocationSisterCompany.php"  ) ? " active" : ''; ?>">Sister
                                Company</a></li>
                        <li class="nav-item"><a href="masterlocationBranch.php" class="nav-link <?php echo ($myurl == "masterlocationBranch.php"  ) ? " active" : ''; ?>">Branch</a></li>
                        <li class="nav-item"><a href="mastersistercompanyandbranch.php" class="nav-link <?php echo ($myurl == "mastersistercompanyandbranch.php"  ) ? " active" : ''; ?>">Sister Company
                                & Branch</a></li>
                        <li class="nav-item"><a href="masterlocationbuilding.php" class="nav-link <?php echo ($myurl == "masterlocationbuilding.php"  ) ? " active" : ''; ?>">Building</a>
                        </li>
                        <li class="nav-item"><a href="masterlocationfloor.php" class="nav-link <?php echo ($myurl == "masterlocationfloor.php"  ) ? " active" : ''; ?>">Floor</a></li>
                        <li class="nav-item"><a href="masterlocationSetupfloor.php" class="nav-link <?php echo ($myurl == "masterlocationSetupfloor.php"  ) ? " active" : ''; ?>">Building &
                                Floor</a></li>
                        <li class="nav-item"><a href="masterlocationrooms.php" class="nav-link <?php echo ($myurl == "masterlocationrooms.php"  ) ? " active" : ''; ?>">Rooms</a></li>
                        <li class="nav-item"><a href="masterrack.php" class="nav-link <?php echo ($myurl == "masterrack.php"  ) ? " active" : ''; ?>">Rack</a></li>
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
                        <a href="#" class="nav-link"><i class="icon-table2"></i> <span>Department</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "<?php echo ($myurl == "masterdivision.php" || $myurl == "masterdepartment.php"  ) ? " display:block;" : ''; ?>">
                            <li class="nav-item"><a href="masterdivision.php" class="nav-link <?php echo ($myurl == "masterdivision.php"  ) ? " active" : ''; ?>"><i
                                        class="icon-width"></i> <span>Division</span></a></li>
                            </li>
                            <li class="nav-item"><a href="masterdepartment.php" class="nav-link <?php echo ($myurl == "masterdepartment.php"  ) ? " active" : ''; ?>"><i class="icon-width"></i>
                                    <span>Department</span></a></li>
                            </li>

                        </ul>
                   </li>
                   <li class="nav-item"><a href = "masterrank.php" class="nav-link <?php echo ($myurl == "masterrank.php") ? "active" : ''; ?>"><i class="icon-width"></i> <span>Status & Personal Rank</span></a>
                    </li>
                    <li class="nav-item"><a href="masterstaff.php" class="nav-link <?php echo ($myurl == "masterstaff.php") ? "active" : ''; ?>"><i class="icon-width"></i>
                                <span>Personel</span></a></li>
                    <li class="nav-item"><a href="masterreason.php" class="nav-link <?php echo ($myurl == "masterreason.php") ? "active" : ''; ?>"><i class="icon-width"></i>
                                <span>Reason</span></a></li>
                    <li class="nav-item"><a href="masterrelation.php" class="nav-link <?php echo ($myurl == "masterrelation.php") ? "active" : ''; ?>"><i class="icon-width"></i>
                                <span>Relation</span></a></li>

                     <li class="nav-item"><a href="mastersupplier.php" class="nav-link <?php echo ($myurl == "mastersupplier.php") ? "active" : ''; ?>"><i class="icon-width"></i>
                                <span>Supplier</span></a></li>
                           
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
</script>
