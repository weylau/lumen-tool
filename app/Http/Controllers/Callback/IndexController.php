<?php

/*
 |--------------------------------------------------------------------------
 | 首页控制器
 |--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\Callback;

use App\Consts\Queue;
use Illuminate\Http\Request;
use App\Services\Common\QueueService;

class IndexController extends CallbackBaseController
{

	public function __construct(Request $request)
	{
		parent::__construct($request);
	}

	/**
	 * 首页
	 *
	 * @return mixed
	 */
	public function test()
	{
		$msg = $this->input['msg'];
		$queueServ = new QueueService();
		$queueServ->handle(Queue::TEST_TEST0,0,'_test0',$msg);
		$this->responseData(200);
	}



}