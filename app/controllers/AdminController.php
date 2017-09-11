<?php

class AdminController extends BaseController {

	public function getNewSemester()
	{
		$title 	  = "Nuevo semestre";
		$semester = Semester::where('active','=',1)->first();

		return View::make('admin.new-semester')
		->with('title',$title)
		->with('semester',$semester);	
	}
	public function postNewSemester()
	{
		$data = Input::all();
		$rules = array(
			'code'     	  => 'required|max:20|unique:semesters,code',
			'description' => 'required|max:20'
		);
		$msg = array();
		$attr = array(
			'code' 			=> 'codígo',
			'description'	=> 'descripción'
		);
		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$semester 			  = Semester::where('active','=',1)->first();
		if (!empty($semester)) {
			$semester->active = 0;
			$semester->save();
		}
		$semester 				= new Semester;
		$semester->code 		= $data['code'];
		$semester->description  = $data['description'];
		$semester->save();

		Session::flash('success', 'Se ha registrado el nuevo semestre satisfactoriamente.');
		return Redirect::back();
	}
}