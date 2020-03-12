<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'BaseController.php';

class SatuanController extends BaseController {
	
	public function getSatuanChild($id) {
        $SatuanPolres=SATUANPOLRES;
		return view ('users.add',$SatuanPolres);
	}
}
