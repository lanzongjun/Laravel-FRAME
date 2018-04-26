<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Redis;

class SingleHandle extends Command
{
    // 推荐频道
    const RECOMMEND_CHAN = 'newRecommend';
    // 测试频道
    const TEST_CHAN = 'imTst';

    // 当前订阅的频道
    const SUBSCRIBERS = [
        self::TEST_CHAN,
        self::RECOMMEND_CHAN
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'single:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '信号操作 pcntl';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function singleHandle($signNo)
    {
        switch ($signNo)
        {
            case SIGINT:
                echo "程序中断退出,bye...\n";
                break;
        }
    }

    public function handleMessage($redis, $channel, $msg)
    {
        echo "Ding, u got a msg {$msg}!\n";

        switch ($channel) {
            case self::RECOMMEND_CHAN:
                echo 111;
                break;
            case self::TEST_CHAN:
                var_dump($msg);
                break;
            default:
                echo 333;
        }

        // 处理完消息，如果被强行中断了，这里退出

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        declare(ticks=1);
        pcntl_signal(SIGINT, [$this, 'singleHandle']);
        //echo "Ctl + c or run cmd : kill -SIGINT " . posix_getpid(). "\n" ;

        try {
            $redis = new \Redis();
            $redis->connect('127.0.0.1', 6379);
            $redis->subscribe(self::SUBSCRIBERS, [$this, 'handleMessage']);
            Log::info(date('Y-m-d').' singleHandleLog');
        } catch (\Exception $e) {
            Log::error(date('Y-m-d').' singleHandleLog e = '. $e->getMessage());
        }


    }




}
