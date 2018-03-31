<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    $fillable = ['name', 'email', 'phone', 'address'];

    /**
     * The projects that belong to the client.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
