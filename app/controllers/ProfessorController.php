<?php

class ProfessorController extends BaseController {
	public function getNewEvaluation($value='')
	{
		$title = "Nueva Evaluación";

		$courses = Course::with('assignments')->get();
		return $courses;
	}
}