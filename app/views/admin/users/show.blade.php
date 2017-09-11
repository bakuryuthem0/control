@extends('layouts.default')

@section('content')

<div class="row">
	<div class="col-xs-12 col-sm-11 center-block">
		<div class="panel panel-default login-panel">
			<div class="panel-heading">
				<h3 class="text-center">Ver Usuarios</h3>
			</div>
			<div class="panel-body">
				@if(Session::has('success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('success') }}
				</div>
				@endif
				@if(Session::has('danger'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('danger') }}
				</div>
				@endif
				<div class="col-xs-12 col-md-4 pull-right">
					<div class="input-group">
						<input type="text" class="form-control" name="busq" placeholder="Busqueda">
					    <span class="input-group-btn">
					        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
					    </span>
					</div><!-- /input-group -->
				</div>
				<div class="clearfix"></div>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Id</th>
								<th>Nombre</th>
								<th>Rol / Permisos</th>
								<th>Modificar</th>
								<th>Eliminar</th>

							</tr>
						</thead>
						<tbody>
							@foreach($users as $u)
							<tr>
								<td>{{ $u->id }}</td>
								<td>{{ $u->username }}</td>
								<td>{{ $u->roles->description }}</td>
								<td><a target="_blank" href="{{ URL::to('administrador/ver-usuarios/'.$u->id) }}" class="btn btn-xs btn-warning">Cambiar Contraseña</a></td>
								<td><button class="btn btn-xs btn-danger btn-elim-carreer" data-toggle="modal" data-target="#modalElim" data-url="{{ URL::to('administrador/ver-usuarios/eliminar') }}" value="{{ $u->id }}" data-tosend="id">Eliminar</button></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
{{ View::make('partials.modalElim') }}
{{ Form::token() }}
@stop
