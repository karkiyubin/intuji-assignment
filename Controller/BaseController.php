<?php

namespace Controller;

class BaseController
{
	public $viewFolder = "Views";

	public function redirect($path)
	{
		header('Location: ' . $path);
		exit();
	}
}
