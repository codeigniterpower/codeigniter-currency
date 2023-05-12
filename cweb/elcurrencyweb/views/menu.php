		<!-- MENU INI -->
		<div class="col-auto col-sm-3 col-xl-2 px-sm-2 px-0" style="background-color:hsl(235deg 78% 57%)"> 
			<!-- bg-dark ini -->
			<div class="d-flex flex-column position-relative align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100" style="z-index: 1;">
				<ul class="nav nav-pills position-fixed flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
					<li class="nav-item" >
						<a href="<?php echo site_url() . "/Home"  ?>" class="nav-link align-middle px-0 links-menu">
							<i class="fs-4 bi-house"></i>
							<span class="ms-1 d-none d-sm-inline">
								Home
							</span>
						</a>
					</li>
					<li>
						<a href="<?php echo site_url() . "/Currency_Converter"?>" class="nav-link px-0 align-middle links-menu">
							<i class="bi bi-intersect" style="font-size: 21px;"></i>
							<span class="ms-1 d-none d-sm-inline links-menu">
								Converter
							</span>
						</a>
					</li>
					<li>
						<a href="<?php echo site_url() . "/Currency_Manager"  ?>" class="nav-link px-0 align-middle links-menu">
							<i class="fs-4 bi-table"></i>
							<span class="ms-1 d-none d-sm-inline links-menu">
								Currency
							</span>
						</a>
					</li>
					<li>
						<a href="<?php echo site_url() . "/Currency_History"  ?>" class="nav-link px-0 align-middle links-menu">
							<i class="fs-4 bi-speedometer"></i>
							<span class="ms-1 d-none d-sm-inline links-menu">
								History
							</span>
						</a>
					</li>
					<li>
						<a href="<?php echo site_url() . "/Currency_Users"  ?>" class="nav-link px-0 align-middle links-menu">
							<i class="fs-4 bi-people "></i>
							<span class="ms-1 d-none d-sm-inline links-menu">
								Users
							</span>
						</a>
					</li>
					<li>
						<a href="<?php echo site_url() . "/Indexauth/auth/logout"?>" class="nav-link px-0 align-middle links-menu">
							<i class="bi bi-box-arrow-in-right" style="font-size: 21px;"></i>
							<span class="ms-1 d-none d-sm-inline links-menu">
								Logout
							</span>
						</a>
					</li>

				</ul>

				<!-- FOOTER END IF LOGGED -->
			</div>
			<!-- bg-dark end -->
		</div>
		<!-- MENU END -->
