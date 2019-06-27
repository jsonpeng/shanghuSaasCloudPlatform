<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

use App\Repositories\CreditLogRepository;

class CreditController extends Controller
{
	private $creditLogRepository;

    public function __construct(CreditLogRepository $creditLogRepo)
    {
        $this->creditLogRepository = $creditLogRepo;
    }

	/**
	 * 个人中心积分记录
	 * @return [type] [description]
	 */
    public function index()
    {
    	$user = auth('web')->user();
    	$creditLogs = $this->creditLogRepository->creditLogs($user, 0, 18);
    	return view(frontView('usercenter.credit.index'), compact('user', 'creditLogs'));
    }

    /**
     * 加载更多积分
     * @return [type] [description]
     */
    public function ajaxCredits(Request $request)
    {
    	$skip = 0;
        $take = 18;

        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }

        $user = auth('web')->user();

        $creditLogs = $this->creditLogRepository->creditLogs($user, $skip, $take);

        return ['status_code' => 0, 'data' => $creditLogs];
    }
}
