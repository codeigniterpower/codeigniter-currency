<?php

$idmail = 'usermail';
$idpass = 'userpass';
$idurl = 'userurl';

echo div_open('class="contain-login d-flex"');
	echo div_open('class="contain-fund d-flex justify-content-center align-items-center"');
		echo '<h1 class="text-white display-1" style="font-family: cursive;">Currency Manager</h1>';
	echo div_close();
	echo div_open('class="mx-auto my-auto"');
		echo form_open($controllerlogin, array('method'=> 'post', 'class' => 'needs-validation'));
			echo '<h1 class="text-dark display-1 text-center" style="font-family: cursive;">Please login</h1>';
			echo div_open('class="form-group"');
				echo form_label('Email;', $idmail);
				echo form_input(array('name'=>$idmail, 'id'=>$idmail, 'type'=>'email', 'class'=>'form-control', 'aria-describedby'=>'emailHelp', 'placeholder'=>'user_name@configuredomain.com', 'required') );
			echo div_close();
			echo div_open('class="form-group"');
				echo form_label('Pass:', $idpass);
				echo form_input(array('name'=>$idpass, 'id'=>$idpass, 'type'=>'password', 'class'=>'form-control', 'placeholder'=>'type here passwword', 'required') );
				echo div_open('class="valid-tooltip invalid-feedback"');
					echo 'Looks good!';
				echo div_close();
			echo div_close();
			echo form_hidden($idurl,$$idurl);
			echo br();
			echo form_submit('makelogin', 'Get me in' , array('class'=>'btn btn-outline-success w-100'));
		echo form_close();
	echo div_close();
echo div_close();
?>
