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
                    
                    <form class="d-flex m-auto ">
                      <div class="form-group">
                        <!-- <label for="seek">Email address</label> -->
                        <input type="text" class="form-control" id="input-seek" placeholder="VES">
                        <small id="coin" class="form-text text-muted">Introduzca </small>
                      </div>
                      <button type="submit" id="seek" class="btn btn-outline-success ms-2">Solucitar</button>
                    </form>
                  </div>
                  <!-- <h1 class="text-center" id="search">TEXT</h1> -->
                </section>
          

                <script>

                </script>
                <br>
                <div class="contain-table">
                  <?php 
					echo '<h1 style="text-align: center;">Currenct Stored currency for today</h1>';
						if(is_array($currency_list_dbarraynow))
						{
							if(count($currency_list_dbarraynow))
							{
								$this->table->clear();
								$this->table->set_heading(array_keys($currency_list_dbarraynow[0]));
								echo $this->table->generate($currency_list_dbarraynow);
							}
							else
								echo "There's not data stored today, check if your system already call the api in backend, or check if your DB is configured.";
						}
						echo br(2);
					echo '<h1 style="text-align: center;">Current currency rate for today</h1>';
						$compare = true;
						if(is_array($currency_list_apiarray) AND $compare)
						{
							if(count($currency_list_apiarray))
							{
								$this->table->clear();
								$this->table->set_template( array( 'table_open' => '<table id="table_id2">',) );
								$this->table->set_heading(array_keys($currency_list_apiarray[0]));
								echo $this->table->generate($currency_list_apiarray);
							}
							else
								echo "There's not data received from API lib, please check your internet connection or if you already setup the API exchange call in the system installation";
						}
                  ?>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> 

                <script>
                    $(document).ready( function () {
                          $('#table_id2').DataTable();
                    } );
                  // let data = <?php //echo json_encode($currency_list_apiarray); ?>;
                  // let input = document.getElementById("input-seek");
                  // let answer =""
                  // let seek = document.getElementById("seek");
                  // if(seek ){
                  //   seek.addEventListener('click', () => {
                  //     if(answer.hasOwnProperty('MONEDA')){
                  //       alert(answer, 'success')
                  //     }
                  //    })
                  //   seek.addEventListener('click', function(e){
                  //     e.preventDefault()
                  //     if(input.value.trim().length > 0){
                  //       answer = data.find(tasa => tasa.MON_TASA_MONEDA === input.value.toUpperCase())
                  //     }
                  //   },true ) ;
                  // }
                  // const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
                  // const alert = (message, type) => {
                  //   const wrapper = document.createElement('div')
                  //   wrapper.innerHTML = [
                  //     `<div class="alert alert-${type} alert-dismissible text-center" role="alert">`,
                  //     `   <div>${message.MONEDA}</div>`,
                  //     '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                  //     '</div>'
                  //   ].join('')
                    
                  //   alertPlaceholder.append(wrapper)
                  // }
                </script> 
                  
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

            
      </div>
    </div>  
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>
