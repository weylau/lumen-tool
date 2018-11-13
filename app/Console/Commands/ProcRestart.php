<?php

/*
 |--------------------------------------------------------------------------
 | 进程管理脚本
 |--------------------------------------------------------------------------
*/

namespace App\Console\Commands;

use App\Services\Common\DeamonService;

class ProcRestart extends BaseCommand
{
	/**
	 * 命令名称
	 *
	 * @var string
	 */
	protected $signature = 'proc:restart';

	/**
	 * 命令描述
	 *
	 * @var string
	 */
	protected $description = '重启守护进程';

	protected $deamonService;


	/**
	 * Create a new command instance.
	 * @return void
	 */
	public function __construct(DeamonService $deamonService)
	{
		parent::__construct();
		$this->deamonService = $deamonService;
	}

	/**
	 * Execute the console command.
	 * @return mixed
	 */
	public function handle()
	{
		$token = $this->ask("This operation is very dangerous,please tell me what the token is?");
		if($token != env('OPTOKEN', 'nozuonodie')){
			$this->error("Sorry, you have no permition to operate this.");
			return false;
		}
		$choice = $this->choice('Please choose the process you want to excute, type ctrl+c to exit', array_merge(['all'], array_keys($this->deamonService->getProcOption())));
		$choice = $choice == 'all' ? NULL : $choice;
		$ret = $this->deamonService->restart($choice);
		if($ret){
			$this->_info("Process {$choice} has been restarted successfully. ---- " . date('Y-m-d H:i:s'));
			return true;
		}else{
			$this->_error("Process {$choice} has been restarted failed. ---- " . date('Y-m-d H:i:s'));
			return false;
		}
	}

}

