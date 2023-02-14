<?php
	$titleini = 'History of your coins rate';
	$titlesub = 'Filtering total of ';
	echo div_open('class="col py-3"');
		echo '<section>';
			echo div_open('id="liveAlertPlaceholder"');
			echo div_close();
		echo '</section>';
		echo div_open('class="contain-table"');
			echo heading($titleini,2,'style="text-align: center"');
			echo heading($titlesub.' '.$totalcount,3,'style="text-align: center"');
				if(is_array($currency_list_dbarrayhis))
				{
					if(count($currency_list_dbarrayhis))
					{
						$this->table->clear();
						$this->table->set_template( array( 'table_open' => '<table id="table_id">',) );
						$this->table->set_heading(array_keys($currency_list_dbarrayhis[0]));
						$htmlhistorydata = $this->table->generate($currency_list_dbarrayhis);
					}
					else
						$htmlhistorydata = "There's not data stored today, check if your system already call the api in backend, or check if your DB is configured.";
				}
				echo $htmlhistorydata;
		echo div_close();
	echo div_close();
/* 
 // GROCERYCRUP ONLY dont touch, this is same data but only if you used mysql
 // uncomment only if the controller uses grocery crud
echo $output; 
foreach($css_files as $filecss){
	echo link_css($filecss);
}
foreach($js_files as $filejs){
	echo link_js($filejs);
}
*/
?>
	<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> 
	<script>
		$(document).ready ( 
			function () {
				table1 = $('#table_id').DataTable (
					{
						"order": [0],
					}
				);
			}
		)
	</script>
