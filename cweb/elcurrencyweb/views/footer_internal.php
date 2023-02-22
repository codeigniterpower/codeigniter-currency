	<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
    ?>
	<!-- FOOTER INI ON INTO-->
        <footer class="footer pb-4" style="text-align: center;">
        	<small class="d-flex align-items-center text-white text-decoration-none d-sm-inline mx-1"><p style="display: flex; justify-content: center;  color: black;">
        		<?php if (ENVIRONMENT !== 'production') echo '<p class="ms-1 d-none d-sm-inline" style=" color: black;">DEVEL MODE: ON <br>(<strong>render: {elapsed_time}</strong> s).</p>'. PHP_EOL; ?>
        		</p class="ms-1 d-none d-sm-inline" style=" color: black;">
        		    <a href="https://gitlab.com/codeigniterpower" >Powered by VenenuX CI</a>
        		</p>
        	</small>
        </footer>
    </div>
</div>