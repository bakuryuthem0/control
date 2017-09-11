<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>{{ $title }}</title>
		{{ HTML::style('frameworks/bootstrap/css/bootstrap.min.css') }}
		{{ HTML::style('plugins/fontawesome/font-awesome/css/font-awesome.min.css') }}
		{{ HTML::style('css/custom.css') }}
		{{ HTML::script('frameworks/jquery/jquery.min.js') }}

	</head>
	<body>
		@if(Auth::check())
		<header>
			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{{ URL::to('/') }}">Title</a>
					</div>
			
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav navbar-right">
							{{ View::make('layouts.'.UserLib::getUserRole()->slug.'.menu') }}
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li>
										<a href="{{ URL::to('administrador/nuevo-usuario') }}">
											<i class="fa fa-plus"></i> Nuevo Usuario
										</a>
									</li>
									<li>
										<a href="{{ URL::to('administrador/ver-usuarios') }}">
											<i class="fa fa-list"></i> Ver Usuarios
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>
			</nav>
		</header>
		@endif
		<section class="content">
			@yield('content')
		</section>
		<footer @if(!Auth::check()) class="auth" @endif>
			<div class="panel panel-default">
				<div class="panel-body"><p class="text-center"><i class="fa fa-copyright"></i> Todos los derechos reservados | Desarrollado por mi</p></div>
			</div>
		</footer>
	</body>
	{{ HTML::script('frameworks/bootstrap/js/bootstrap.min.js') }}
	@yield('postscript')
	{{ HTML::script('js/functions.js') }}
	{{ HTML::script('js/custom.js') }}


</html>