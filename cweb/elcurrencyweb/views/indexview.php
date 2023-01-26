<h3>Sistema modular ERP купить (version 1.0) modulo recibo de pago</h3><br>
<?php

	$userurl = $this->input->get_post('userurl');
	?>

			<div class="container">
				<div class="row">
					<div style="border: thin solid black" class="col-md-4 editContent" data-selector="Footer" style=""><h4 data-selector="Footer">1 - Bienvenido, instrucciones</h4>
						<hr>
						<h3>Esta es la aplicacion de consulta de recibo de pagos, aqui ud podra consultar sus recibos de pagos segunla ley, si tiene algun reclamo, debe ser enviando correo a soporte pro la intranet, no se aceptara otro medio, para mayores consulte con la gerencia de Recursos Humanos.</h3>
					</div>
					<div style="border: thin solid black" class="col-md-4 editContent" data-selector="Footer" style=""><h4 data-selector="Footer">2 - Escoja "Mis Recibos"</h4>
						<hr>
						<h3>Debe pulsar en el boton o menu de "RECIBOS" y alli en el submenu escoger el modulo de "Mis_Recibos", Este lo llevara a la interfaz para escoger que recibo de pago quiere consultar.</h3>
						<?php 
								$htmlformaattributos = array('name'=>'formulariologin','onSubmit'=>'return validageneric(this);');
								echo form_open('recibos/mis_recibos', $htmlformaattributos) . PHP_EOL;
								echo form_hidden('userurl',$userurl).PHP_EOL;
								echo '<strong>LEER BIEN LAS INSTRUCCIONES</strong>.'.PHP_EOL;
								echo form_submit('login', 'Mis Recibos', 'class="btn-primary btn"');
								echo form_close() . PHP_EOL;
						?>
					</div>
					<div style="border: thin solid black" class="col-md-4 editContent" data-selector="Footer" style=""><h4 data-selector="Footer">3 - Escogiendo el recibo</h4>
						<hr>
						<h3>Ingrese el numero de su documento de identificacion, no importa si es extranjero o no, despues de pulsar el boton de consultar, se le presentara los recibos disponibles segun su periodo laboral, Cada uno tiene un boton para pulsar y ser previsualizado.</h3>
					</div>
				</div>
			</div>
    
