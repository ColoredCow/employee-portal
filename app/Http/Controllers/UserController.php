<?php

namespace App\Http\Controllers;

use App\Services\GSuiteUserService;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function syncWithGSuite()
    {
        $gsuiteUserService = new GSuiteUserService();
        $gsuiteUserService->fetch(auth()->user()->email);
        $this->updateEmployeeDetailsFromGSuite($gsuiteUserService->getUsers());
        return redirect()->back();
    }

    public function syncAllWithGSuite()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        $gsuiteUserService = new GSuiteUserService();
        $gsuiteUserService->fetchAll();
        $this->updateEmployeeDetailsFromGSuite($gsuiteUserService->getUsers());
        return redirect()->back();
    }

    public function updateEmployeeDetailsFromGSuite(array $gsuiteUsers)
    {
        foreach ($gsuiteUsers as $key => $gsuiteUser) {
            $user = User::with('employee')->findByEmail($gsuiteUser->getPrimaryEmail())->first();
            if (is_null($user)) {
                continue;
            }
            $user->employee->update([
                'name' => $gsuiteUser->getName()->fullName,
                'joined_on' => Carbon::parse($gsuiteUser->getCreationTime())->format(config('constants.date_format')),
                'designation' => $gsuiteUser->getOrganizations()[0]['title'],
            ]);
        }
    }
}
