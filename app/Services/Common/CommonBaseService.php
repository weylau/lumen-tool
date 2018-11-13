<?php
/*
 |--------------------------------------------------------------------------
 | 公共服务基类
 |--------------------------------------------------------------------------
*/

namespace App\Services\Common;


class CommonBaseService
{
	protected $log;

	public function __construct() {
		$this->log = app('log');
	}

	/**
	 * 根据参数自动生成查询条件
	 *
	 * @param array $data 参数
	 * @param object $model 实例
	 * @return array
	 */
	public function getCondition($data, $model)
	{
		$condition = [];
		if(!is_callable([$model, 'getFillable']) || !is_callable([$model, 'getSearchMatch'])){
			return $condition;
		}
		$fields = $model->getFillable();
		$searchMatch = $model->getSearchMatch();
		foreach($fields as $field){
			if(isset($data[$field]) && $data[$field]){
				if(in_array($field, array_keys($searchMatch))){
					$condition[$field] = [$searchMatch[$field], $data[$field]];
				}else{
					$condition[$field] = $data[$field];
				}
			}
		}
		return $condition;
	}

}