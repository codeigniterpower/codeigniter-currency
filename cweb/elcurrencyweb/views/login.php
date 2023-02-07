<div class="contain-login d-flex">
            <div class="contain-fund d-flex justify-content-center align-items-center">
                    <h1 class="text-white display-1" style="font-family: cursive;">Currency</h1> 
            </div>
            <div class="mx-auto my-auto">
                            <?php echo form_open('', array('method'=> 'post', 'class' => 'needs-validation')); ?>
                            <h1 class="text-dark display-1 text-center" style="font-family: cursive;">Currency</h1> 
                            <div class="form-group">
                                <?php echo form_label('Email / Gmail', 'exampleInputEmail1'); 
                                echo form_input(array('type'=>'email', 'class'=>'form-control','id'=>'exampleInputEmail1', 'aria-describedby'=>'emailHelp', 'placeholder'=>'Example@gmail.com', 'required') );?>
                            </div><br>
                            <div class="form-group">
                                <?php  echo form_label('Contraseña', 'exampleInputPassword1'); 
                                echo form_input(array('type'=>'password', 'class'=>'form-control','id'=>'exampleInputPassword1', 'placeholder'=>'contraseña', 'required') );?>
                                <div class="valid-tooltip invalid-feedback">
                                    Looks good!
                                </div>
                            </div><br>
                            <?php echo form_submit('submit', 'Enviar' , array('class'=>'btn btn-outline-success w-100'));
                            echo form_close();?>

                
                <!-- <form class="needs-validation">
                    <h1 class="text-dark display-1 text-center" style="font-family: cursive;">Currency</h1> 
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email / Gmail</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Example@gmail.com" required >
                    </div><br>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" class="form-control " id="exampleInputPassword1" placeholder="contraseña" required>
                        <div class="valid-tooltip invalid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-outline-success w-100" >Enviar</button>
                </form> -->
            </div>
</div>