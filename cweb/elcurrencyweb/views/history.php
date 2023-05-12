<?php
	$titleini = 'History of your coins rate';
	$titlesub = 'Filtering total of ';
	echo div_open('class="col py-3 d-flex contain-history contain-min"');
		echo '<section>';
			echo div_open('id="liveAlertPlaceholder"');
			echo div_close();
		echo '</section>';
		echo div_open('class="contain-table"');
			echo heading($titleini,2,'');
			echo heading($titlesub.' '.$totalcount,3,'');
				if(is_array($currency_list_dbarrayhis))
				{
					if(count($currency_list_dbarrayhis))
					{
						$this->table->clear();
						$this->table->set_template( array( 
							'table_open' => '<table id="table_id">',
							'heading_row_start'     => '<tr style="background-color:#ffffff00;">',
							'heading_row_end'       => '</tr>',
							'heading_cell_start' => '<th style="border-bottom:0">',
							'heading_cell_end'      => '</th>',
							'tbody_open'            => '<tbody>',
							'tbody_close'           => '</tbody>',
							'row_start'             => '<tr style="background-color:#ffffff00;border-radius: 0px;">',
							'row_end'               => '</tr>',
							'cell_start'            => '<td style="background-color:#ffffff00;border-radius: 0px;">',
							'cell_end'              => '</td>',
							
							)
					);
						$this->table->set_heading(array_keys($currency_list_dbarrayhis[0]));
						$htmlhistorydata = $this->table->generate($currency_list_dbarrayhis);
					}
					else
						$htmlhistorydata = 'There is not data stored today, check if your system already call the api in backend, or check if your DB is configured.';
				}
				echo $htmlhistorydata;
		echo div_close();
	// echo div_close();
	$srcscript1 = "
		$(document).ready ( 
			function () {
				table1 = $('#table_id').DataTable (
					{
						order: [0], paging:true, searching:true,
						columnDefs: [ {visible:false,targets:5},{visible:false,targets:6},{visible:false,targets:7},{title:'code',targets:0},{title:'base',targets:1},{title:'rate',targets:2},{title:'currency',targets:3} ]
					}
				);
			}
		)
	";
	echo src_scrip($srcscript1);
	?>
	
	<div class="row"> 

<!-- /* 
 // GROCERYCRUP ONLY dont touch, this is same data but only if you used mysql
 // uncomment only if the controller uses grocery crud
echo $output; 
foreach($css_files as $filecss){
	echo link_css($filecss);
}
foreach($js_files as $filejs){
	echo link_js($filejs);
}
*/ -->
