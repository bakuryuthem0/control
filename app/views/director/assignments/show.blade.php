@extends('layouts.default')

@section('content')

<div class="row">
	<div class="col-xs-12 col-sm-11 center-block">
		<div class="panel panel-default login-panel">
			<div class="panel-heading">
				<h3 class="text-center">Ver Asignaciones</h3>
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
								<th>Profesor</th>
								<th>Curso</th>
								<th>Horario</th>
								<th>Sección</th>
								<th>Salón</th>
								<th>Modificar</th>
								<th>Eliminar</th>

							</tr>
						</thead>
						<tbody>
							@foreach($assignments as $a)
							<tr>
								<td>{{ $a->id }}</td>
								<td>
									@if($a->assignment->info)
										{{ $a->assignment->info->name }} {{ $a->assignment->info->lastname }} 
									@else
										{{ $a->assignment->username }}
									@endif
								</td>
								<td>
									{{ $a->schedule->courses->code }} - {{ $a->schedule->courses->name }}
								</td>
								<td>
									<strong>{{ $a->schedule->days->name }}</strong>: 
									{{ $a->schedule->start_at }} 
									- 
									{{ $a->schedule->end_at }}
								</td>

								<td>{{ $a->schedule->group }}</td>
								<td>{{ $a->schedule->location }}</td>
								<td><a target="_blank" href="{{ URL::to('administrador/ver-asignaciones/'.$a->id) }}" class="btn btn-xs btn-warning">Modificar</a></td>
								<td><button class="btn btn-xs btn-danger btn-elim-assignment" data-toggle="modal" data-target="#modalElim" data-url="{{ URL::to('administrador/ver-asignaciones/eliminar') }}" value="{{ $a->id }}" data-tosend="id">Eliminar</button></td>
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
