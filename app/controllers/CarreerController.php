<?php

class CarreerController extends BaseController {
	public function getNewCarreer()
	{
		$title = "Nueva Carrera";

		return View::make('admin.carreers.new')
		->with('title',$title);
	}
	public function postNewCarreer()
	{
		$data = Input::all();
		$rules = array(
			'code'     	  => 'required|max:20|unique:carreers,code',
			'name'		  => 'required|max:50',
			'description' => 'required',
			'credit_units'=> 'required|min:1',
		);
		$msg = array();
		$attr = array(
			'code' 			=> 'codígo',
			'name'			=> 'nombre',
			'description'	=> 'descripción',
			'credit_units'  => 'unidades de credito'
		);
		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$carreer 			   = new Carreer;
		$carreer->code		   = $data['code'];
		$carreer->name		   = $data['name'];
		$carreer->description  = $data['description'];
		$carreer->credit_units = $data['credit_units'];
		$carreer->save();

		Session::flash('success','Se ha creado la carrera satisfactoriamente.');
		return Redirect::back();

	}
	public function getShowCarreers()
	{
		$carreers = Carreer::orderBy('id','DESC')->get();
		$title   = "Ver Carreras";

		return View::make('admin.carreers.show')
		->with('title',$title)
		->with('carreers',$carreers);
	}
	public function getMdfCarreer($id)
	{
		$carreer = Carreer::find($id);

		$title = "Modificar Carrera";

		return View::make('admin.carreers.mdf')
		->with('title',$title)
		->with('carreer',$carreer);
	}
	public function postMdfCarreer($id)
	{
		$data = Input::all();
		$rules = array(
			'code'     	  => 'required|max:20|unique:carreers,code,'.$id,
			'name'		  => 'required|max:50',
			'description' => 'required',
			'credit_units'=> 'required|min:1',
		);
		$msg = array();
		$attr = array(
			'code' 			=> 'codígo',
			'name'			=> 'nombre',
			'description'	=> 'descripción',
			'credit_units'  => 'unidades de credito'
		);
		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$carreer 			   = Carreer::find($id);
		$carreer->code		   = $data['code'];
		$carreer->name		   = $data['name'];
		$carreer->description  = $data['description'];
		$carreer->credit_units = $data['credit_units'];
		$carreer->save();

		Session::flash('success','Se ha modificado la carrera satisfactoriamente.');
		return Redirect::back();
	}
	public function postElimCarreer()
	{
		$id = Input::get('id');
		Course::where('carreer_id','=',$id)->delete();
		Carreer::find($id)->delete();
		return Response::json(array(
			'type' => 'success',
			'msg'  => 'se ha eliminado la carrera satisfactoriamente.'
		));
	}
	public function getNewCourse()
	{
		$carreers = Carreer::orderBy('id','DESC')->get();

		$title = "Nuevo Curso";

		return View::make('admin.carreers.courses.new')
		->with('title',$title)
		->with('carreers',$carreers);
	}
	public function postNewCourse()
	{
		$data = Input::all();
		$rules = array(
			'carreer'	  => 'required|exists:carreers,id',
			'code'     	  => 'required|max:20|unique:courses,code',
			'name'		  => 'required|max:50',
			'description' => 'required',
			'credit_units'=> 'required|min:1',
			'semester'	  => 'required|min:1|max:10',
			'prelated_by' => 'sometimes|exists:courses,id'
		);
		$msg = array();
		$attr = array(
			'code' 			=> 'codígo',
			'name'			=> 'nombre',
			'description'	=> 'descripción',
			'credit_units'  => 'unidades de credito'
		);
		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$carreer 			   = new Course;
		if (Input::has('prelated_by')) {
			$carreer->prelated_by  = $data['prelated_by'];
		}
		$carreer->carreer_id   = $data['carreer'];
		$carreer->code		   = $data['code'];
		$carreer->name		   = $data['name'];
		$carreer->description  = $data['description'];
		$carreer->credit_units = $data['credit_units'];
		$carreer->semester	   = $data['semester'];
		$carreer->save();

		Session::flash('success','Se ha creado el curso satisfactoriamente.');
		return Redirect::back();
	}
	public function getCouresByCarreer()
	{
		$id = Input::get('id');

		$courses = Course::where('carreer_id','=',$id)->get(array(
			'id',
			'name as value'
		));
		$view = View::make('partials.select')
		->with('values',$courses);
		if (Input::has('old')) {
			$old = Input::get('old');
		 	$view = $view->with('old',$old);
		 } 
		return $view;
	}
	public function getShowCourses()
	{
		$courses = Course::with('carreers')
		->with('prelated')
		->orderBy('id','DESC')
		->get();

		$title = "Ver Cursos";

		return View::make('admin.carreers.courses.show')
		->with('title',$title)
		->with('courses',$courses);
	}
	public function getMdfCourse($id)
	{
		$title = "Modificar Curso";
		$carreers = Carreer::orderBy('id','DESC')->get();

		$course = Course::find($id);

		return View::make('admin.carreers.courses.mdf')
		->with('title',$title)
		->with('carreers',$carreers)
		->with('course',$course);
	}
	public function postMdfCourse($id)
	{
		$data = Input::all();
		$rules = array(
			'carreer'	  => 'required|exists:carreers,id',
			'code'     	  => 'required|max:20|unique:courses,code,'.$id,
			'name'		  => 'required|max:50',
			'description' => 'required',
			'credit_units'=> 'required|min:1',
			'semester'	  => 'required|min:1|max:10',
			'prelated_by' => 'sometimes|exists:courses,id'
		);
		$msg = array();
		$attr = array(
			'code' 			=> 'codígo',
			'name'			=> 'nombre',
			'description'	=> 'descripción',
			'credit_units'  => 'unidades de credito'
		);
		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$carreer 			   = Course::find($id);
		if (Input::has('prelated_by')) {
			$carreer->prelated_by  = $data['prelated_by'];
		}else
		{
			$carreer->prelated_by  = 0;
		}
		
		$carreer->carreer_id   = $data['carreer'];
		$carreer->code		   = $data['code'];
		$carreer->name		   = $data['name'];
		$carreer->description  = $data['description'];
		$carreer->credit_units = $data['credit_units'];
		$carreer->semester	   = $data['semester'];
		$carreer->save();

		Session::flash('success','Se ha modificado el curso satisfactoriamente.');
		return Redirect::back();
	}
	public function postElimCourse()
	{
		$id = Input::get('id');

		$course = Course::find($id)->delete();

		return Response::json(array(
			'type' => 'success',
			'msg'  => 'Se ha eliminado el curso satisfactoriamente.'
		));
	}
}