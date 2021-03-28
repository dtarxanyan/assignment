<?php

namespace App\Managers;


use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class TaskManager
{
    /**
     * @param array $filters
     * @param array $sorting
     * @param int|null $limit
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function findTasks(array $filters = [], array $sorting = [], int $limit = null)
    {
        $builder = Task::query();

        self::addFilters($builder, $filters);
        self::applySorting($builder, $sorting);

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get();
    }

    /**
     * @param Task $task
     */
    public static function executeAccountTask(Task $task)
    {
        try {
            Log::info('Executing Account Task: ', [
                'date' => Carbon::now()->toDateString(),
                'category' => Task::CATEGORY_ACCOUNT,
                'action' => 'processPayment',
                'data' => $task->data,
            ]);

            $task->status = Task::STATUS_COMPLETED;
        } catch (\Throwable $e) {
            $task->status = Task::STATUS_FAILED;
            $task->error_code = $e->getCode();
        } finally {
            $task->save();
        }
    }

    /**
     * @param Task $task
     */
    public static function executeAmocrmTask(Task $task)
    {
        try {
            Log::info('Executing Amocrm Task: ', [
                'date' => Carbon::now()->toDateString(),
                'category' => Task::CATEGORY_AMOCRM,
                'action' => 'sendLead',
                'data' => $task->data,
            ]);

            $task->status = Task::STATUS_COMPLETED;
        } catch (\Throwable $e) {
            $task->status = Task::STATUS_FAILED;
            $task->error_code = $e->getCode();
        } finally {
            $task->save();
        }
    }

    /**
     * @param Builder $builder
     * @param array $filters
     * @return Builder
     */
    private static function addFilters(Builder $builder, array $filters)
    {
        $status = $filters['status'] ?? null;

        if (is_integer($status)) {
            $builder->where('status', $status);
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param array $sorting
     */
    private static function applySorting(Builder $builder, array $sorting)
    {
        foreach ($sorting as $column => $direction) {
            $builder->orderBy($column, $direction);
        }
    }
}
