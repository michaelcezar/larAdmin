<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Michael Cezar">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='/images/favicon.png' rel='shortcut icon' />
    <title>{{ App\ExtraClass\appInfo::returnAppInfo()->appName }} | @yield('pageTitle')</title>
    <link href="/js/bootstrap/css/bootstrap.css"      rel="stylesheet">
    <link href="/js/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/css/custom.css"                      rel="stylesheet">
    @yield('extraCSS')
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" id="mainNavBar">
      <a class="navbar-brand" href="#">{{ App\ExtraClass\appInfo::returnAppInfo()->appName }} </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item" id='home'>
            <a class="nav-link" href="../../admin/"><i class="fas fa-home fa-fw"></i> {{ App\ExtraClass\appMenuName::returnMenuName()->home }} </a>
          </li>
          <li class="nav-item dropdown" id='users'>
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user-tie fa-fw"></i>  {{ App\ExtraClass\appMenuName::returnMenuName()->user }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="../../admin/user/new"><i class="fas fa-user-plus fa-fw"></i>  {{ App\ExtraClass\appMenuName::returnMenuName()->newUser }}</a>
              <a class="dropdown-item" href="../../admin/user/list"><i class="far fa-list-alt fa-fw"></i>  {{ App\ExtraClass\appMenuName::returnMenuName()->listUser }}</a>
            </div>
          </li>
        </ul>
        <div class="form-inline mt-2 mt-md-0">
          <ul class="navbar-nav mr-auto ">
            <li class="nav-item dropdown active">
              <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i> {{Session::get('userName')}}
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item clicavel" onclick="updatePassword();"><i class="far fa-edit fa-fw"></i> {{ App\ExtraClass\appMenuName::returnMenuName()->changePassword }}</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../../logout"><i class="fas fa-sign-out-alt fa-fw"></i>  {{ App\ExtraClass\appMenuName::returnMenuName()->logout }}</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <main role="main" class="container-fluid">
      <div class='container-fluid'>
        <div class="content">
          <div id="areaModal"></div>
          @yield('pageContent')
        </div>
      </div>
    </main>
    <br/>
    <footer class="footer d-print-none">
      <div class="container text-center">
        <span class="text-muted">Copyright © Michael Cezar - {{ App\ExtraClass\appInfo::returnAppInfo()->appYear }}</span>
      </div>
    </footer>
    <script src="/js/jquery/jquery.min.js"                 type="text/javascript"></script>
    <script src="/js/popper/popper.min.js"                 type="text/javascript"></script>
    <script src="/js/bootstrap/js/bootstrap.js"            type="text/javascript"></script>
    <script src="/js/bootstrap-notify/bootstrap-notify.js" type="text/javascript"></script>
    <script src="/js/validator/validator.js"               type="text/javascript"></script>
    <script src="/js/custom.js"                            type="text/javascript"></script>
    @yield('extraJavaScript')
  </body>
</html>