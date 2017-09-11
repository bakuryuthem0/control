<?php

class Course extends Eloquent{

	public function carreers()
	{
		return $this->belongsTo('Carreer','carreer_id');
	}
	public function prelated()
	{
		return $this->belongsTo('Course','prelated_by');
	}
	public function schedules()
	{
		return $this->hasMany('Schedule','course_id');
	}
	public function assignments()
	{
		return $this->hasMany('Enrollment','user_id');
	}
}
