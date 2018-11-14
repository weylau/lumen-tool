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
    protected $queueServ;

	public function __construct(Request $request, QueueService $queueServ)
	{
	    $this->queueServ = $queueServ;
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
		$this->queueServ->handle(Queue::TEST_TEST0,0,'_test0',$msg);
		return $this->responseData(200);
	}



}