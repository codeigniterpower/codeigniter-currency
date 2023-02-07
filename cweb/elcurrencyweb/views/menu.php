<div class="container-fluid">
        <div class="row flex-nowrap">

                  <!-- Change col-md-3 to col-sm-3 -->
                  <div class="col-auto col-sm-3 col-xl-2 px-sm-2 px-0 bg-dark"> 
              <!-- bg-dark -->
                <div class="d-flex flex-column position-relative align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100" style="z-index: 1;">
                    
                    <!-- <a href="/" class="d-flex position-fixed align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a> -->

                    <ul class="nav nav-pills position-fixed flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item" >
                            <a href="<?php echo site_url() . "/Home"  ?>" class="nav-link align-middle px-0 links-menu">
                                <i class="fs-4 bi-house"></i>
                                <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url() . "/Currency_Manager"  ?>" class="nav-link px-0 align-middle links-menu">
                                <i class="fs-4 bi-table links-menu"></i>
                                <span class="ms-1 d-none d-sm-inline links-menu">Currency</span>  </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url() . "/Currency_History"  ?>" class="nav-link px-0 align-middle links-menu">
                                <i class="fs-4 bi-speedometer2 links-menu"></i>
                                <span class="ms-1 d-none d-sm-inline links-menu">History</span>  </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url() . "/Currency_Users"  ?>" class="nav-link px-0 align-middle links-menu">
                                <i class="fs-4 bi-people links-menu"></i>
                                <span class="ms-1 d-none d-sm-inline links-menu">Users</span>  </a>
                        </li>
                    </ul>
                    <hr>

                    <div class="dropdown pb-4 position-fixed  bottom-0">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle"> 
                            <!-- add class  css custom width image user -->
                            <span class="d-none d-sm-inline mx-1">loser</span>
                        </a>


                        
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        <!-- estas dos deben cerrar mas tarde ia va -->
    <!-- </div>
</div> -->
