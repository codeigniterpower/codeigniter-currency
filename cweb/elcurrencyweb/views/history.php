<div class="col py-3" >
  <div id="contain-modal"></div>
        <section>
          <div id="liveAlertPlaceholder"></div>
          <br>
        </section>
        <br>
        <div class="contain-table">
          <h1 style="text-align: center;">History of your coins rate</h1>
          <div class="w-75 m-auto">
            <form>
              <div class="mb-3">
                <!-- <label for="date" class="form-label">Email address</label> -->
                <input type="datetime-local" class="form-control" name="dateHistory" id="dateHistory"   >
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
              </div>
              <!-- <div class="d-flex justify-content-center mb-3 ">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div> -->
            </form>
          </div>

          <?php 
            echo '<h1 style="text-align: center;">Currenct Stored currency for today</h1>';
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
    <!-- <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
      integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script> -->
  
  <script>
      $(document).ready( function () {
        // ---------------------------------------------------------------------------
      
        table1 = $('#table_id').DataTable(
          {
            "order": [0],
          }
        );
        // $('#table_id tbody').on('click', 'tr', function () {
        //   var data = table1.row(this).data();
        //   alert(data,'primary');
        // });

        // ---------------------------------------------------------------------------
      
        // const containModal = document.getElementById('contain-modal')
        // let divModal = document.createElement('div')         
        // divModal.innerHTML = [
        //   ' <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">',
        //   '   <div class="modal-dialog">',
        //   '     <div class="modal-content">',
        //   '       <div class="modal-header">',
        //   '         <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>',
        //   '         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>',
        //   '       </div>',
        //   '       <div class="modal-body">',     
        //   '          <form>',
        //   '           <div class="input-group  mb-3">',
        //   '                <select class="form-select" id="append-button-single-field" data-placeholder="Choose one thing">',
        //   '                    <option>Reactive</option>',
        //   '                    <option>Solution</option>',
        //   '                    <option>Conglomeration</option>',
        //   '                    <option>Algoritm</option>',
        //   '                    <option>Holistic</option>',
        //   '                    <option>Holistic</option>',
        //   '                    <option>Solution</option>',
        //   '                    <option>Conglomeration</option>',
        //   '                    <option>Algoritm</option>',
        //   '                    <option>Holistic</option>',
        //   '                    <option>Holistic</option>',
        //   '                    <option>Holistic</option>',
        //   '                    <option>Holistic</option>',
        //   '                </select>',
        //   '           </div>',
        //   '          </form>',
        //   '       </div>',
        //   '        <div class="modal-footer">',
        //   '          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>',
        //   '          <button type="button" class="btn btn-primary">Understood</button>',
        //   '        </div>',
        //   '      </div>',
        //   '    </div>',
        //   '  </div>'
        // ].join('')
        
        // containModal.append(divModal)
        // $('#staticBackdrop').modal('show');
      })
    
      // ---------------------------------------------------------------------------
    
      // const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
      // const alert = (message, type) => {
      // const wrapper = document.createElement('div')
      //   wrapper.innerHTML = [
      //     `<div class="alert alert-${type} alert-dismissible text-center custom-alerts" role="alert" style="   position: fixed; width: 55%; left: 30%; top: 30%; z-index: 10000000000;">`,
      //     '<br>',
      //     `<form">`, 
      //       '<div class="form-group">',
      //         '<label for="exampleInputPassword1">MON_TASA_MONEDA</label>',
      //         '<input type="text" class="form-control" id="exampleInputPassword1" placeholder='+ message[1] +' >',
      //       '</div>',
      //       '<br>',
      //       '<button type="submit" class="btn btn-outline-success">Enviar</button>',
      //     '</form>',
      //     '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
      //     '</div>'
      //   ].join('')
      //   alertPlaceholder.append(wrapper)
      // }
      
      $('#dateHistory').change(function() {
        let dateHistory = $(this).val();
        let object = {
          dateHistory:dateHistory
        }
        window.alert("hola")
        // console.log(dateHistory, 'change')
          $.ajax({
                //  type: 'get',
                 url: "<?php echo site_url() ?>" + '/Currency_History/listcurrencies'+dateHistory,
                 success:function(result){
                      console.log(result)
                 },
                 error:function(result){
                  console.log(result)
                 }
                //  data: object,
                //  success: function(result) {
                //   let answer  = result.split('\n')
                //   button.innerHTML = '<i class="bi bi-check-circle" style="font-size: 25px;"></i>'
                //   button.addEventListener('click',function(){
                //     $('.alert').alert('close')
                //   })
                // },
                // error: function(result) {
                //   button.innerHTML = '<i class="bi bi-x-octagon-fill" style="color: red;font-size: 25px;"></i>'
                //   button.addEventListener('click',function(){
                //     $('.alert').alert('close')
                //   })
                //  }
            });
          
        // fetch("<?php //echo site_url() ?>" + '/Currency_History/listcurrencies'+dateHistory,{ 
        //   method: 'POST', 
        //   object
        // }).then(data=>{
        //       window.alert(dateHistory)
              
        //     }).catch(error=>{
  
        //     }).finally()

      });


    </script>
      </div>
    </div>  
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>