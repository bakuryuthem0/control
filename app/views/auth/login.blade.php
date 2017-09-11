@extends('layouts.default')

@section('content')
	<div class="valign-pane">
		<div class="col-xs-12">
			<h2 class="text-center">Sistema de control academico</h2>
		</div>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-8 col-md-6 center-block">
			<div class="panel panel-default login-panel">
				<div class="panel-heading">
					<h3 class="text-center">Inicio de sesión</h3>
				</div>
				<div class="panel-body">
					@if(count($errors->getMessageBag()) > 0)
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						Error, usuario o contraseña incorrectos.
						</ul>
					</div>
					@endif
					<form method="POST" action="{{ URL::to('login/enviar') }}">
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon-user"><i class="fa fa-user"></i></span>
						  <input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon-user">
						</div>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon-password"><i class="fa fa-lock"></i></span>
						  <input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="basic-addon-password">
						</div>
						<div class="input-field">
							<button class="btn btn-success btn-submit pull-right">Enviar</button>
						</div>
						{{ Form::token() }}
					</form>
				</div>
			</div>
		</div>
	</div>

@stop