<?php

class Carreer extends Eloquent{

	public function courses()
	{
		return $this->hasMany('Course','carreer_id');
	}
}
