@extends('layouts.default')

@section('content')

<div class="row">
	<div class="col-xs-12 col-sm-11 center-block">
		<div class="panel panel-default login-panel">
			<div class="panel-heading">
				<h3 class="text-center">Ver Cursos</h3>
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
								<th>Prelada Por</th>
								<th>Codígo</th>
								<th>Nombre</th>
								<th>Descripción</th>
								<th>Unidades de crédito</th>
								<th>Semestre de ubicación</th>
								<th>Modificar</th>
								<th>Eliminar</th>

							</tr>
						</thead>
						<tbody>
							@foreach($courses as $c)
							<tr>
								<td>{{ $c->id }}</td>
								<td>
									@if($c->prelated_by != 0)
										@if($c->prelated)
											{{ $c->prelated->code }} - {{ $c->prelated->name }}
										@else
											Curso eliminado, sustituyalo porfavor.
										@endif
									@else
										No es prelada por ninguna materia
									@endif
								</td>
								<td>{{ $c->code }}</td>
								<td>{{ $c->name }}</td>
								<td>{{ $c->description }}</td>
								<td>{{ $c->credit_units }}</td>
								<td>{{ $c->semester }}</td>
								<td><a target="_blank" href="{{ URL::to('administrador/ver-cursos/'.$c->id) }}" class="btn btn-xs btn-warning">Modificar</a></td>
								<td><button class="btn btn-xs btn-danger btn-elim-course" data-toggle="modal" data-target="#modalElim" data-url="{{ URL::to('administrador/ver-cursos/eliminar') }}" value="{{ $c->id }}" data-tosend="id">Eliminar</button></td>
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
