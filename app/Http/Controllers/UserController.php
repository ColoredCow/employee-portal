<?php

namespace App\Http\Controllers;

use App\Services\GuiteUserService;
use App\User;

class UserController extends Controller
{
    public function syncWithGSuite()
    {
        $user = auth()->user();
        $gsuiteUser = new GuiteUserService;
        $gsuiteUser->fetch($user->email);

        $user->employee->update([
            'name' => $gsuiteUser->getName(),
            'joined_on' => $gsuiteUser->getJoinedOn(),
            'designation' => $gsuiteUser->getDesignation(),
        ]);

        return redirect()->back();
    }
}
