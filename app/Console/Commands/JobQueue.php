<?php

/*
 |--------------------------------------------------------------------------
 | 队列任务
 |--------------------------------------------------------------------------
 |
 | 1. 队列源数据基本格式：{"loop":"1", "stime":"", "etime":"", "data":{}}
*/

namespace App\Console\Commands;

use App\Consts\Queue;
use App\Services\Common\QueueService;

class JobQueue extends BaseCommand
{
	/**
	 * 脚本名称
	 *
	 * @var string
	 */
	protected $signature = 'job:queue {type} {--pnum=1} {--retry=3}';

	/**
	 * 脚本描述
	 *
	 * @var string
	 */
	protected $description = '队列任务';

	/**
	 * 队列配置
	 *
	 * @var array
	 */
	protected $queue = [
		'test' => [
			'desc' => '测试任务',
			'key' => Queue::TEST_TEST0,
			'callback' => '_test0',
		]
	];

	protected $redis;

	protected $queueService;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(QueueService $queueService)
	{
        parent::__construct();

        $this->redis = app('redis');
		$this->queueService = $queueService;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        $this->log->info("tttt");
		$type = $this->argument('type');
		if(!in_array($type, array_keys($this->queue))){
			$this->_error("Parameter invalid.");
			return false;
		}
		$pnum = $this->option('pnum');
		$retry = $this->option('retry');
		$path = storage_path();
		$run = "{$path}/proc/JOB_QUEUE.{$type}_{$pnum}.run";
		$die = "{$path}/proc/JOB_QUEUE.{$type}_{$pnum}.die";
		//判断是否已运行
		clearstatcache(); //清除PHP文件信息缓存
		if(file_exists($run)) {
			if(time() - fileatime($run) < 300) {
				return true;
			} else {
				//超过5分钟未刷新run文件判定程序假死
				$pid = file_get_contents($run);
				shell_exec("ps aux | grep '{$_SERVER['PHP_SELF']}' | grep 'job:queue' | grep 'artisan' | grep -v 'grep' | grep '{$type}_{$pnum}' | grep {$pid} | awk '{print $2}' | xargs --no-run-if-empty kill");
			}
		}
		//设置运行状态
		if (!app('files')->put($run, getmypid())) {
			return false;
		}
		$key = $this->queue[$type]['key'];
		$callback = $this->queue[$type]['callback'];

		while (1) {
			if(file_exists($die) && unlink($die) && unlink($run)) {
				return false;
			}

			//更新执行时间
			touch($run);
			while($msg = $this->redis->rpop($key)){
				//更新执行时间
				touch($run);
				$this->queueService->handle($key, $retry, $callback, $msg);
				usleep(50000);
			}
			//队列为空时，多休息一会
			sleep(10);
		}
		return true;
	}

}

