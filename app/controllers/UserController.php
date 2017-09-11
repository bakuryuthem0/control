<?php

class UserController extends BaseController {

	public function getNewUser()
	{
		$title = "Nuevo Usuario";

		$roles = Role::where('id', '>',Auth::user()->role_id)
		->where('slug','!=','estudiante')
		->get();

		return View::make('admin.users.new')
		->with('title',$title)
		->with('roles',$roles);
	}
	public function postNewUser()
	{
		$data  = Input::all();
		$rules = array(
			'username' => 'required|unique:users,username|min:4|max:16',
			'password' => 'required|min:6|max:16|confirmed',
			'role'	   => 'required|exists:roles,id'
		);
		$msg  = array();
		$attr = array(
			'password'=> 'Contraseña',
			'role'	  => 'rol'
		);
		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			Session::flash('danger', 'Error, datos invalidos');
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user = new User;
		$user->username = $data['username'];
		$user->password = Hash::make($data['password']);
		$user->role_id  = $data['role'];

		$user->save();

		Session::flash('success', 'Se ha creado al usuario satisfactoriamente.');
		return Redirect::back();

	}
	public function getShowUsers()
	{
		$title = "Ver Usuarios";

		$users = User::with('roles')
		->where('id','!=',Auth::id())
		->where('role_id','>',Auth::user()->role_id)
		->orderBy('id','DESC')
		->get();

		return View::make('admin.users.show')
		->with('title',$title)
		->with('users',$users);
	}
	public function postElimUser()
	{
		$id = Input::get('id');

		User::find($id)->delete();

		return Response::json(array(
			'type' => 'success',
			'msg'  => 'Se ha eliminado al usuario satisfactoriamente.'
		));
	}
	public function getPasswordChange($id)
	{
		$title = "Cambio de contraseña";
		$user  = User::with('roles')
		->find($id);
		return View::make('admin.users.changePass')
		->with('title',$title)
		->with('user',$user);
	}
	public function postChangePass($id)
	{
		$data  = Input::all();
		$rules = array(
			'password' => 'required|min:6|max:16|confirmed',
		);
		$msg  = array();
		$attr = array(
			'password'=> 'Contraseña',
		);
		$validator = Validator::make($data, $rules, $msg, $attr);
		if ($validator->fails()) {
			Session::flash('danger', 'Error, datos invalidos');
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user = User::find($id);
		$user->password = Hash::make($data['password']);
		$user->save();

		Session::flash('success', 'Se ha cambiado la contraseña satisfactoriamente.');
		return Redirect::back();
	}
}