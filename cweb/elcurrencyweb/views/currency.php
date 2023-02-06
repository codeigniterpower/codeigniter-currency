<div class="col py-3" >
  <div id="contain-modal"></div>
        <section>
          <div id="liveAlertPlaceholder"></div>
          <br>
        </section>
        <br>
        <div class="contain-table">
          <?php 
              if(is_array($currency_list_dbarraynow))
              {
                if(count($currency_list_dbarraynow))
                {
                  echo '<h1 style="text-align: center;">Currenct Stored currency for today</h1>';
                  $this->table->clear();
                  $this->table->set_template( array( 'table_open' => '<table id="table_id">',) );
                  $this->table->set_heading(array_keys($currency_list_dbarraynow[0]));
                  echo $this->table->generate($currency_list_dbarraynow);
                }
                // else
                // <h1 style="text-align: center;">History of your coins rate</h1>
                  // echo "There's not data stored today, check if your system already call the api in backend, or check if your DB is configured.";
              }
              echo br(2);
          ?>
        </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> 
    <script>
       let baseUrl = "<?php echo base_url(); ?>";
      $(document).ready( function () {
      
        // ---------------------------------------------------------------------------
      
        table1 = $('#table_id').DataTable(
          {
            "order": [0]
          }
        );
        $('#table_id tbody').on('click', 'tr', function () {
          var data = table1.row(this).data()
          alert(data,'primary')

          let buttonEditData = document.getElementById("edit");

          buttonEditData.addEventListener("onclick",function(event){
            // event.preventDefault()
            let codTasa = document.getElementById("cod_tasa");
            let monTasaMoneda = document.getElementById("mon_tasa_moneda");
             let object = {
               method:'post',
               cod_tasa:codTasa.value,
               mon_tasa_moneda:monTasaMoneda.value
              }
            fetch("<?php echo site_url() ?>" + '/Currency_Manager/updatecurrency',{ 
              method: 'POST', 
              object
            })
            .then(data=>{

              console.log(data)
            })            
            .catch(error => console.log(error))
            .finally()
          })
          
          
        });
        
        
        // ---------------------------------------------------------------------------
        
         const containModal = document.getElementById('contain-modal')
         let divModal = document.createElement('div')         
         divModal.innerHTML = [
           ' <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">',
           '   <div class="modal-dialog">',
           '     <div class="modal-content">',
           '       <div class="modal-header">',
           '         <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>',
           '         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>',
           '       </div>',
           '       <div class="modal-body">',     
           '          <form>',
           '           <div class="input-group  mb-3">',
           '            <input type="date" name="date" style="width: 100%">  ',
          //  '                <select class="form-select" id="append-button-single-field" data-placeholder="Choose one thing">',
          //  '                    <option>Reactive</option>',
          //  '                    <option>Solution</option>',
          //  '                    <option>Conglomeration</option>',
          //  '                    <option>Algoritm</option>',
          //  '                    <option>Holistic</option>',
          //  '                    <option>Holistic</option>',
          //  '                    <option>Solution</option>',
          //  '                    <option>Conglomeration</option>',
          //  '                    <option>Algoritm</option>',
          //  '                    <option>Holistic</option>',
          //  '                    <option>Holistic</option>',
          //  '                    <option>Holistic</option>',
          //  '                    <option>Holistic</option>',
          //  '                </select>',
           '           </div>',
           '          </form>',
           '          <small id="count" class="form-text text-muted"></small>',

           '       </div>',
           '        <div class="modal-footer">',
           '          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>',
           '          <button type="button" class="btn btn-primary"  id="button">Understood</button>',
           '        </div>',
           '      </div>',
           '    </div>',
           '  </div>'
         ].join('')
        
         containModal.append(divModal)
         $('#staticBackdrop').modal('show');

         $(selector).datepicker("method-name",[value]);

         let buttonGetData = document.getElementById("button");

      })
    
      // ---------------------------------------------------------------------------
    
       const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
       const alert = (message, type) => {
       const wrapper = document.createElement('div')
         wrapper.innerHTML = [
           `<div class="alert alert-${type} alert-dismissible text-center custom-alerts" role="alert" style="   position: fixed; width: 55%; left: 30%; top: 30%; z-index: 10000000000;">`,
           '<br>',
           `<form method="POST" action="<?php echo site_url() ?>/Currency_Manager/updatecurrency" target="_self" id="edit-form">`, 
             '<div class="form-group">',
               '<label for="cod_tasa">cod_tasa</label>',
               '<input name="cod_tasa" type="number" class="form-control" id="cod_tasa" placeholder='+ message[0] +' >',
             '</div>',
             '<div class="form-group">',
               '<label for="mon_tasa_moneda">mon_tasa_moneda</label>',
               '<input name="mon_tasa_moneda" type="text" class="form-control" id="mon_tasa_moneda" placeholder='+ message[2] +' >',
             '</div>',
             '<br>',
             '<button type="submit" class="btn btn-outline-success" id="edit">Enviar</button>',
           '</form>',
           '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
           '</div>'
         ].join('')
         alertPlaceholder.append(wrapper)
        }

        //uttonEditData.addEventListener(function(){
          // fetch(baseUrl+'Currency_Manager/savecurrency',{ 
          //   method: 'POST', 
          //   body
          // })
          // .then()
          // .catch()
          // .finally()
        //})

      //  function watch(){
      //   let n = 0;
      //    window.setInterval(function(){
      //        l.innerHTML = n+' S';
      //      n++;
      //      if(n>3){
      //          return window.clearInterval()
      //      }
      //      console.log(n)

      //    },1000);


      //  }

 

    </script>
      </div>
    </div>  
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>
