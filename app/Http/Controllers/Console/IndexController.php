<?php

/*
 |--------------------------------------------------------------------------
 | 首页控制器
 |--------------------------------------------------------------------------
*/

namespace App\Http\Controllers\Console;

use Illuminate\Http\Request;
use App\Services\Common\CommonService;
use App\Consts\Queue;

class IndexController extends ConsoleBaseController
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
	public function index()
	{
		return "<h1>hello world</h1>";
	}

	public function pubTest(){
        $comserv = new CommonService();
        $msg = json_encode([
            'loop' => 0,
            'stime' => 0,
            'etime' => 0,
            'data' => [
                'msg' => 'hello '.str_random(8)
            ],
        ]);

        dd($msg);
        $comserv->addQueue(Queue::TEST_TEST0,$msg);
        return $this->responseData(200);
    }


}