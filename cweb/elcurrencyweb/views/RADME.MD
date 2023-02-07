### Reutilizables
# Header
# Footer 
# Menu 

Cuando uses el menu ten en cuenta que abre 2 div en la linea 1 y 2 
 <div class="container-fluid">
        <div class="row flex-nowrap">


estos deben cerrar al final del html de cualquier vista que estes creando. 

    </div>
</div>

## Si usas el Menu no uses el FOOTER 

para cerrar todo seria asi:

      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>