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
      </div>
    </div>  
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>
