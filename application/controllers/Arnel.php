<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arnel extends MY_Controller {
	public function index()
	{
		$sql = "SELECT * FROM site_options WHERE vkey='online_friends'";
		$result = $this->db->query($sql)->result_array();
		$online_users = $result[0]['value'];
		$this->load->view('clientside/index', ['online_users'=>$online_users, 'stitle'=>"30 Minutes Video Meet"]);
	}

	public function faceWaiting() {
		$data = $this->input->get();
		$this->load->view('clientside/faceWaiting', $data);
	}

	public function meetup() {
		$data = $this->input->get();
		$this->load->view('clientside/meetupfriends', $data);
	}

	public function term() {
		$this->load->view('clientside/term');
	}
}
