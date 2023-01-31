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
                <br>
                <div class="contain-table">
                              <h1 style="text-align: center;">History of your coins rate</h1>
                                <?php 
									if(is_array($currency_list_dbarray)){
										$this->table->clear();
                                  $this->table->set_heading(array_keys($currency_list_dbarray[0]));
                                  echo $this->table->generate($currency_list_dbarray);
									}
                                ?>
                                <?php 
                                echo br(3);
                                echo '<h1 style="text-align: center;">Current currency rate for today</h1>';

                                  $compare = true;
                                  if(is_array($currency_list_apiarray) AND $compare){
										$this->table->clear();
									$this->table->set_heading(array_keys($currency_list_apiarray[0]));
									echo $this->table->generate($currency_list_apiarray);
								}
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

            
      </div>
    </div>  
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>
