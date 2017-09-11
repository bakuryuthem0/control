{{ View::make('layouts.profesor.menu') }}
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Asignación <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="{{ URL::to('administrador/nueva-asignacion') }}"><i class="fa fa-plus"></i> Nueva Asignación</a></li>
		<li><a href="{{ URL::to('administrador/ver-asignaciones') }}"><i class="fa fa-list"></i> Ver Asignaciones</a></li>
	</ul>
</li>