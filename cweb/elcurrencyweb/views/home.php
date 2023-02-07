  <!-- TODO: moved to currency history, this view will be for marketing -->
      <div class="col py-0 px-0">
        <div class="contain-image">
            <ul class="nav justify-content-center">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">
                  <button type="button" class="btn btn-outline-success">¿Quienes somos?</button>
                </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="#">
                <button type="button" class="btn btn-outline-success">Donaciones</button>
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="#">
                <button type="button" class="btn btn-outline-success">Documentacion</button>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="#">
                <button type="button" class="btn btn-outline-success">Sugerencias</button>
              </a>
            </li> -->
          </ul>
        </div>    
        <br>

        <section class="descriptions-contains">
                <div class="whoUs" style="width: 95%; margin: auto;">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus odit id, quidem temporibus distinctio quae consequuntur provident autem perferendis! Distinctio delectus enim provident asperiores obcaecati recusandae commodi molestias at ex!</p>
                </div>
                <div class="documentation">
                  <div class="contain-toggle">
                    <button class="btn text-start btn-outline-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                      Get
                    </button>
                  </div>
                  <div>
                    <div class="collapse collapse-horizontal" id="collapse1">
                      <div class="card card-body">
                        This is some placeholder content for a horizontal collapse. It's hidden by default and shown when triggered.
                      </div>
                    </div>
                  </div>

                  <div class="contain-toggle">
                    <button class="btn text-start btn-outline-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                      Get
                    </button>
                  </div>
                  <div >
                    <div class="collapse collapse-horizontal" id="collapse2">
                      <div class="card card-body">
                        This is some placeholder content for a horizontal collapse. It's hidden by default and shown when triggered.
                      </div>
                    </div>
                  </div>

                  <div class="contain-toggle">
                    <button class="btn text-start btn-outline-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                      GET
                    </button>
                  </div>
                  <div >
                    <div class="collapse collapse-horizontal" id="collapse3">
                      <div class="card card-body">
                        This is some placeholder content for a horizontal collapse. It's hidden by default and shown when triggered.
                      </div>
                    </div>
                  </div>
                  <div class="contain-toggle">
                    <button class="btn text-start btn-outline-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                      POST                      
                    </button>
                  </div>
                  <div >
                    <div class="collapse collapse-horizontal" id="collapse4">
                      <div class="card card-body">
                        This is some placeholder content for a horizontal collapse. It's hidden by default and shown when triggered.
                      </div>
                    </div>
                  </div>
                  <div class="contain-toggle">
                    <button class="btn text-start btn-outline-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                      UPDATE
                    </button>
                  </div>
                  <div class="contain-toggle">
                    <div class="collapse collapse-horizontal" id="collapse5">
                      <div class="card card-body">
                        This is some placeholder content for a horizontal collapse. It's hidden by default and shown when triggered.
                      </div>
                    </div>
                  </div>
                </div>
                <br>
        </section>

        
        <div class="fab-container position-fixed">
          <div class="fab shadow">
            <div class="fab-content">
              <span class="material-icons">Contact us</span>
            </div>
          </div>
          <!-- <div class="sub-button shadow">
            <a href="google.com" target="_blank">
              <span class="material-icons">phone</span>
            </a>
          </div> -->
          <!-- <div class="sub-button shadow">
            <a href="google.com" target="_blank">
              <span class="material-icons">mail_outline</span>
            </a>
          </div> -->
          <div class="sub-button shadow">
            <a href="google.com" target="_blank">
              <span class="material-icons"><i class="bi bi-envelope"></i></span>
            </a>
          </div>
          <!-- <div class="sub-button shadow">
            <a href="google.com" target="_blank">
              <span class="material-icons">help_outline</span>
            </a>
          </div> -->
      </div>

      </div>
        
    </div>  
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>
