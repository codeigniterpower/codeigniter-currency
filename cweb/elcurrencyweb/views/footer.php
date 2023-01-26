<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
echo '<p><small>'.br().br();
if (ENVIRONMENT !== 'production') echo 'Page rendered in <strong>{elapsed_time}</strong> seconds.'. PHP_EOL;
echo 'Construido en '.anchor('http://vegnuli.blogspot.com','Sistema CI power VenenuX').' &copy; 2012-2022 PICCORO Lenz McKAY', PHP_EOL;
echo '<a href="http://vegnuli.blogspot.com"><img src="https://www.w3.org/html/logo/badge/html5-badge-h-css3-performance-semantics.png" width="97" height="34" alt="HTML5 Powered with CSS3 / Styling, Performance &amp; Integration, and Semantics" title="HTML5 Powered with CSS3 / Styling, Performance &amp; Integration, and Semantics"></a>';
echo '</p></small>'. PHP_EOL;
echo '</body>', PHP_EOL,'</html>', PHP_EOL;
?>
