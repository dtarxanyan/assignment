<?php

namespace App\Jobs;


use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateTasksFromJsonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    protected $json;


    /**
     * CreateTasksFromJsonJob constructor.
     * @param string $json
     */
    public function __construct(string $json)
    {
        $this->json = $json;
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $tasks = json_decode($this->json, true);

        if (!is_array($tasks)) {
            throw new \Exception('Failed to decode json');
        }

        try {
            DB::beginTransaction();

            foreach ($tasks as $task) {
                Task::query()->create($task);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
