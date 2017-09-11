@extends('layouts.default')

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 center-block">
			<div class="panel panel-default login-panel">
				<div class="panel-heading">
					<h3 class="text-center">Modificar Curso</h3>
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
					
					<form method="POST" action="{{ URL::to('administrador/modificar-curso/'.$course->id.'/enviar') }}">
						<div class="input-field">
							<label>Carrera (*)</label>
						  	<select name="carreer" class="form-control validate-input carreers" data-url="{{ URL::to('administrador/cargar-cursos') }}" data-target=".prelated_by">
						  		<option value="">Seleccione una opción...</option>
						  		@foreach($carreers as $c)
						  			<option value="{{ $c->id }}" @if($course->carreer_id == $c->id) selected @endif>{{ $c->code }} - {{ $c->name }}</option>
						  		@endforeach
						  	</select>
						</div>
						<div class="input-field">
							<label>Prelada Por (Opcional)</label>
						  	<select name="prelated_by" class="form-control prelated_by">
						  		<option value="">...</option>
						  		@if($course->prelated_by != 0)
						  			<option value="{{ $course->prelated_by }}" class="option-response" selected>{{ $course->prelated->name }}</option>
						  		@endif
						  	</select>
						  	<script type="text/javascript">
						  		jQuery(document).ready(function($) {
						  			loadCarreers($('.carreers'), $('.prelated_by').val());
						  		});
						  	</script>
						</div>
						<div class="input-field">
							<label>Codígo (*)</label>
						  	<input type="text" name="code" class="form-control validate-input" placeholder="Codígo" value="{{ $course->code }}">
						</div>
						<div class="input-field">
							<label>Nombre (*)</label>
						  	<input type="text" name="name" class="form-control validate-input" placeholder="Nombre" value="{{ $course->name }}">
						</div>
						<div class="input-field">
							<label>Descripción (*)</label>
						  	<input type="text" name="description" class="form-control validate-input" placeholder="Descripción" value="{{ $course->description }}">
						</div>
						<div class="input-field">
							<label>Unidades de credito (*)</label>
						  	<input type="text" name="credit_units" class="form-control validate-input" placeholder="Unidades de credito" value="{{ $course->credit_units }}">
						</div>
					  	<div class="input-field">
							<label>Semestre de ubicación (*)</label>
						  	<input type="text" name="semester" class="form-control validate-input" placeholder="Semestre de ubicación" value="{{ $course->semester }}">
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