<?php

/**
 * Central library to access Google APIs Client Library 
 */

require_once 'vendor/autoload.php';

use Google\Service\Calendar;

class GoogleLibrary
{
    public $client;
    public $calendarId = 'primary';

    function __construct()
    {
        $this->client = new Google\Client();
        $this->client->setAuthConfig('client_secret.json');
        $this->client->addScope(Calendar::CALENDAR);

        if (!empty($_SESSION['auth_credentials'])) {
            $this->client->setAccessToken($_SESSION['auth_credentials']);
            if ($this->client->isAccessTokenExpired()) {
                echo "Session Expired";
                $this->client->revokeToken();
                session_destroy();
                header('Location: ' . URL);
                exit();
            }
        }
    }

    public function getCalendarList()
    {
        try {
            $service = new Google_Service_Calendar($this->client);
            $parameters = array(
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c'),
            );
            $results = $service->events->listEvents($this->calendarId, $parameters);
            return [
                "success" => true,
                "data" => $results->getItems()
            ];
        } catch (Google_Service_Exception  $ex) {
            return [
                "success" => false,
                "message" => json_decode($ex->getMessage())->error->message
            ];
        }
    }

    public function addEvent($data)
    {
        try {
            $service = new Google_Service_Calendar($this->client);
            $event = new Google_Service_Calendar_Event($data);
            $service->events->insert($this->calendarId, $event);
            return [
                "success" => true
            ];
        } catch (Google_Service_Exception  $ex) {
            return [
                "success" => false,
                "message" => json_decode($ex->getMessage())->error->message
            ];
        }
    }

    public function deleteEvent($eventId)
    {
        try {
            $service = new Google_Service_Calendar($this->client);
            $service->events->delete($this->calendarId, $eventId);
            return [
                "success" => true
            ];
        } catch (Google_Service_Exception  $ex) {
            return [
                "success" => false,
                "message" => json_decode($ex->getMessage())->error->message
            ];
        }
    }

    public function getEvent($eventId)
    {
        try {
            $service = new Google_Service_Calendar($this->client);
            return [
                "success" => true,
                "data" => $service->events->get($this->calendarId, $eventId)
            ];
        } catch (Google_Service_Exception  $ex) {
            return [
                "success" => false,
                "message" => json_decode($ex->getMessage())->error->message
            ];
        }
    }
}
