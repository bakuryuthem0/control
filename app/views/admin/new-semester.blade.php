@extends('layouts.default')

@section('content')
	<div class="">
		<div class="col-xs-12">
			<h2 class="text-center"></h2>
		</div>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-8 col-md-6 center-block">
			<div class="panel panel-default login-panel">
				<div class="panel-heading">
					<h3 class="text-center">Nuevo semestre</h3>
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
					@if(!empty($semester))
					<div class="alert alert-warning">
						<i class="fa fa-exclamation-triangle"></i> Tenga en cuenta que esta acción dara fin al semestre anterior.
					</div>
					<hr>
					<h3>Semestre actual: </h3>
					<h4><strong>Codigo: </strong>{{ $semester->code }}, <strong>Descripción</strong>: {{ $semester->description }}</h4>
					<hr>
					@endif
					<form method="POST" action="{{ URL::to('administrador/nuevo-semestre/enviar') }}">
						<div class="input-field">
							<label>Codígo</label>
						  	<input type="text" name="code" class="form-control validate-input" placeholder="Codígo" value="{{ Input::old('code') }}">
						</div>
						<div class="input-field">
							<label>Descripción</label>
						  	<input type="text" name="description" class="form-control validate-input" placeholder="Descripción" value="{{ Input::old('description') }}">
						</div>
						<div class="input-field">
							<button class="btn btn-success pull-right">Enviar</button>
						</div>
						{{ Form::token() }}
					</form>
				</div>
			</div>
		</div>
	</div>

@stop