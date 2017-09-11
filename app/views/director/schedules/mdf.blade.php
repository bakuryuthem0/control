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
					<h3 class="text-center">Modificar Horario</h3>
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
					<form method="POST" action="{{ URL::to('administrador/ver-horario/'.$schedule->id.'/enviar') }}">
						<div class="col-xs-12">
							<div class="input-field">
								<label>Carrera (*)</label>
							  	<select name="carreer" class="form-control validate-input carreers" data-url="{{ URL::to('administrador/cargar-cursos') }}" data-target=".course">
							  		<option value="">Seleccione una opción...</option>
							  		@foreach($carreers as $c)
							  			<option value="{{ $c->id }}" @if($schedule->courses->carreer_id == $c->id) selected @endif>{{ $c->code }} - {{ $c->name }}</option>
							  		@endforeach
							  	</select>
							</div>
							<div class="input-field">
								<label>Curso (*)</label>
							  	<select name="course" class="form-control validate-input course">
							  		<option value="">Seleccione una opción...</option>
							  		@foreach($courses as $co)
							  			<option value="{{ $co->id }}" class="option-response" @if($co->id == $schedule->course_id) selected @endif>{{ $co->name }}</option>
							  		@endforeach

							  	</select>
							  	@if(Input::old('course'))
							  	<script type="text/javascript">
							  		jQuery(document).ready(function($) {
							  			if($('.course').val() != "")
							  			{
							  				loadCarreers($('.carreers'), $('.course').val());
							  			}else
							  			{
							  				loadCarreers($('.carreers'));
							  			}
							  		});
							  	</script>
							  	@endif
							</div>
							<div class="input-field">
								<label>Dia (*)</label>
							  	<select name="day" class="form-control validate-input">
							  		<option value="">Seleccione una opción...</option>
							  		@foreach($days as $d)
							  			<option value="{{ $d->id }}" @if($schedule->day_id == $d->id) selected @endif>{{ $d->name }}</option>
							  		@endforeach
							  	</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="input-field">
								<label>Inicio (*)</label>
							  	<input type="text" name="start_at" class="form-control validate-input" placeholder="Inicio" value="{{ $schedule->start_at }}">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="input-field">
								<label>Fin (*)</label>
							  	<input type="text" name="end_at" class="form-control validate-input" placeholder="Fin" value="{{ $schedule->end_at }}">
							</div>
						</div>
						<div class="col-xs-12">
							<div class="input-field">
								<label>Sección / Grupo (*)</label>
							  	<input type="text" name="group" class="form-control validate-input" placeholder="Sección / Grupo" value="{{ $schedule->group }}">
							</div>
							<div class="input-field">
								<label>Salón (*)</label>
							  	<input type="text" name="location" class="form-control validate-input" placeholder="Salón" value="{{ $schedule->location }}">
							</div>
							<div class="input-field">
								<label>¿Activo?</label>
								<input type="checkbox" name="active" value="1" class="switch" @if($schedule->active == 1) checked @endif>
							</div>
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

@section('postscript')
{{ HTML::style('plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}
{{ HTML::script('plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}

<script type="text/javascript">
	jQuery(document).ready(function($) {
		if ($('.switch').is(':checked')) {
			var $state = true;
		}else
		{
			var $state = false;
		}
		$(".switch").bootstrapSwitch({
			state   : $state,
			onText  : 'Activo',
			offText : 'Inactivo',
			size    : 'small'
		});
	});
</script>
@stop