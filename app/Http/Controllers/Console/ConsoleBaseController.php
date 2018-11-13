<?php

/*
 |--------------------------------------------------------------------------
 | 控制台基础控制器
 |--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\Console;

use App\Http\Controllers\ApiBaseController;
use Illuminate\Http\Request;

class ConsoleBaseController extends ApiBaseController
{

	protected $request;
	protected $input;

	protected $errCode;
	protected $errMsg;

	public function __construct(Request $request)
	{
		parent::__construct();
		$this->request = $request;
		$this->input = $request->input();
		$this->__init();
	}

	public function __init(){

	}

	/**
	 * 验证数据
	 * @param array $rules
	 * @return mixed
	 */
	public function validateData($rules = [])
	{
		if(empty($rules) || !is_array($rules)){
			$this->errCode = 600;
			$this->errMsg = '验证规则有误';
			return false;
		}
		$validator = app('validator')->make($this->request->all(), $rules);
		if($validator->fails()){
			$this->errCode = 600;
			$this->errMsg = $validator->getMessageBag()->first();
			return false;
		}
		return true;
	}


	/**
	 * 处理控制器统一返回值
	 *
	 * @param array $data
	 * @return array
	 */
	public function responseData($data = [])
	{
		$ret = ['code' => 200, 'msg' => 'OK'];
		if(is_numeric($data)){
			$errMsg = trans('errcode');
			$ret['code'] = $data;
			$ret['msg'] = isset($errMsg[$data]) ? $errMsg[$data] : '未知错误';
		}else{
			if($this->errCode || $this->errMsg){
				$ret['code'] = $this->errCode ? $this->errCode : '';
				$ret['msg'] = $this->errMsg ? $this->errMsg : '';
			}
			$ret['data'] = $data;
		}
		return $ret;
	}

	/**
	 * 返回layui表格数据
	 *
	 * @param array $data
	 * @return array
	 */
	public function responseTableData($data = [])
	{
		$ret = ['code' => 0, 'msg' => 'OK'];
		if(is_numeric($data)){
			$errMsg = trans('errcode');
			$ret['code'] = $data;
			$ret['msg'] = isset($errMsg[$data]) ? $errMsg[$data] : '未知错误';
		}else{
			if($this->errCode || $this->errMsg){
				$ret['code'] = $this->errCode ? $this->errCode : '';
				$ret['msg'] = $this->errMsg ? $this->errMsg : '';
			}
			$ret['data'] = isset($data['data']) ? $data['data'] : [];
			$ret['count'] = isset($data['total']) ? $data['total'] : 0;
		}
		return $ret;
	}

}