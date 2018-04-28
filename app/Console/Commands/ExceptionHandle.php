<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExceptionHandle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Exception:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '异常处理';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            test();
        } catch (\Throwable $e) {
            echo  $e->getMessage(),"\n";
        }

        try {
            test();
        } catch (\Error $e) {
            echo $e->getMessage(),"\n";
        }
    }

}
