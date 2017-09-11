<?php

class Enrollment extends Eloquent{

	public function schedule()
	{
		return $this->belongsTo('Schedule','schedule_id');
	}
	public function enroll()
	{
		return $this->belongsTo('User','user_id')->whereHas('roles',function($role){
			$role->where('slug','=','estudiante');
		});
	}
	public function assignment()
	{
		return $this->belongsTo('User','user_id')->whereHas('roles',function($role){
			$role->where(function($roles)
			{
				$roles->where('slug','=','director')
				->orWhere('slug','=','coordinador')
				->orWhere('slug','=','profesor');
			});
		});
	}
}
