<?php

namespace Controller;

class AuthController extends BaseController
{

	function __construct()
	{
	}

	public function login()
	{
		global $google;

		if (!empty($_GET['code'])) {
			$_SESSION['auth_credentials'] = $google->client->fetchAccessTokenWithAuthCode($_GET['code']);
		}

		if (!empty($_SESSION['auth_credentials'])) {
			$this->redirect(URL);
		}

		$auth_url = $google->client->createAuthUrl();
		include($this->viewFolder . "/login.php");
	}
	
	public function logout(){
		global $google;
		$google->client->revokeToken();
		session_destroy();
		$this->redirect(URL.'login');
	}
}