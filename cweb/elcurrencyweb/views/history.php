<div class="col py-3" >
  <div id="contain-modal"></div>
        <section>
          <div id="liveAlertPlaceholder"></div>
          <br>
        </section>
        <br>
        <div class="contain-table">
          <h1 style="text-align: center;">History of your coins rate</h1>
          <?php 
            echo '<h1 style="text-align: center;">Filtering total of '.$totalcount.'</h1>';
              if(is_array($currency_list_dbarrayhis))
              {
                if(count($currency_list_dbarrayhis))
                {
                  $this->table->clear();
                  $this->table->set_template( array( 'table_open' => '<table id="table_id">',) );
                  $this->table->set_heading(array_keys($currency_list_dbarrayhis[0]));
                  echo $this->table->generate($currency_list_dbarrayhis);
                }
                else
                  echo "There's not data stored today, check if your system already call the api in backend, or check if your DB is configured.";
              }
              echo br(2);
          ?>
        </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> 
  <script>
      $(document).ready( function () {
      // ---------------------------------------------------------------------------
      
        table1 = $('#table_id').DataTable(
          {
            "order": [0],
          }
        );
      })
    
      // ---------------------------------------------------------------------------
    
      $('#dateHistory').change(function() {
        let dateHistory = $(this).val();
        let object = {
          dateHistory:dateHistory
        }
        window.alert("hola")
          $.ajax({
                 url: "<?php echo site_url() ?>" + '/Currency_History/listcurrencies'+dateHistory,
                 success:function(result){
                      console.log(result)
                 },
                 error:function(result){
                  console.log(result)
                 }
            });
      });
    </script>
<?php 
/* ** GROCERYCRUP ONLY dont touch, this is same data but only if you used mysql
echo $output; 
foreach($css_files as $filecss){
	echo link_css($filecss);
}
foreach($js_files as $filejs){
	echo link_js($filejs);
}
*/
?>
