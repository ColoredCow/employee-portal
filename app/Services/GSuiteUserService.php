<?php

namespace App\Services;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Directory;

class GuiteUserService
{
    protected $name;
    protected $joinedOn;
    protected $designation;

    public function __construct()
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(env('GOOGLE_SERVICE_ACCOUNT_IMPERSONATE'));
        $client->addScope([
            Google_Service_Directory::ADMIN_DIRECTORY_USER,
            Google_Service_Directory::ADMIN_DIRECTORY_USER_READONLY,
        ]);
        $this->service = new Google_Service_Directory($client);
    }

    public function fetch($email)
    {
        $gsuiteUser = $this->service->users->get($email);
        $userOrganizations = $gsuiteUser->getOrganizations();

        $designation = null;
        if (!is_null($userOrganizations)) {
            $designation = $userOrganizations[0]['title'];
        }
        $this->setName($gsuiteUser->getName()->fullName);
        $this->setJoinedOn(Carbon::parse($gsuiteUser->getCreationTime())->format(config('constants.date_format')));
        $this->setDesignation($designation);
    }

    public function setJoinedOn($joinedOn)
    {
        $this->joinedOn = $joinedOn;
    }

    public function getJoinedOn()
    {
        return $this->joinedOn;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }
}
