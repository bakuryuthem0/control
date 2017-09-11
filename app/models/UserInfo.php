<?php

class UserInfo extends Eloquent{
	public function getFullNameAttribute()
	{
	    return $this->name." ".$this->lastname;
	}
	public function users()
	{
		return $this->belongsTo('User','user_id');
	}
}
