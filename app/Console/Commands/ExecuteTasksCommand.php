<?php

namespace App\Console\Commands;


use App\Features\ExecuteTasksFeature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExecuteTasksCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'tasks:execute {--n=}';

    /**
     * @var string
     */
    protected $description = 'Executes N tasks from tasks table';

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        try {
            $number = $this->option('n');
            $feature = new ExecuteTasksFeature();
            $feature->run($number);
        } catch (\Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }
}
