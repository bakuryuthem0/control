{{ View::make('layouts.director.menu') }}
<li>
	<a href="{{ URL::to('administrador/nuevo-semestre') }}">Nuevo semestre</a>
</li>
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Carreras <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="{{ URL::to('administrador/nueva-carrera') }}"><i class="fa fa-plus"></i> Nueva Carrera</a></li>
		<li><a href="{{ URL::to('administrador/ver-carreras') }}"><i class="fa fa-list"></i> Ver Carreras</a></li>
		<li class="divider" role="separator"><span>Cursos</span></li>
		<li><a href="{{ URL::to('administrador/nuevo-curso') }}"><i class="fa fa-plus"></i> Nuevo Curso</a></li>
		<li><a href="{{ URL::to('administrador/ver-cursos') }}"><i class="fa fa-list"></i> Ver Cursos</a></li>
	</ul>
</li>