<?php

namespace App\Features;


use App\Managers\TaskManager;

class ListTasksFeature
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function run()
    {
        return TaskManager::findTasks([], ['id' => 'desc']);
    }
}
