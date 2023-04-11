<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="css/app.css">
        
      <title>@yield('title')</title>

  </head>
<body style="font-family:Jamrul">

  <!-- Navbar -->
    <nav class="navbar nav-border fixed-top" id="nav">
      <div class="container-fluid">
    
        <a href="#" id="menuButton" class="btn btn-custom d-flex align-items-center" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
          <div class="col-auto">
            <img width="30px" src="img/user-defaut(semcopy).png" alt="Perfil Menu">
          </div> 
          <div class="col d-flex align-items-center ms-2">
            <img width="30px" src="img/tresbarrinhas.svg" alt="Tres barrinhas">
          </div>
        </a>
      
        <a href="/" class="navbar-brand" id="offCanvasButton">
          <img width="40px" src="img/icon-piggy(semcopy).png" alt="IconePorquinho">
        </a>

      </div>
    </nav>
    
  <!-- Offcanvas -->  
    <div class="offcanvas offcanvas-start text-white navbar-fixed-top" data-bs-theme="dark" data-bs-backdrop="false" data-bs-scroll="true" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
      <div id="sidebar-linhaCima" class="offcanvas-header btn-custom">
        <h4 style="font-family: Jamrul" class="offcanvas-title" id="offcanvasScrollingLabel">
          Menu
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <div class="offcanvas-body" id="sideBar">
        <div class="d-grid gap-2">
          
          <a href="/" id="botoesMenus" class="btn btn-custom text-start" type="button"> 
            Tela Inicial 
          </a>
@guest
          <a href="/login" id="botoesMenus" class="btn btn-custom text-start" type="button"> 
            Login   
          </a>
@endguest
@auth
          <a id="botoesMenus" class="btn btn-custom text-start" type="button"> 
            Cursos  
          </a>
@endauth
        </div>
      </div>

        <div class="container">
          <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3"> </ul>
              <p class="text-center text-muted" style="padding-bottom: 3rem; padding: 0">
                &copy; 2023 PiggyLearn, Inc
              </p>
          </footer>
        </div>

    </div>

    
    
  <!-- Conteudo -->
<div style="margin-top: 6rem"> 

    @yield('content')
    
</div>    

  <!-- Footer
    <div class="container">
      <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3"> </ul>
          <p class="text-center text-muted">&copy; 2023 PiggyLearn, Inc</p>
      </footer>
    </div>
  -->

</body>
    
</html>