<?php

class CoordinatorController extends BaseController {
	public function getNewAssignment()
	{
		$title = "Nueva Asignación";
		$carreers   = Carreer::get();
		$semester   = Semester::where('active','=',1)->first();
		$professors = User::whereHas('roles',function($role)
		{
			$role->where(function($roles){
				$roles->where('slug','=','director')
				->orWhere('slug','=','coordinador')
				->orWhere('slug','=','profesor');
			});
		})
		->with('info')
		->with('roles')
		->get();
		return View::make('director.assignments.new')
		->with('title',$title)
		->with('professors',$professors)
		->with('carreers',$carreers)
		->with('semester',$semester);
	}
	public function getSchedulesByCourse()
	{
		$id = Input::get('id');

		$schedule = Schedule::where('course_id','=',$id)
		->where('active','=',1)
		->get();
		$view = View::make('partials.select')
		->with('values',$schedule);
		if (Input::has('old')) {
			$old = Input::get('old');
		 	$view = $view->with('old',$old);
		 } 
		return $view;
	}
	public function postNewAssignment()
	{
		$semester   = Semester::where('active','=',1)->first();
		$data  = Input::all();
		$rules = array(
			'professor'		=> 'required|exists:users,id|unique:enrollments,user_id,null,id,schedule_id,'.$data['schedule'].',semester_id,'.$semester->id,
			'schedule'		=> 'required|exists:schedules,id|unique:enrollments,schedule_id,null,id,user_id,'.$data['professor'].',semester_id,'.$semester->id,
		);
		$msg   = array(
			'professor.unique' => 'La combinación profesor / horario debe ser unica para este semestre, esta combinación ya existe',
			'schedule.unique'  => 'La combinación horario / profesor debe ser unica para este semestre, esta combinación ya existe',
		);
		$attr  = array(
			'professor'		=> 'profesor',
			'schedule'		=> 'Horario',
		);

		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$enroll 			  = new Enrollment;
		$enroll->user_id 	  = $data['professor'];
		$enroll->schedule_id  = $data['schedule'];
		$enroll->semester_id  = $semester->id;

		$enroll->save();
		Session::flash('success','Se ha creado la asignación satisfactoriamente.');

		return Redirect::back();
	}
	public function getShowAssignments()
	{
		$title = "Ver Asignaciones";
		$semester    = Semester::where('active','=',1)->first();
		$assignments = Enrollment::with(array('assignment' => function($assignment){
			$assignment->with('roles')
			->with('info');
		}))
		->with(array('schedule' => function($schedule){
			$schedule->with('courses')
			->with('days');
		}))
		->where('semester_id','=',$semester->id)
		->whereHas('assignment',function(){

		})
		->orderBy('id','DESC')
		->get();
		return View::make('director.assignments.show')
		->with('title',$title)
		->with('assignments',$assignments);
	}
	public function getMdfAssignment($id)
	{
		$title = "Modificar Asignación";
		$semester   = Semester::where('active','=',1)->first();
		$assignment = Enrollment::with(array('assignment' => function($assignment){
			$assignment->with('roles')
			->with('info');
		}))
		->with(array('schedule' => function($schedule){
			$schedule
			->with('courses')
			->with('days');
		}))
		->find($id);

		$carreers   = Carreer::get();
		$professors = User::whereHas('roles',function($role)
		{
			$role->where(function($roles){
				$roles->where('slug','=','director')
				->orWhere('slug','=','coordinador')
				->orWhere('slug','=','profesor');
			});
		})
		->with('info')
		->with('roles')
		->get();
		return View::make('director.assignments.mdf')
		->with('title',$title)
		->with('carreers',$carreers)
		->with('semester',$semester)
		->with('assignment',$assignment)
		->with('professors',$professors);
	}
	public function postMdfAssignment($id)
	{
		$semester   = Semester::where('active','=',1)->first();
		$data  = Input::all();
		$rules = array(
			'professor'		=> 'required|exists:users,id|unique:enrollments,user_id,null,id,schedule_id,'.$data['schedule'].',semester_id,'.$semester->id,
			'schedule'		=> 'required|exists:schedules,id|unique:enrollments,schedule_id,null,id,user_id,'.$data['professor'].',semester_id,'.$semester->id,
		);
		$msg   = array(
			'professor.unique' => 'La combinación profesor / horario debe ser unica para este semestre, esta combinación ya existe',
			'schedule.unique'  => 'La combinación horario / profesor debe ser unica para este semestre, esta combinación ya existe',
		);
		$attr  = array(
			'professor'		=> 'profesor',
			'schedule'		=> 'Horario',
		);

		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$enroll 			  = Enrollment::find($id);
		$enroll->user_id 	  = $data['professor'];
		$enroll->schedule_id  = $data['schedule'];
		$enroll->semester_id  = $semester->id;

		$enroll->save();
		Session::flash('success','Se ha creado la asignación satisfactoriamente.');

		return Redirect::back();
	}
	public function postElimAssignment()
	{
		$id = Input::get('id');
		Enrollment::find($id)->delete();
		return Response::json(array(
			'type' => 'success',
			'msg'  => 'Se ha eliminado la asignación satisfactoriamente.'
		));	
	}
}