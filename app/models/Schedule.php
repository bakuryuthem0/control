<?php

class Schedule extends Eloquent{
	public function getValueAttribute()
	{
	    return "Sección: ".$this->group." - Horario: ".$this->start_at . " / " . $this->end_at." - Salón: ".$this->location." - Día: ".$this->days->name;
	}
	public function courses()
	{
		return $this->belongsTo('Course','course_id');
	}
	public function days()
	{
		return $this->belongsTo('Day','day_id');
	}
	public function semesters()
	{
		return $this->belongsTo('Semester','semester_id');
	}
}
