<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::pattern('id', '[0-9]+');

// EXTERNAL ROUTES
Route::get('login','AuthController@getLogin');
Route::group(array('before' => 'csrf'), function(){
	Route::post('login/enviar','AuthController@postLogin');
});

Route::group(array('before' => 'auth'), function(){
	Route::get('/','HomeController@getIndex');

	Route::group(array('before' => 'administrador'), function(){
		Route::get('administrador/nuevo-semestre','AdminController@getNewSemester');
		//carreras
		Route::get('administrador/nueva-carrera','CarreerController@getNewCarreer');
		Route::get('administrador/ver-carreras','CarreerController@getShowCarreers');
		Route::get('administrador/ver-carrera/{id}','CarreerController@getMdfCarreer');
		//cursos
		Route::get('administrador/nuevo-curso','CarreerController@getNewCourse');
		Route::get('administrador/cargar-cursos','CarreerController@getCouresByCarreer');
		Route::get('administrador/ver-cursos','CarreerController@getShowCourses');
		Route::get('administrador/ver-cursos/{id}','CarreerController@getMdfCourse');
		//usuarios
		Route::get('administrador/nuevo-usuario','UserController@getNewUser');
		Route::get('administrador/ver-usuarios','UserController@getShowUsers');
		Route::get('administrador/ver-usuarios/{id}','UserController@getPasswordChange');
		Route::group(array('before' => 'csrf'), function(){
			Route::post('administrador/nuevo-semestre/enviar','AdminController@postNewSemester');
			//carreras
			Route::post('administrador/nueva-carrera/enviar','CarreerController@postNewCarreer');
			Route::post('administrador/ver-carrera/{id}/enviar','CarreerController@postMdfCarreer');
			Route::post('administrador/ver-carreras/eliminar','CarreerController@postElimCarreer');
			//cursos
			Route::post('administrador/nuevo-curso/enviar','CarreerController@postNewCourse');
			Route::post('administrador/modificar-curso/{id}/enviar','CarreerController@postMdfCourse');
			Route::post('administrador/ver-cursos/eliminar','CarreerController@postElimCourse');
			//usuerios
			Route::post('administrador/nuevo-usuario/enviar','UserController@postNewUser');
			Route::post('administrador/ver-usuarios/eliminar','UserController@postElimUser');
			Route::post('administrador/ver-usuario/{id}/enviar','UserController@postChangePass');
		});
	});
	Route::group(array('before' => 'director'), function(){
		//horarios
		Route::get('administrador/nuevo-horario','DirectorController@getNewSchedule');
		Route::get('administrador/ver-horarios','DirectorController@getShowSchedules');
		Route::get('administrador/ver-horarios/{id}','DirectorController@getMdfSchedule');
		Route::get('administrador/cargar-horarios','DirectorController@getSchedulesByCourse');
		Route::group(array('before' => 'csrf'), function(){
			//horarios
			Route::post('administrador/nuevo-horario/enviar','DirectorController@postNewSchedule');	
			Route::post('administrador/ver-horario/{id}/enviar','DirectorController@postMdfSchedule');
			Route::post('administrador/ver-horarios/eliminar','DirectorController@postElimSchedule');
		});	
	});
	Route::group(array('before' => 'coordinator'), function(){
		//asignaciones
		Route::get('administrador/nueva-asignacion','CoordinatorController@getNewAssignment');
		Route::get('administrador/ver-asignaciones','CoordinatorController@getShowAssignments');
		Route::get('administrador/ver-asignaciones/{id}','CoordinatorController@getMdfAssignment');
		Route::group(array('before' => 'csrf'), function(){
			//asignaciones
			Route::post('administrador/nueva-asignacion/enviar','CoordinatorController@postNewAssignment');
			Route::post('administrador/ver-asignaciones/{id}/enviar','CoordinatorController@postMdfAssignment');
			Route::post('administrador/ver-asignaciones/eliminar','CoordinatorController@postElimAssignment');
		});
	});
	Route::group(array('before' => 'coordinator'), function(){
		//evaluaciones
		Route::get('administrador/nueva-evaluacion','ProfessorController@getNewEvaluation');
		Route::group(array('before' => 'csrf'), function(){
			//evaluaciones
		});
	});
});