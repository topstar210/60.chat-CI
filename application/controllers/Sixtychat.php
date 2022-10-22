<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sixtychat extends MY_Controller {
	public function index()
	{
		// $sql = "SELECT * FROM site_options WHERE vkey='online_users'";
		// $result = $this->db->query($sql);
		// $online_users = $result['value'];
		$this->load->view('clientside/index');
	}

	public function faceWaiting() {
		$data = $this->input->get();
		$this->load->view('clientside/faceWaiting', $data);
	}

	public function meetup() {
		$data = $this->input->get();
		$this->load->view('clientside/meetup', $data);
	}

	public function term() {
		$this->load->view('clientside/term');
	}
}
