<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	echo '<p style="display: flex; justify-content: center;"><small>'.br().br();
		if (ENVIRONMENT !== 'production') 
			echo 'DEVEL MODE: ON (<strong>render: {elapsed_time}</strong> s).'. PHP_EOL;
	echo br();
	echo anchor('https://gitlab.com/codeigniterpower','Powered by &copy Codeigniterpowered'), PHP_EOL;
	echo '</p></small>'. PHP_EOL;
	echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
echo '</body>', PHP_EOL,'</html>', PHP_EOL;
?>
