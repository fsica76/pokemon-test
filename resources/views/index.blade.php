<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css')}}">
  </head>
    <title>Pokemon Finder</title>
  </head>
  <body>    

  <div class="container">
    <div class="row-lg">
      <h1>Pokemon Finder</h1>
      </div>
      <div class="row-lg">
        <h4> <small>El que quiere Pokemons, que los busque.</small></h4>
      </div>
      <div class="row-lg">
        {{ Form::open(array('url' => '/search','id'=>'search','class'=> 'form-inline my-2 my-lg-2')) }}
            {{ Form::text('name', null, array('class' => 'form-control mr-sm-2 input-box','placeholder' => 'Ingresar el nombre a buscar.', 'size'=> 24)) }}
            {{ Form::submit('Search', array('class' => 'btn btn-outline-success my-2 my-sm-0 search-btn')) }}
        {{ Form::close() }}
      </div>
      <div id="process-img" class="row-lg d-none">
        <img src="{{ asset('loading-gif-png-4.gif') }}">
      </div>
      <div id="response" class="row-lg d-none">
        <h4> <small>Resultado de la Busqueda.</small></h4>
      </div>    
      <div id="response" class="row-lg d-none">
        <div class="card-columns">
        </div>
      </div>  
      <div class="row-lg"> 
          <div class="card-footer text-muted">
            Federico Sica - fsica76@gmail.com
          </div>
      </div>
  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script type="text/javascript">
  

        $("#search").submit(function(event){
          event.preventDefault(); //prevent default action 
          var form_data = $(this).serialize(); //Encode form elements for submission
          
          $.ajax({
            url : '/search',
            type: 'POST',
            data : form_data,
            beforeSend: function() {
            $(".search-btn").prop('disabled', true);
            $(".input-box").prop('disabled', true);
            $("div#process-img").toggleClass("d-block");
            $('div#response').removeClass("d-block");
            },
          }).done(function(response){ //
            $('div#response').toggleClass("d-block");
            $(".search-btn").prop('disabled', false);
            $(".input-box").prop('disabled', false);
            $("div#process-img").removeClass("d-block");            
            if(!$.trim(response)){
              $(".card-columns").html('No se hallaron resultados.');
            }else{
              $(".card-columns").html(response);
            }
          })
        });
    </script>    
  </body>
</html>
