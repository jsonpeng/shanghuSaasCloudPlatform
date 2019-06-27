<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

use App\Repositories\FlashSaleRepository;

use Carbon\Carbon;

class FlashSaleController extends Controller
{

    private $flashSaleRepository;

    public function __construct(FlashSaleRepository $flashSaleRepo)
    {
        $this->flashSaleRepository = $flashSaleRepo;
    }

    public function index(Request $request)
    {
    	$today =  processTime( Carbon::now() );

    	$time01 = $today;
    	$time02 = $today->copy()->addDays(1);
    	$time03 = $today->copy()->addDays(2);
    	$time04 = $today->copy()->addDays(3);
    	$time05 = $today->copy()->addDays(4);

        //取查询参数
        $inputs = $request->all();
        $time_begin = $time01;
        //$time_end = $time02;
        if (array_key_exists('time_begin', $inputs) && !empty($inputs['time_begin'])) {
            $time_begin = $inputs['time_begin'];
        }
        $sales = $this->flashSaleRepository->salesBetweenTime(0, 20, $time_begin);
        //dd($time_begin);
    	return view(frontView('flashsales.index'), compact('inputs','time01', 'time02', 'time03', 'time04', 'time05', 'sales', 'time_begin'));
    }

}
