<?php

class DirectorController extends BaseController {
	public function getNewSchedule()
	{
		$title    = "Nuevo Horario";

		$carreers = Carreer::get();
		$days     = Day::get();
		return View::make('director.schedules.new')
		->with('title',$title)
		->with('days',$days)
		->with('carreers',$carreers);
	}
	public function postNewSchedule()
	{
		$data  = Input::all();
		$rules = array(
			'course'		=> 'required|exists:courses,id',
			'day'			=> 'required|exists:days,id',
			'start_at'		=> 'required|date_format:H:s',
			'end_at'		=> 'required|date_format:H:s',
			'group'			=> 'required|unique:schedules,group,NULL,id,course_id,'.$data['course'],
			'location'		=> 'required',
			'active'		=> 'sometimes'
		);
		$msg   = array();
		$attr  = array(
			'course'		=> 'curso',
			'day'			=> 'dia',
			'start_at'		=> 'inicio',
			'end_at'		=> 'fin',
			'group'			=> 'grupo / seccion',
			'location'		=> 'salón'
		);

		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$schedule = new Schedule;
		$schedule->course_id = $data['course'];
		$schedule->day_id    = $data['day'];
		$schedule->start_at  = $data['start_at'];
		$schedule->end_at    = $data['end_at'];
		$schedule->group     = $data['group'];
		$schedule->location  = $data['location'];
		if (Input::has('active')) {
			$schedule->active = 1;
		}
		$schedule->save();
		Session::flash('success','Se ha creado el horario satisfactoriamente.');
		return Redirect::back();
	}
	public function getShowSchedules()
	{
		$title = "Ver Horarios";

		$schedules = Schedule::with('courses')
		->with('days')
		->orderBy('id','DESC')->get();

		return View::make('director.schedules.show')
		->with('title',$title)
		->with('schedules',$schedules);
	}
	public function getMdfSchedule($id)
	{
		$title = "Modificar Horario";
		$carreers = Carreer::get();
		$days     = Day::get();
		$schedule = Schedule::with('courses')->find($id);
		$courses  = Course::where('carreer_id','=',$schedule->courses->carreer_id)->get();

		return View::make('director.schedules.mdf')
		->with('title',$title)
		->with('schedule',$schedule)
		->with('carreers',$carreers)
		->with('courses',$courses)
		->with('days',$days);
	}
	public function postMdfSchedule($id)
	{
		$data  = Input::all();
		$rules = array(
			'course'		=> 'required|exists:courses,id',
			'day'			=> 'required|exists:days,id',
			'start_at'		=> 'required|date_format:H:s',
			'end_at'		=> 'required|date_format:H:s',
			'group'			=> 'required|unique:schedules,group,'.$id.',id,course_id,'.$data['course'],
			'location'		=> 'required',
			'active'		=> 'sometimes'
		);
		$msg   = array();
		$attr  = array(
			'course'		=> 'curso',
			'day'			=> 'dia',
			'start_at'		=> 'inicio',
			'end_at'		=> 'fin',
			'group'			=> 'grupo / seccion',
			'location'		=> 'salón'
		);

		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$schedule = Schedule::find($id);
		$schedule->course_id = $data['course'];
		$schedule->day_id    = $data['day'];
		$schedule->start_at  = $data['start_at'];
		$schedule->end_at    = $data['end_at'];
		$schedule->group     = $data['group'];
		$schedule->location  = $data['location'];
		if (Input::has('active')) {
			$schedule->active = 1;
		}else
		{
			$schedule->active = 0;
		}

		$schedule->save();
		Session::flash('success','Se ha modificado el horario satisfactoriamente.');
		return Redirect::back();
	}
	public function postElimSchedule()
	{
		$id = Input::get('id');

		Schedule::find($id)->delete();

		return Response::json(array(
			'type' => 'success',
			'msg'  => 'Se ha eliminado el horario satisfactoriamente.'
		));
	}
	
}
