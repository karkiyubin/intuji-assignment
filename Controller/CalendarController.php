<?php

namespace Controller;

class CalendarController extends BaseController
{

	function __construct()
	{
		if (empty($_SESSION['auth_credentials'])) {
			$this->redirect(URL . 'login');
		}
	}

	public function addEvent()
	{
		include($this->viewFolder . "/add_event.php");
	}

	public function insertEvent()
	{
		global $google;

		$data = [
			'summary' => $_POST['summary'],
			'description' => $_POST['description'],
		];

		$data['start'] =  [
			'dateTime' => date(DATE_RFC3339, strtotime($_POST["startDate"] . " " . $_POST["startTime"]))
		];

		$data['end'] =  [
			'dateTime' => date(DATE_RFC3339, strtotime($_POST["endDate"] . " " . $_POST["endTime"]))
		];

		if (!empty($_POST["attendees"])) {
			$attendiesArray = explode(",", $_POST["attendees"]);
			//TODO: validate email
			$data['attendees'] = array_map(fn ($value): array => ['email' => $value], $attendiesArray);
		}

		$response = $google->addEvent($data);

		if($response["success"]){
			$this->redirect(URL."?status=success&message=Event Added Successfully.");
		} else {
			include($this->viewFolder . "/add_event.php");
		}
		
	}

	public function confirmDeleteEvent($eventId)
	{
		global $google;
		$response = $google->getEvent($eventId);
		if($response["success"]){
			$event = $response["data"];
			include($this->viewFolder . "/delete_event.php");
		} else {
			include($this->viewFolder . "/404.php");
		}
		
	}

	public function deleteEvent()
	{
		global $google;
		$response = $google->deleteEvent($_POST['eventId']);

		if($response["success"]){
			$this->redirect(URL."?status=success&message=Event Removed Successfully.");
		} else {
			$this->redirect(URL."?status=error&message=".urlencode($response["message"]));
		}
	}
}
