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
        $num = 0;
        try {
            echo 1/$num;
        } catch (\Exception $e) {
            echo $e->getMessage(),"\n";
        }

        echo "over\n";

        print_r(error_get_last());

        register_shutdown_function('zyfshutdownfunc');
    }

    public function zyfshutdownfunc()
    {
        print_r(error_get_last());
    }
}
