<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>Qualim | Soluções</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="" name="description" />
<meta content="" name="author" />
<!-- BEGIN CORE CSS FRAMEWORK -->
<link href="packages/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="packages/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
<!-- END CORE CSS FRAMEWORK -->
<!-- BEGIN CSS TEMPLATE -->
<link href="packages/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/magic_space.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
<!-- END CSS TEMPLATE -->

<!-- Inclui o arquivos para validação de campos-->
<!-- -->
<script type="text/javascript">
  function logout() {
    <?php
     Auth::user()->logout();
     Auth::cliente()->logout();
     ?>
  }

</script>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body style="background: url('packages/assets/img/Logo-Qualin-login.png') no-repeat; background-position:50% 10%;" onload="logout();">
<div class="container">

    <br><br><br><br><br>
  <div class="row login-container animated fadeInUp">  
        <div class="col-md-8 col-md-offset-2 tiles red no-padding">
		 <div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
          {{--<h2 class="normal">Qualim Soluções</h2>--}}
          <p>Seja bem vindo! <br>Use o seu usuario e senha para acessar o sistema</p>
          
		  
        </div>
		<div class="tiles primary p-t-20 p-b-20 text-black">
			<form class="animated fadeIn" id="frm_login" name="frm_login" method="post" action="{{url('login')}} ">  

                {{--se houver erro erá mostrar--}}
                @if (Session::has('flash_error'))
                    <div class="alert alert-danger">E-mail ou senha inválidos.</div>
                @endif   
                    <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                      <div class="col-md-6 col-sm-6 ">
                        <input name="email" id="email" type="text"  class="form-control" placeholder="E-mail">

                          <label>
                            <input type="checkbox"  name="remember">
                            Lembrar senha
                          </label>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <input name="password" id="password" type="password"  class="form-control" placeholder="Senha">                        
                      </div>
                     
                      
                    </div>
				<div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
				  <div class="control-group  col-md-10">
								<button type="submit" class="btn btn-danger btn-cons" id="login_toggle">Entrar</button>

				  </div>
				  </div>
			  </form>
		
		</div>   
      </div>   
  </div>
</div>
<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->
<script src="packages/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-lazyload/jquery.lazyload.min.js" type="text/javascript"></script>
<script src="packages/assets/js/login_v2.js" type="text/javascript"></script>
<!-- BEGIN CORE TEMPLATE JS -->
<!-- END CORE TEMPLATE JS -->
</body>



</html>