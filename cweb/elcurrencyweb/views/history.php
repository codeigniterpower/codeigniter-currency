        <div class="col py-3">
                <!-- <div class="container-pagination d-flex justify-content-between">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                          <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                              <span aria-hidden="true">&laquo;</span>
                            </a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                              <span aria-hidden="true">&raquo;</span>
                            </a>
                          </li>
                        </ul>
                      </nav>



                      <form>
                        <div class="form-group">
                          <label for="exampleFormControlInput1">Seek</label>
                          <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="seek">
                        </div>
                      </form>
                </div> -->
                <section>
                  <div id="liveAlertPlaceholder"></div>
                  <br>
                  <div class="d-flex w-100">
                    
                    <!-- <form class="d-flex m-auto "> -->
                      <!-- <div class="form-group"> -->
                        <!-- <label for="seek">Email address</label> -->
                        <!-- <input type="text" class="form-control" id="input-seek" placeholder="VES"> -->
                        <!-- <small id="coin" class="form-text text-muted">Introduzca </small> -->
                      <!-- </div> -->
                      <!-- <button type="submit" id="seek" class="btn btn-outline-success ms-2">Solucitar</button> -->
                    <!-- </form> -->
                  <!-- </div> -->
                  <!-- <h1 class="text-center" id="search">TEXT</h1> -->
                </section>
          

                <script>

                </script>
                <br>
                <div class="contain-table">
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

                    <!-- <br>
                  <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                        </a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                        </a>
                      </li>
                    </ul>
                  </nav> -->
                <!-- colocar contenido -->
        </div>
        <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> 

  <script>
      let table = $(document).ready( function () {
        table1 = $('#table_id').DataTable(
          {
            "order": [0],
          }
        );

          $('#table_id tbody').on('click', 'tr', function () {
            var data = table1.row(this).data();
          // console.log(data)
            alert(data,'primary');
          });
       } );
       
  </script>
            


            <script>
                    let data = <?php echo json_encode($currency_list_dbarray); ?>;

                  // console.log(data)
                  // let input = document.getElementById("input-seek");
                  // let answer =""
                  // let seek = document.getElementById("seek");
                  // if(seek ){
                  //   seek.addEventListener('click', () => {
                  //     if(answer.hasOwnProperty('base')){
                  //       alert(answer, 'success')
                  //     }
                  //    })
                  //   seek.addEventListener('click', function(e){
                  //     e.preventDefault()
                  //     if(input.value.length > 0){
                  //       answer = data.find(tasa => tasa.base === input.value)
                  //     }
                  //   },true ) ;
                  // }
                  // ,'even'

                  // console.log(tr)
                  const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
                  const alert = (message, type) => {
                    const wrapper = document.createElement('div')

                    
                    wrapper.innerHTML = [
                      `<div class="alert alert-${type} alert-dismissible text-center custom-alerts" role="alert" style="   position: fixed; width: 55%; left: 30%; top: 30%; z-index: 10000000000;">`,
                      '<br>',
                      `<form">`, 
                        //'<div class="form-group">',
                        //  '<label for="exampleInputEmail1">COD_TASA</label>',
                        // '<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder='+ message[0] +'>',
                        // `<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>`,
                        //'</div>',
                        '<div class="form-group">',
                          '<label for="exampleInputPassword1">MON_TASA_MONEDA</label>',
                          '<input type="text" class="form-control" id="exampleInputPassword1" placeholder='+ message[1] +' >',
                        '</div>',
                        //'<div class="form-group">',
                        //  '<label for="exampleInputPassword1">BASE</label>',
                        //  '<input type="text" class="form-control" id="exampleInputPassword1" placeholder='+ message[2] +'>',
                        //'</div>',
                        //'<div class="form-group">',
                        // '<label for="exampleInputPassword1">MONEDA</label>',
                        //  '<input type="text" class="form-control" id="exampleInputPassword1" placeholder='+ message[0] +'>',
                        // '</div>',
                        '<br>',
                        '<button type="submit" class="btn btn-outline-success">Enviar</button>',
                      '</form>',
                      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                      '</div>'
                    ].join('')
                    
                    alertPlaceholder.append(wrapper)
                  }

                  // let tr = document.getElementsByClassName('odd')
                  // for (let i = 0; i < tr.length; i++) {
                    // tr[0].addEventListener('click',function(){
                      // alert(answer, 'success')
                    // },true)
                    
                  // }
                </script> 
                  
      </div>
    </div>  
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>
