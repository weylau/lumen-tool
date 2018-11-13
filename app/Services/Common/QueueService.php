<?php

/*
 |--------------------------------------------------------------------------
 | 队列服务
 |--------------------------------------------------------------------------
 |
 | 1. 队列源数据基本格式：{"loop":"1", "stime":"", "etime":"", "data":{}}
 | 2. 任务执行失败以后，需要重新加入队列，并更新重试次数
 |
*/

namespace App\Services\Common;

class QueueService extends CommonBaseService
{

	protected $queueRedis;
	protected $cache;
	protected $commonService;




	public function __construct(CommonService $commonService)
	{
		parent::__construct();
		$this->queueRedis = app('redis')->connection('queue');
		$this->cache = app('cache')->store('file');
		$this->commonService = $commonService;
	}

	/**
	 * 队列调用入口
	 *
	 * @param string $key 队列key
	 * @param int $retry 重试次数
	 * @param callable $callback 队列回调方法
	 * @param string $content 队列内容
	 * @return mixed
	 */
	public function handle($key, $retry, $callback, $content)
	{
		if(!is_callable([$this, $callback])){
			$this->log->info("The callback of {$callback} is not callable in QueueService.");
			return false;
		}
		$msg = json_decode($content, true);
		if(!$msg){
			$this->log->info("The msg is invalid in QueueService.//{$content}");
			return false;
		}
		//参数检测
		if(!isset($msg['loop']) || !isset($msg['stime']) || !isset($msg['etime']) || !isset($msg['data'])){
			$this->log->info("The msg format is incorrect in QueueService.//{$content}");
			return false;
		}
		//重发判断
		$loop = $msg['loop'];
		if($loop > $retry){
			$this->log->info("The msg has been consumed more than {$retry} times in QueueService.//{$content}");
			return false;
		}
		//起始执行时间判断
		$stime = $msg['stime'];
		if($stime && time() < $stime){
			$this->commonService->revAddQueue($key, $content);
			return false;
		}
		//截止执行时间判断
		$etime = $msg['etime'];
		if($etime && time() > $etime){
			$this->log->info("Current time is later than reserved end time in QueueService.//{$content}");
			return false;
		}
		call_user_func([$this, $callback], $key, $msg);
		return true;

	}

	/**
	 * test0
	 *
	 * @param string $key key
	 * @param array $msg 消息
	 */
	private function _test0($key, $msg)
	{
        $this->log->info("msg:".$msg['data']['msg']);
		return true;
	}



}