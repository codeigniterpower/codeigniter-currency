<div class="col py-3" >
  <div id="contain-modal"></div>
        <section>
          <div id="liveAlertPlaceholder"></div>
          <br>
        </section>
        <br>
        <div class="contain-table">
                  <?php 
                    if($active){
                      echo ' <div class="d-flex justify-content-end">';
                      echo '<button type="button" class="btn btn-outline-success" id="button-call"><i class="bi bi-currency-exchange" style="font-size: 30px;"></i></button>';
                      echo '</div>';
                    }
                  ?>
          <?php 
              echo br(2);
              if(is_array($currency_list_dbarraypre) )
              {
                if(count($currency_list_dbarraypre))
                {
                  echo '<h1 style="text-align: center;">Your preferences currencies</h1>';
                  $this->table->clear();
                  $this->table->set_template( array( 'table_open' => '<table id="table_id">',) );
                  $this->table->set_heading(array_keys($currency_list_dbarraypre[0]));
                  echo $this->table->generate($currency_list_dbarraypre);
                }
              }
              echo br(2);

              if(is_array($currency_list_dbarraynow))
              {
                if(count($currency_list_dbarraynow))
                {
                  echo '<h1 style="text-align: center;">Currenct Stored currency for today</h1>';
                  $this->table->clear();
                  $this->table->set_template( array( 'table_open' => '<table id="table_id2">',) );
                  $this->table->set_heading(array_keys($currency_list_dbarraynow[0]));
                  echo $this->table->generate($currency_list_dbarraynow);
                }
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
        let activeUser = "<?php echo $active ?>"

        table1 = $('#table_id').DataTable(
          {
            "order": [0]
          }
        );

      if(activeUser){
        $('#table_id tbody').on('click', 'tr', function () {
          var data = table1.row(this).data()
          alert(data,'primary')

          let buttonEditData = document.getElementById("edit");

          let messageError = document.getElementById("error-message");
          buttonEditData.addEventListener("click",function(event){
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
                 success: function(result) {
                  let answer  = result.split('\n')
                  answer = JSON.parse(answer[0])
                  if(answer.result !== 1){
                    button.innerHTML = [
                      '<i class="bi bi-x-octagon-fill" style="color: red;font-size: 25px;"></i>',
                    ]
                    messageError.innerHTML=`${answer.result}`

                  }else{
                    button.innerHTML ='<i class="bi bi-check-circle" style="font-size: 25px;"></i>';
                    button.addEventListener('click',function(){
                      $('.alert').alert('close')
                      location.reload()
                    })
                  }
                },

                error: function(result) {
                  button.innerHTML = '<i class="bi bi-x-octagon-fill" style="color: red;font-size: 25px;"></i>'
                  button.addEventListener('click',function(){
                    $('.alert').alert('close')
                  })
                 }
            });
          
          })
          
          
        });
      }
        
        
        // ---------------------------------------------------------------------------


        table2 = $('#table_id2').DataTable(
          {
            "order": [0]
          }
        );
      if(activeUser){

        $('#table_id2 tbody').on('click', 'tr', function () {
          var data = table2.row(this).data()
          alert(data,'primary')

          let buttonEditData = document.getElementById("edit");
          let messageError = document.getElementById("error-message");

          buttonEditData.addEventListener("click",function(event){
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
                 success: function(result) {
                  let answer  = result.split('\n')
                  answer = JSON.parse(answer[0])
                  if(answer.result !== 1){
                    button.innerHTML = [
                      '<i class="bi bi-x-octagon-fill" style="color: red;font-size: 25px;"></i>',
                    ]
                    messageError.innerHTML=`${answer.result}`

                  }else{
                    button.innerHTML ='<i class="bi bi-check-circle" style="font-size: 25px;"></i>';
                    button.addEventListener('click',function(){
                      $('.alert').alert('close')
                      location.reload()
                    })
                  }
                },

                error: function(result) {
                  button.innerHTML = '<i class="bi bi-x-octagon-fill" style="color: red;font-size: 25px;"></i>'
                  button.addEventListener('click',function(){
                    $('.alert').alert('close')
                  })
                 }
            });
          
          })
        });

      }



        // ---------------------------------------------------------------------------

            let buttonGetData = document.getElementById("button-call");
            buttonGetData.addEventListener('click',function(){
            buttonGetData.innerHTML=[
              '<div class="spinner-border" role="status">',
                '<span class="visually-hidden">Loading...</span>',
              '</div>'
            ]
            $.ajax({
                type: 'get',
                url: "<?php echo site_url() ?>" + '/Currency_Manager/callapitodb/'+"<?php $this->load->config('currencyweb');echo $this->config->item('codkey');?>",
                success: function(result) {
                   buttonGetData.innerHTML=[
                      '<i class="bi bi-currency-exchange" style="font-size: 30px;"></i>',
                  ]
                  location.reload()
               },
               error: function(result) {
                 console.log(result)
                }
            });
          })

      })
    
      // ---------------------------------------------------------------------------
    
       const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
       const alert = (message, type) => {
       const wrapper = document.createElement('div')
         wrapper.innerHTML = [
           `<div class="alert alert-${type} alert-dismissible text-center custom-alerts" role="alert" style="   position: fixed; width: 55%; left: 30%; top: 30%; z-index: 10000000000;">`,
           '<br>',
           `<form class="" method="POST" action="<?php echo site_url() ?>/Currency_Manager/updatecurrency" target="_self" id="edit-form">`, 
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

