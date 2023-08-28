<?php

namespace App\Console\Commands;

use App\Events\LoginHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;



class MyWorkers extends Command
{
    private $run = true;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:my-workers  {my_arg}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command worker that gracefully stops on exit';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $received_command = $this->argument('my_arg');
        event(new LoginHistory("this string came from console command"));

        Log::channel('stderr')->info('Worker received command: ' . $received_command);
        if ($received_command == 'start') {
            $this->fire();
            echo "method fire";
        }

        if ($received_command == 'stop') {
//            pcntl_signal(SIGTERM);
            //            posix_kill(posix_getpid(), SIGINT);
//            posix_kill(posix_getpid(), SIGTERM);
        }
    }

        public
        function fire()
        {
// PHP 7.0 and before can handle asynchronous signals with ticks
//        declare(ticks=1);

// PHP 7.1 and later can handle asynchronous signals natively
            pcntl_async_signals(true);

            pcntl_signal(SIGINT, [$this, 'shutdown']); // Call $this->shutdown() on SIGINT
            pcntl_signal(SIGTERM, [$this, 'shutdown']); // Call $this->shutdown() on SIGTERM

            Log::channel('stderr')->info('Worker started');
            $this->info('Worker started');

            $worker = new MyWorkers();
            while ($this->run) {
                $worker->work();
            }

            $this->info('Worker stopped');
        }

        public
        function shutdown()
        {
            $this->info('Gracefully stopping worker...');
            Log::channel('stderr')->info('Gracefully stopping worker...');
            $this->run = false;

        }

        public
        function work()
        {
            for ($i = 0; $i < 10; $i++) {
//        $result = Process::quietly()->run('bash test_queue.sh');
                Log::channel('stderr')->info("WORKS JOBS");
                sleep(1);
                $this->run = false;
            }

        }

    }
/**
 * <?php
 *
 * namespace App\Console\Commands;
 *
 * use Illuminate\Console\Command;
 *
 * class MyWorker extends Command
 * {
 * protected $signature = 'my-worker';
 *
 * protected $description = 'Demonstration worker that gracefully stops on exit';
 *
 * private $run = true;
 *
 * public function fire()
 * {
 * // PHP 7.0 and before can handle asynchronous signals with ticks
 * declare(ticks=1);
 *
 * // PHP 7.1 and later can handle asynchronous signals natively
 * pcntl_async_signals(true);
 *
 * pcntl_signal(SIGINT, [$this, 'shutdown']); // Call $this->shutdown() on SIGINT
 * pcntl_signal(SIGTERM, [$this, 'shutdown']); // Call $this->shutdown() on SIGTERM
 *
 * $this->info('Worker started');
 *
 * $worker = new Worker();
 * while ($this->run) {
 * $worker->work();
 * }
 *
 * $this->info('Worker stopped');
 * }
 *
 * public function shutdown()
 * {
 * $this->info('Gracefully stopping worker...');
 *
 * // When set to false, worker will finish current item and stop.
 * $this->run = false;
 * }
 * }
 */
