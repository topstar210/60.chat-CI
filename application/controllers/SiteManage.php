<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiteManage extends MY_Controller {

	public function index()
	{
		$this->load->view('sitemanage/list');
	}

    public function new(){
        $this->load->view('sitemanage/addpage');
    }

}
