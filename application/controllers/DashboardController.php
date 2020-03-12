<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class DashboardController extends BaseController {
	public function index()
	{
		return view ('dashboard/index');
	}
}
