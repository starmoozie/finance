<?php

namespace App\Http\Controllers\Admin\Resources\User;

use App\Models\Group;

trait Fetch
{
    use \Starmoozie\CRUD\app\Http\Controllers\Operations\FetchOperation;

    public function fetchGroups()
    {
        return $this->fetch(Group::class);
    }
}
