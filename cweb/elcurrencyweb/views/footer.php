<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	echo '<p><small>'.br().br();
		if (ENVIRONMENT !== 'production') 
			echo 'DEVEL MODE: ON (<strong>render: {elapsed_time}</strong> s).'. PHP_EOL;
	echo br();
	echo anchor('https://gitlab.com/codeigniterpower','Powered by &copy Codeigniterpowered'), PHP_EOL;
	echo '</p></small>'. PHP_EOL;

echo '</body>', PHP_EOL,'</html>', PHP_EOL;
?>
