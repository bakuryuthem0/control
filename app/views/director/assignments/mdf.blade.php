@extends('layouts.default')

@section('content')
	<div class="">
		<div class="col-xs-12">
			<h2 class="text-center"></h2>
		</div>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-8 center-block">
			<div class="panel panel-default login-panel">
				<div class="panel-heading">
					<h3 class="text-center">Modificar Asignación</h3>
				</div>
				<div class="panel-body">
					@if(count($errors->getMessageBag()) > 0)
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							@foreach($errors->all() as $err)
			                    <li>{{ $err }}</li>
			                @endforeach
						</ul>
					</div>
					@endif
					@if(Session::has('success'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ Session::get('success') }}
					</div>
					@endif
					<form method="POST" action="{{ URL::to('administrador/ver-asignaciones/'.$assignment->id.'/enviar') }}">
						<div class="input-field">
							<label>Carrera (*)</label>
						  	<select name="carreer" class="form-control validate-input carreers" data-url="{{ URL::to('administrador/cargar-cursos') }}" data-target=".enrollment-course">
						  		<option value="">Seleccione una opción...</option>
						  		@foreach($carreers as $c)
						  			<option value="{{ $c->id }}" @if($assignment->schedule->courses->carreer_id == $c->id) selected @endif class="option-response">{{ $c->code }} - {{ $c->name }}</option>
						  		@endforeach
						  	</select>
						</div>
						<div class="input-field">
							<label>Curso (*)</label>
						  	<select name="course" class="form-control validate-input enrollment-course" data-url="{{ URL::to('administrador/cargar-horarios') }}" data-target=".schedule">
						  		<option value="">Seleccione una opción...</option>
						  		<option value="{{$assignment->schedule->course_id}}" selected class="option-response"></option>
						  	</select>
						</div>
						<div class="input-field">
							<label>Horario (*)</label>
						  	<select name="schedule" class="form-control validate-input schedule">
						  		<option value="">Seleccione una opción...</option>
						  		<option value="{{$assignment->schedule_id}}" selected class="option-response"></option>
						  	</select>
						</div>
					  	<script type="text/javascript">
						  	jQuery(document).ready(function($) {
					  			if($('.schedule').val() != "")
					  			{
					  				loadCarreers($('.enrollment-course'), $('.schedule').val());
					  			}else
					  			{
					  				loadCarreers($('.enrollment-course'));
					  			}
						  		if($('.enrollment-course').val() != "")
					  			{
					  				loadCarreers($('.carreers'), $('.enrollment-course').val());
					  			}else
					  			{
					  				loadCarreers($('.carreers'));
					  			}
					  		});
					  	</script>
						<div class="input-field">
							<label>Profesor (*)</label>
							<select name="professor" class="form-control validate-input">
						  		<option value="">Seleccione una opción...</option>
								@foreach($professors as $p)
									<option value="{{ $p->id }}" @if($assignment->user_id == $p->id) selected @endif>
										@if($p->info)
											{{ $p->info->full_name }}
										@else
											{{ $p->username }}
										@endif
									</option>
								@endforeach
							</select>
						</div>
						<div class="input-field">
							<h3>Semestre: <strong>{{ strtoupper($semester->code) }}</strong></h3>
						</div>
						{{ Form::token() }}
					</form>
					<div class="input-field">
						<button class="btn btn-success pull-right btn-submit">Enviar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop