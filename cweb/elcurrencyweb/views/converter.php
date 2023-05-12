<div class="col py-1 d-flex contain-converter contain-min">
    <section>
		<div id="alert-errors">
			<!-- HERE IS THE NOTIFICATION -->
		</div>
	</section>
    <div class="form-inline py-3 px-3"   style="
    width: 250px;margin: auto; 
    border-radius: 15px;
    background-color: white;
    -webkit-box-shadow: -1px 7px 5px -3px rgb(107 104 107 / 64%);
    -moz-box-shadow: -1px 7px 5px -3px rgba(107, 104, 107, 0.64);
    box-shadow: -1px 7px 5px -3px rgb(107 104 107 / 64%);
    ">
        <div class="form-group">
            <label for="exampleInputPassword1">Mount</label>
            <input type="number" class="form-control" id="mount">
        </div>
        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Preference</label>
        <?php 
            echo div_open('class="form-group"');
                echo form_dropdown('cod_base',$cod_base_currency_array,$cod_base_currency,'class="form-select form-select-lg mb-3" id="cod_base"');
            echo div_close();
                echo form_label('Convert to');
            echo div_open('class="form-group"');
                echo form_dropdown('cod_base_convert',$cod_base_currency_array,$cod_base_currency,'class="form-select form-select-lg mb-3" id="cod_base_convert"' );
            echo div_close();
        ?>
        <!-- <div class="custom-control custom-checkbox my-1 mr-sm-2">
            <input type="checkbox" class="custom-control-input" id="customControlInline">
            <label class="custom-control-label" for="customControlInline">Remember my preference</label>
        </div> -->
        <div class="contain-button d-flex justify-content-center" >
            <button type="submit" class="btn btn-outline-primary my-1 w-100" id="button-call" >Submit</button>
        </div>
        <br>
        <div class="contain-anser text-center">
            <p id="answer-text"></p>
        </div>
</div>
	<!-- <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>  -->
    <!-- convertCurrency -->
    <script>
        let baseUrl = "<?php echo site_url(); ?>";
        let buttonGetData = document.getElementById("button-call");
        buttonGetData.addEventListener('click',function(e)
			{
                e.preventDefault()
                let mount = document.getElementById('mount')
                let cod_base = document.getElementById('cod_base')
                let cod_base_convert = document.getElementById('cod_base_convert')
                let answer_text = document.getElementById('answer-text')
                obj={
                    curmont: mount.value,
                    curbase: cod_base.value,    
                    curdest: cod_base_convert.value,
                    user_id:'gonzalez_angel',
                    codkey:"<?php $this->load->config('currencyweb');echo $this->config->item('codkey');?>"
                }
                $.ajax({
					type: 'post',
					url:  baseUrl + '/Currency_Api/convertCurrency',
					data: obj,
					success: function(answer) 
						{
							answer  = answer.split('\n')
							answer = JSON.parse(answer[0])
                            console.log(answer)
                            if(answer.result == 'user_id is not valid'){
                                notificationError('user_id is not valid','danger')
                                closeNotification('#alert')
                            };
			                if(answer.result !== 1 ){
							    notificationError(answer.result,'danger')
                                // setTimeout(function () {
                                //     // Closing the alert
                                //     $('#alert').alert('close');
                                // }, 3000);
                                closeNotification('#alert')
							};
                            if(answer.result == 1) {
                                answer_text.innerHTML=`${answer.currency_mont}`
                            }
							// buttonGetData.innerHTML=['',]
							// location.reload()
                            // return
						},
					error: function(result) 
						{
							// return
                            // buttonGetData.innerHTML=['<i class="bi bi-x-octagon-fill" style="font-size: 30px;"></i>',]
                            // console.log(result)
						}
				});
                // return
			})
        const alertError = document.getElementById('alert-errors')
		const notificationError = (message, type) => 
		{
			const wrapper = document.createElement('div')
			wrapper.innerHTML = 
				[
					`<div class="alert alert-${type} alert-dismissible text-center custom-alerts py-0 px-0" role="alert" id="alert" style="   position: fixed; width: 55%; left: 30%; top: 1%; z-index: 10000000000;">`,
						'<br>',
						`<p>${message}</p>`,
						'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
						'<p id="error-message" style="color: red;font-size: 25px;"></p>',
					'</div>'
				].join('')
				alertError.append(wrapper)
		}
        /*
        *   Params id type:string example: #alert
        */
        function closeNotification(id){
            setTimeout(function () {
                // Closing the alert
                $(id).alert('close');
            }, 3000)
        }

    </script>
