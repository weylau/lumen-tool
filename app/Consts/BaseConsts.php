<?php
/*
 |--------------------------------------------------------------------------
 | 常量基类
 |--------------------------------------------------------------------------
 | 命名规范：
 | 1. 键值对统一大写
 |
*/

namespace App\Consts;

class BaseConsts
{


	/**
	 * 获取所有常量
	 *
	 * @return array
	 */
	public static function getConstants()
	{
		$obj = new \ReflectionClass(__CLASS__);
		return $obj->getConstants();
	}
}
