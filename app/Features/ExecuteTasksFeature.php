<?php

namespace App\Features;


use App\Managers\TaskManager;
use App\Models\Task;

class ExecuteTasksFeature
{
    /**
     * @param int $number
     * @throws \Exception
     */
    public function run(int $number)
    {
        $tasks = TaskManager::findTasks(['status' => Task::STATUS_PENDING], ['id' => 'asc'], $number);

        foreach ($tasks as $task) {
            switch ($task->category) {
                case Task::CATEGORY_AMOCRM:
                    TaskManager::executeAmocrmTask($task); //TODO - create amocr service
                    break;
                case Task::CATEGORY_ACCOUNT:
                    TaskManager::executeAccountTask($task); //TODO - create accounting service
                    break;
                default:
                    throw new \Exception('Unknown task category');
                    break;
            }
        }
    }
}
