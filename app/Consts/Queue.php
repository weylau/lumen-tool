<?php
/*
 |--------------------------------------------------------------------------
 | 命令字常量
 |--------------------------------------------------------------------------
 | 命名规范：
 | 1. 键值对统一大写
 | 2. 每次新增一个队列任务，都要在这里注册一个队列名称
 |
*/

namespace App\Consts;

class Queue extends BaseConsts
{

	const TEST_TEST0 = 'TEST:TEST0';						//测试队列

	/**
	 * 获取所有队列常量
	 *
	 * @return array
	 */
	public static function getConstants()
	{
		$obj = new \ReflectionClass(__CLASS__);
		$ret = $obj->getConstants();
		return $ret;
	}
}
