{{ View::make('layouts.coordinator.menu') }}
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Horarios <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="{{ URL::to('administrador/nuevo-horario') }}"><i class="fa fa-plus"></i> Nueva Horario</a></li>
		<li><a href="{{ URL::to('administrador/ver-horarios') }}"><i class="fa fa-list"></i> Ver Horarios</a></li>
	</ul>
</li>