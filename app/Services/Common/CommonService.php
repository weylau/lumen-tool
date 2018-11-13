<?php
/*
 |--------------------------------------------------------------------------
 | 公共服务
 |--------------------------------------------------------------------------
 | 1. 公共service的构造方法中不要加依赖注入
 |
*/

namespace App\Services\Common;


class CommonService extends CommonBaseService
{

	protected $queueRedis;

	public function __construct()
	{
		parent::__construct();
		$this->queueRedis = app('redis')->connection('queue');
	}



	/**
	 * 添加任务队列
	 *
	 * @param string $key 队列key
	 * @param string $content 队列内容
	 * @return mixed
	 */
	public function addQueue($key, $content)
	{
		$this->queueRedis->rpush($key, $content);
		return 200;
	}

	/**
	 * 批量添加任务队列
	 *
	 * @param string $key 队列key
	 * @param array $content 队列内容
	 * @return mixed
	 */
	public function addManyQueue($key, $content)
	{
		call_user_func_array([$this->queueRedis, 'rpush'], array_merge([$key], $content));
		return 200;
	}

	/**
	 * 反向添加任务队列(用于队列失败重试)
	 *
	 * @param string $key 队列key
	 * @param string $content 队列内容
	 * @return mixed
	 */
	public function revAddQueue($key, $content)
	{
		$this->queueRedis->lpush($key, $content);
		return 200;
	}

	/**
	 * 反向批量添加任务队列(用于队列失败重试)
	 *
	 * @param string $key 队列key
	 * @param array $content 队列内容
	 * @return mixed
	 */
	public function revAddManyQueue($key, $content)
	{
		call_user_func_array([$this->queueRedis, 'lpush'], array_merge([$key], $content));
		return 200;
	}



}