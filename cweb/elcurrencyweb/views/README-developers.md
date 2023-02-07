# views and menus

## those view have a relationship

* Header
* Footer 
* Menu 


The header opens a general div container:

```
 <div class="container-fluid">
        <div class="row flex-nowrap">
```

Those will and must be closed at the footer or/and menu:

```
    </div>
</div>
```

## If you uses menu view, dont use footer one

In such cases you must close as:

```
      <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        echo link_js("https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", 'integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"  crossorigin="anonymous"');
      ?>
  </body>
</html>
```
