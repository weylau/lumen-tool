<?php
/*
 |--------------------------------------------------------------------------
 | 守护进程服务
 |--------------------------------------------------------------------------
*/

namespace App\Services\Common;

class DeamonService extends CommonBaseService
{

	/**
	 * @var array 管理守护进程列表
	 */
	protected $proc = [
		'Test' => [
			'desc' => '测试任务进程',
			'callback' => '_restartWithFile',
			'path' => 'proc/JOB_QUEUE.test_%d.die',
            'pnum' => 5,
			'keyword' => 'test',
		],
	];

	protected $file;

	public function __construct()
	{
		parent::__construct();
		$this->file = app('files');
	}

	/**
	 * 以die文件形式重启进程
	 *
	 * @param string $process 进程主体
	 * @return mixed
	 */
	private function _restartWithFile($process)
	{
		//生成die文件
		$dieFile = isset($this->proc[$process]['path']) ? storage_path($this->proc[$process]['path']) : '';
		if(!$dieFile){
			return false;
		}
		if(isset($this->proc[$process]['pnum'])){
            $pnum = $this->proc[$process]['pnum'];
            $i = 0;
			do{
				$this->file->put(sprintf($dieFile, $i), 1);
				$i++;
			}while($i < $pnum);
		}else{
			$this->file->put($dieFile, 1);
		}
		return true;
	}

	/**
	 * 获取进程选项
	 *
	 * @param string $section 选项
	 * @return array|mixed
	 */
	public function getProcOption($section = '')
	{
		return !$section ? $this->proc : (isset($this->proc[$section]) ? $this->proc[$section] : []);
	}

	/**
	 * 重启进程
	 *
	 * @param string $mark 进程标识
	 * @return bool|mixed
	 */
	public function restart($mark = '')
	{
		$ret = false;
		if(!$mark){
			foreach($this->proc as $key => $proc){
				if(isset($proc['callback']) && is_callable([$this, $proc['callback']])){
					$this->log->info("Start to restart the process {$key}.");
					$ret = call_user_func([$this, $proc['callback']], $key);
				}else{
					continue;
				}
			}
		}else{
			if(isset($this->proc[$mark]) && isset($this->proc[$mark]['callback']) && is_callable([$this, $this->proc[$mark]['callback']])){
				$this->log->info("Start to restart the process {$mark}.");
				$ret = call_user_func([$this, $this->proc[$mark]['callback']], $mark);
			}else{
				return false;
			}
		}
		return $ret;
	}


}