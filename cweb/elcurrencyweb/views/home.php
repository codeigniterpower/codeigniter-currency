
	<!-- HOME BUTTONS CARD INI -->
	<div class="col py-0 px-0">
		<div class="contain-image">
			<div class="card-deck d-flex justify-content-around  flex-wrap">
				<div class="card m-3" style="width: 300px;">
					<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
					<div class="card-body">
						<h5 class="card-title">
							Manager Module
						</h5>
						<p class="card-text">This module allows you to see the rates of your preference, and its conversion but only for current day (if the system is property configured).</p>
					</div>
					<div class="card-footer">
						<small class="text-muted">
							<a href="<?php echo site_url() . "/Currency_Manager"; ?>" class="nav-link px-0 align-middle links-menu">
								<i class="fs-4 bi-table links-menu"></i>
								<span class="ms-1 d-none d-sm-inline links-menu">
									Currency
								</span>
							</a>
						</small>
					</div>
				</div>
				<div class="card m-3" style="width: 300px;">
					<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
					<div class="card-body">
						<h5 class="card-title">
							History Module
						</h5>
						<p class="card-text">This module allows you to review all conversion rates starting from the day you installed the module to the current day.</p>
					</div>
					<div class="card-footer">
						<small class="text-muted">
							<a href="<?php echo site_url() . "/Currency_History"; ?>" class="nav-link px-0 align-middle links-menu">
								<i class="fs-4 bi-speedometer2 links-menu"></i>
								<span class="ms-1 d-none d-sm-inline links-menu">
									History
								</span>
							</a>
						</small>
					</div>
				</div>
				<div class="card m-3" style="width: 300px;">
					<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
					<div class="card-body">
						<h5 class="card-title">
							Converter rate
						</h5>
						<p class="card-text">Module that permits to you convert an arbirtrary amount to another currency using prefered currencies or customized manually.</p>
					</div>
					<div class="card-footer">
						<small class="text-muted">
							<a href="<?php echo site_url() . "/Currency_Manager/currencyConverter"; ?>" class="nav-link px-0 align-middle links-menu">
								<i class="fs-4 bi-currency-exchange links-menu"></i>
								<span class="ms-1 d-none d-sm-inline links-menu">
									Convert
								</span>
							</a>
						</small>
					</div>
				</div>
			</div>
		</div>
		<!-- HOME BUTTONS CARD END -->

		<!-- PROYECT INFO SECTION INI -->
		<section class="descriptions-contains">
			<div class="documentation">
				<div class="contain-toggle">
					<button class="btn text-start btn-outline-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
						About Currency
					</button>
				</div>
				<div>
					<div class="collapse collapse-horizontal" id="collapse1">
						<div class="card card-body">
							<p>
								This project was born from a requirement to keep the conversions between currencies synchronized in an intranet, but open source. PLACE HERE LINKS TO GITLAB RSS feed
								<small class="text-muted">
									<a href="https://gitlab.com/codeigniterpower/codeigniter-currencylib" class="nav-link px-0 align-middle links-menu">
										<i class="fs-4 bi-people links-menu"></i>
										<span class="ms-1 d-none d-sm-inline links-menu">
											Check the project!
										</span>
									</a>
								</small>
							</p>
						</div>
					</div>
				</div>
				  <div class="contain-toggle">
					<button class="btn text-start btn-outline-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
						Telegram network
					</button>
				  </div>
				  <div class="contain-toggle">
					<div class="collapse collapse-horizontal" id="collapse5">
					  <div class="card card-body">
						<p>
							<script async src="https://telegram.org/js/telegram-widget.js?21" data-telegram-post="latam_programadores/5597" data-width="100%"></script>
						</p>
					  </div>
					</div>
				</div>
				</div>
		</section>
		<!-- PROYECT INFO SECTION END -->


		<!-- button contact chat -->
		<div class="fab-container position-fixed">
			<div class="fab shadow">
				<div class="fab-content">
					<span class="material-icons">
						Contact us
					</span>
				</div>
			</div>
			<div class="sub-button shadow">
				<a href="https://gitlab.com/groups/codeigniterpower/" target="_blank">
					<span class="material-icons">
						<i class="bi bi-envelope"></i>
					</span>
				</a>
			</div>
		</div>
		<!-- button contact chat end -->
