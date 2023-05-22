<div class="col py-1 d-flex contain-currency contain-min" style="background-color: #f9faff;">
		<!-- <section>
			<div id="contain-modal"> -->
				<!-- HERE IS THE DIALOG PLACE -->
			<!-- </div> -->
		<!-- </section> -->
		<section>
			<div id="alert-errors">
				<!-- HERE IS THE NOTIFICATION -->
			</div>
		</section>
		<section>
			<div id="liveAlertPlaceholder">
				<!-- HERE IS THE NOTIFICATION -->
			</div>
		</section>
		<section>
			<div class="contain-table">
				<!-- HERE IS THE DATA DISPLAY -->
				<?php 
				$htmldisplaymessageapibutton = 'wait for the system to get the coin rates from the internet.';
				if($active)
				{
					$htmldisplaymessageapibutton .= ' You can press the coins button above to get a new coin rate code.';
					echo div_open('class="d-flex justify-content-end width-95"');
						echo form_button('button-call', $buttonicon, 'class="btn btn-outline-success" id="button-call" ');
					echo div_close();
				}
				if(is_array($currency_list_dbarraypre) )
				{
					if(count($currency_list_dbarraypre))
					{
						$this->table->clear();
						$this->table->set_template( array( 'table_open' => '
						<table id="table_id">',
						'heading_row_start'     => '<tr style="background-color:#ffffff00;">',
						'heading_row_end'       => '</tr>',
						'heading_cell_start' => '<th style="border-bottom:0">',
						'heading_cell_end'      => '</th>',
						'tbody_open'            => '<tbody>',
						'tbody_close'           => '</tbody>',
						'row_start'             => '<tr style="background-color:#ffffff00;border: 0px;">',
						'row_end'               => '</tr>',
						'cell_start'            => '<td style="background-color:#ffffff00;border: 0px;"">',
						'cell_end'              => '</td>',
						'table_close'         => '</table>'

						) );
						$this->table->set_heading(array_keys($currency_list_dbarraypre[0]));
					}
				}
				$htmldatadisplayallcurrencies = 'The data of world currency rates today is not yet present.. '.$htmldisplaymessageapibutton;
				if(is_array($currency_list_dbarraynow))
				{
					if(count($currency_list_dbarraynow))
					{
						$this->table->clear();
						$this->table->set_template( array( 
							'table_open' => '<table id="table_id2">',
							'heading_row_start'     => '<tr style="background-color:#ffffff00;">',
							'heading_row_end'       => '</tr>',
							'heading_cell_start' => '<th style="border-bottom:0">',
							'heading_cell_end'      => '</th>',
							'tbody_open'            => '<tbody>',
							'tbody_close'           => '</tbody>',
							'row_start'             => '<tr style="background-color:#ffffff00;border: 0px;">',
							'row_end'               => '</tr>',
							'cell_start'            => '<td style="background-color:#ffffff00;border: 0px;"">',
							'cell_end'              => '</td>',
							'table_close'         => '</table>'
						) );
						$this->table->set_heading(array_keys($currency_list_dbarraynow[0]));
						$htmldatadisplayallcurrencies = $this->table->generate($currency_list_dbarraynow);
					}
				}
				// https://www.codeigniter.com/userguide3/libraries/uri.html

				?>
	<!-- HOME BUTTONS CARD INI -->
		<div class="contain-image">
			<div class="card-deck d-flex justify-content-around  flex-wrap">
				<div class="card m-3" style="width: 300px;">
					<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
					<div class="card-body">
						<h5 class="card-title d-flex justify-content-center" style="font-size: 4.25rem;" >
							<span class="fi fi-ve"></span>
							<span class="fi fi-us"></span>
						</h5>
					</div>
					<div class="card-footer">
						<small class="text-muted">
								<i class="fi fi-ve"></i>
								<span class="ms-1 d-sm-inline">
									<?php
									foreach($currency_list_dbarraynow as $index=>$currencyindex)
									{
										$value = stripos($currencyindex['moneda_destino'], 'VES');
										if( $value !== FALSE)
										{
											echo number_format((float)$currencyindex['mon_tasa_moneda'], 2, ',', ''); break;
										}
									}
									?>
								</span>
							</a>
						</small>
					</div>
				</div>
				<div class="card m-3" style="width: 300px;">
					<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
					<div class="card-body">
						<h5 class="card-title d-flex justify-content-center"  style="font-size: 4.25rem;">
							<span class="fi fi-eu"></span>
							<span class="fi fi-us"></span>
						</h5>
					</div>
					<div class="card-footer">
						<small class="text-muted">
								<i class="fi fi-eu"></i>
								<span class="ms-1 d-sm-inline">
									<?php
									foreach($currency_list_dbarraynow as $index=>$currencyindex)
									{
										$value = stripos($currencyindex['moneda_destino'], 'EUR');
										if( $value !== FALSE)
										{
											echo number_format((float)$currencyindex['mon_tasa_moneda'], 2, ',', ''); break;
										}
									}
									?>
								</span>
							</a>
						</small>
					</div>
				</div>
				<div class="card m-3" style="width: 300px;">
					<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
					<div class="card-body">
						<h5 class="card-title d-flex justify-content-center"  style="font-size: 4.25rem;">
							<span class="fi fi-cn"></span> 
							<span class="fi fi-us"></span>
						</h5>
					</div>
					<div class="card-footer">
						<small class="text-muted">
								<i class="fi fi-cn"></i>
								<span class="ms-1 d-sm-inline">
									<?php
									foreach($currency_list_dbarraynow as $index=>$currencyindex)
									{
										$value = stripos($currencyindex['moneda_destino'], 'CNY');
										if( $value !== FALSE)
										{
											echo number_format((float)$currencyindex['mon_tasa_moneda'], 2, ',', ''); break;
										}
									}
									?>
								</span>
							</a>
						</small>
					</div>
				</div>
			</div>
		<!-- HOME BUTTONS CARD END -->
				<?php 
					echo heading('Your today all currency rates',3);
					echo div_open('');
						echo '<div>'.$htmldatadisplayallcurrencies.'</div>';
					echo div_close();
				?>
			</div>
		</section>
		<div class="row">
		
	<!-- <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>  -->
	<script>
		let baseUrl = "<?php echo site_url(); ?>";
		let uricall = baseUrl + '/Currency_Api';
		let user_st = "<?php echo $active; ?>";
		let user_id = "<?php echo $user_id; ?>";
		let tableId = '#table_id';
		let tableId2 = '#table_id2';
		let urlUpdateRateAmount = '/updateRateAmount'
		$(document).ready( function () 
		{
			// CREATE TABLE WITH DATATABLE
			function createDataTable(id){
				let table = $(id).DataTable(
				{
					order: [0], paging:true, searching:true,
					columnDefs: [ {title:'code',targets:0},{title:'base',targets:1},{title:'rate',targets:2},{title:'currency',targets:3} ]
				});
				return table
			}
			//let table1 = createDataTable(tableId)
			let table2 = createDataTable(tableId2)
			// EVENT TABLE EDIT 
			function addEventClickTable(id,table,url){
				$(id+' tbody').on('click', 'tr', function () 
					{
						var data = table.row(this).data()
						alert(data,'primary')
						let buttonEditData = document.getElementById("edit");
						let messageError = document.getElementById("error-message");
						buttonEditData.addEventListener("click",function(event)
							{
								event.preventDefault()
								let codTasa = document.getElementById("cod_tasa");
								let monTasaMoneda = document.getElementById("mon_tasa_moneda");
								let object = {
										method:'post',
										user_id:user_id,
										cod_tasa:codTasa.value,
										mon_tasa_moneda:monTasaMoneda.value
									}
								let button = document.getElementById('edit')
								$.ajax({
									type: 'post',
									url: uricall + url,
									data: object,
									success: function(result) 
									{
										let answer  = result.split('\n')
										answer = JSON.parse(answer[0])
										if(answer.result !== 1)
										{
											button.innerHTML = ['<i class="bi bi-x-octagon-fill" style="color: red;font-size: 25px;"></i>',]
											messageError.innerHTML=`${answer.result}`
										}
										else
										{
											button.innerHTML ='<i class="bi bi-check-circle" style="font-size: 25px;"></i>';
											button.addEventListener('click',function()
												{
													$('.alert').alert('close')
													location.reload()
												})
										}
									},
									error: function(result) 
									{
										button.innerHTML = '<i class="bi bi-x-octagon-fill" style="color: red;font-size: 25px;"></i>'
										button.addEventListener('click',function()
											{
												$('.alert').alert('close')
											})
									}
								});
							})
					});
			}
		if(user_st > 0)
		{
			/* table today prefered currencies data click on amount */
			//addEventClickTable(tableId,table1,urlUpdateRateAmount)
			/* table today all currencies data click on amount */
			addEventClickTable(tableId2,table2,urlUpdateRateAmount)
		}
		let buttonGetData = document.getElementById("button-call");
		buttonGetData.addEventListener('click',function()
			{
				let object = {
						method:'post',
						user_id:user_id,
						codkey:"<?php $this->load->config('currencyweb');echo $this->config->item('codkey');?>"
					}
				buttonGetData.innerHTML=['<div class="spinner-border" role="status">','<span class="visually-hidden">Loading...</span>','</div>']
				$.ajax({
					type: 'post',
					url: uricall + '/callApisAndSaveDB',
					data: object,
					success: function(result) 
						{
							let answer  = result.split('\n')
							answer = JSON.parse(answer[0])
							if(answer.result !== 1 ){
								return notificationError(answer.result,'danger')
							}
							buttonGetData.innerHTML=['<?php echo $buttonicon; ?>',]
							location.reload()
						},
					error: function(result) 
						{
							buttonGetData.innerHTML=['<i class="bi bi-x-octagon-fill" style="font-size: 30px;"></i>',]
							console.log(result)
						}
				});
			})
		})
		const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
		const alert = (message, type) => 
		{
			const wrapper = document.createElement('div')
			wrapper.innerHTML = 
				[
					`<div class="alert alert-${type} alert-dismissible text-center custom-alerts" role="alert" style="position: fixed; width: 55%; left: 30%; top: 30%; z-index: 10000000000;">`,
						'<br>',
						'<form class="" method="POST" action="<?php echo site_url() ?>/Currency_Manager/updatecurrency" target="_self" id="edit-form">', 
							'<div class="form-group">',
								'<label for="cod_tasa">cod_tasa</label>',
								'<input name="cod_tasa" type="number" class="form-control" id="cod_tasa" value='+message[0]+'  readonly>',
							'</div>',
							'<div class="form-group">',
								'<label for="mon_tasa_moneda">mon_tasa_moneda</label>',
								'<input name="mon_tasa_moneda" type="text" class="form-control" id="mon_tasa_moneda" placeholder='+ message[2] +' required>',
							'</div>',
							'<br>',
							'<button type="submit" class="btn btn-outline-success" id="edit">Enviar</button>',
						'</form>',
						'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"  ></button>',
						'<p id="error-message" style="color: red;font-size: 25px;"></p>',
					'</div>'
					
				].join('')
				alertPlaceholder.append(wrapper)
		}
		const alertError = document.getElementById('alert-errors')
		const notificationError = (message, type) => 
		{
			const wrapper = document.createElement('div')
			wrapper.innerHTML = 
				[
					`<div class="alert alert-${type} alert-dismissible text-center custom-alerts py-0 px-0" role="alert" style="   position: fixed; width: 55%; left: 30%; top: 1%; z-index: 10000000000;">`,
						'<br>',
						`<p>${message}</p>`,
						'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
						'<p id="error-message" style="color: red;font-size: 25px;"></p>',
					'</div>'
				].join('')
				alertError.append(wrapper)
		}
	</script>
</div>  



