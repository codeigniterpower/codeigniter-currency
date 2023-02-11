<?php

	$userurl = $this->input->get_post('userurl');
	?>

<!-- PROMOTION CURRENCYMANAGER BLOCK-->
		<div class="contain-image">
		  <div class="card-deck d-flex justify-content-around  flex-wrap">
			<div class="card m-4" style="width: 300px;">
			  <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
			  <div class="card-body">
				<h3 class="card-title">Currency Manager</h3>
				<p class="card-text">A simple web based currency rate manager for your own currency rate history.</p>
			  </div>
			  <div class="card-footer">
				<small class="text-muted">
					<a class="btn btn-default btn-outline-success" href="<?php echo site_url();?>/Login"><i class="icon icon-screen-desktop"></i>Try it!</a>
				</small>
			  </div>
			</div>
			<div class="card m-4" style="width: 300px;">
			  <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
			  <div class="card-body">
				<h3 class="card-title">Free & Self-hosted</h3>
				<p class="card-text">Liberate your software from proprietary shackles. Currency Manager offers to save rates to a platform you own..</p>
			  </div>
			  <div class="card-footer">
				<small class="text-muted">
					<a class="btn btn-default btn-outline-success" href="<?php echo site_url();?>/Login"><i class="icon icon-screen-desktop"></i>Login!</a>
				</small>
			  </div>
			</div>
			<div class="card m-4" style="width: 300px;">
			  <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
			  <div class="card-body">
				<h3 class="card-title">Exchangerate API!</h3>
				<p class="card-text">It check international rates using <strong>Exchangerate API</strong>, just setup your API key and will be stored in DB.</p>
			  </div>
			  <div class="card-footer">
				<small class="text-muted">
					<a class="btn btn-default btn-outline-success" href="https://apilayer.com/marketplace/exchangerates_data-api#pricing"><i class="icon icon-screen-desktop"></i>Get a key!</a>
				</small>
			  </div>
			</div>
			<div class="card m-4" style="width: 300px;">
			  <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
			  <div class="card-body">
				<h3 class="card-title">Open source! Get In!</h3>
				<p class="card-text">Currency Manager its open source, consists of motivated people, and we are looking forward to your contribution.</p>
			  </div>
			  <div class="card-footer">
				<small class="text-muted">
					<a class="btn btn-default btn-outline-success" href="https://gitlab.com/codeigniterpower/codeigniter-currencylib/tree/main/docs"><i class="icon icon-screen-desktop"></i>Sources!</a>
				</small>
			  </div>
			</div>
		  </div>
		</div>
<?php
	echo '<footer class="footer pb-4 position-fixed  bottom-0" >';
		echo '<small class="d-flex align-items-center text-decoration-none d-sm-inline mx-1"><p style="display: flex; justify-content: center;">';
		echo '</p class="ms-1 d-none d-sm-inline">';
		echo anchor('https://gitlab.com/codeigniterpower','Powered by VenenuX CI'), PHP_EOL;
		echo '</p>'. PHP_EOL;
		echo '</small>'. PHP_EOL;
	echo '</footer>'.PHP_EOL;
