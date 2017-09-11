<?php

class AuthController extends BaseController {

	public function getLogin()
	{
		$title = "Sistema de control academico";
		return View::make('auth.login')
		->with('title',$title);
	}
	public function postLogin()
	{
		$data = Input::all();
		$rules = array(
			'username' => 'required|exists:users,username',
			'password' => 'required'
		);
		$msg = array();
		$attr = array(
			'password' => 'contraseña'
		);
		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		}
		$credentials = [
			'username' => $data['username'],
			'password' => $data['password']
		];
		if (Auth::attempt($credentials)) {
			return Redirect::to('/');
		}

		return Redirect::back();
	}
}
