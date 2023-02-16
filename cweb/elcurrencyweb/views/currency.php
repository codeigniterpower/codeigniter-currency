
	<div class="col py-1">
		<section>
			<div id="contain-modal">
				<!-- HERE IS THE DIALOG PLACE -->
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
					echo div_open('class="d-flex justify-content-end"');
						$contentbuttonapi = '<i class="bi bi-currency-exchange" style="font-size: 30px;"></i>';
						echo form_button('button-call', $contentbuttonapi, 'class="btn btn-outline-success" id="button-call"');
					echo div_close();
				}

				$htmldatadisplaymycurrencies = 'There is no data today, yet ..'.$htmldisplaymessageapibutton;
				if(is_array($currency_list_dbarraypre) )
				{
					if(count($currency_list_dbarraypre))
					{
						$this->table->clear();
						$this->table->set_template( array( 'table_open' => '<table id="table_id">',) );
						$this->table->set_heading(array_keys($currency_list_dbarraypre[0]));
						$htmldatadisplaymycurrencies = $this->table->generate($currency_list_dbarraypre);
					}
				}
				echo heading('Your preferred currency rates',2,'style="text-align: center"');
				echo div_open('');
					echo '<section>'.$htmldatadisplaymycurrencies.'</section>';
				echo div_close();

				$htmldatadisplayallcurrencies = 'The data of world currency rates today is not yet present.. '.$htmldisplaymessageapibutton;
				if(is_array($currency_list_dbarraynow))
				{
					if(count($currency_list_dbarraynow))
					{
						$this->table->clear();
						$this->table->set_template( array( 'table_open' => '<table id="table_id2">',) );
						$this->table->set_heading(array_keys($currency_list_dbarraynow[0]));
						$htmldatadisplayallcurrencies = $this->table->generate($currency_list_dbarraynow);
					}
				}
				echo heading('Your today all currency rates',2,'style="text-align: center"');
				echo div_open('');
					echo '<section>'.$htmldatadisplayallcurrencies.'</section>';
				echo div_close();
				?>
			</div>
		</section>
	</div>
	<script>
		let baseUrl = "<?php echo base_url(); ?>";
		let activeUser = "<?php echo $active ?>"

		$(document).ready( function () 
		{

			table1 = $('#table_id').DataTable (
				{
					order: [0]
				}
			);

			table2 = $('#table_id2').DataTable(
				{
					order: [0]
				}
			);

			if(activeUser)
			{

				/* table today prefered currencies data click on amount */

				$('#table_id tbody').on('click', 'tr', function () 
					{
						var data = table1.row(this).data()

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
										cod_tasa:codTasa.value,
										mon_tasa_moneda:monTasaMoneda.value
									}
								let button = document.getElementById('edit')

								$.ajax({
									type: 'post',
									url: "<?php echo site_url() ?>" + '/Currency_Manager/updatecurrency',
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

				/* table today all currencies data click on amount */

				$('#table_id2 tbody').on('click', 'tr', function () 
					{
						var data = table2.row(this).data()
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
										cod_tasa:codTasa.value,
										mon_tasa_moneda:monTasaMoneda.value
									}
								let button = document.getElementById('edit')

								$.ajax({
									type: 'post',
									url: "<?php echo site_url() ?>" + '/Currency_Manager/updatecurrency',
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

		let buttonGetData = document.getElementById("button-call");

		buttonGetData.addEventListener('click',function()
			{
				let object = {
						method:'post',
						id_user:'lenz_gerardo-userplace',
						codkey: "<?php $this->load->config('currencyweb');echo $this->config->item('codkey');?>"
					}
								
				buttonGetData.innerHTML=['<div class="spinner-border" role="status">','<span class="visually-hidden">Loading...</span>','</div>']

				$.ajax({
					type: 'get',
					url: "<?php echo site_url() ?>" + '/Currency_Manager/callapitodb/',
					data: object,
					success: function(result) 
						{
							buttonGetData.innerHTML=['<i class="bi bi-currency-exchange" style="font-size: 30px;"></i>',]
							location.reload()
						},
					error: function(result) 
						{
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
					'<div class="alert alert-${type} alert-dismissible text-center custom-alerts" role="alert" style="   position: fixed; width: 55%; left: 30%; top: 30%; z-index: 10000000000;">',
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
					'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
					'<p id="error-message" style="color: red;font-size: 25px;"></p>',
					'</div>'
				].join('')

				alertPlaceholder.append(wrapper)
		}

	</script>

