<?php

/*
 |--------------------------------------------------------------------------
 | 命令基类
 |--------------------------------------------------------------------------
 |
 |
*/

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'base:command';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Base commond class.';

	protected $log;

	protected $file;

	/**
	 * @var array 默认选项
	 */
	protected $retainOptions = [
		'help' => false,
		'quiet' => false,
		'verbose' => false,
		'version' => false,
		'ansi' => false,
		'no-ansi' => false,
		'no-interaction' => false,
		'env' => NULL,
	];

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->__init();
	}

	/**
	 * 初始化方法
	 */
	public function __init()
	{
		$this->log = app('log');
		$this->file = app('files');
	}

	/**
	 * Execute the console command.
	 *
	 */
	public function handle()
	{

	}

	public function __call($name, $arg)
	{
		if(in_array($name, ['_info', '_error'])){
			$arguments = $this->arguments();
			$options = array_diff_assoc($this->options(), $this->retainOptions);
			$options = $this->_parseOptions($options);
			$command = isset($arguments['command']) ? $arguments['command'] : '';
			unset($arguments['command']);
			$param = head($arguments);
			$data = isset($arg[0]) ? $arg[0] : '';
			$msg = "[ ARTISAN php artisan {$command} {$param}{$options} ] {$data}";
			$callback = ltrim($name, '_');
			if(is_callable([$this, $callback])){
				call_user_func_array([$this, $callback], [$msg]);
			}
			if(is_callable([$this->log, $callback])){
				call_user_func_array([$this->log, $callback], [$msg]);
			}
		}
	}

	/**
	 * 选项格式化
	 *
	 * @param array $options 选项
	 */
	private function _parseOptions($options)
	{
		$str = '';
		foreach($options as $k => $v){
			$str .= " --{$k}={$v}";
		}
		return $str;
	}
}
