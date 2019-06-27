<?php

namespace App\Http\Controllers\Admin\Shop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

use App\Repositories\StatRepositoryRepository as StatRepository;

class StatController extends Controller
{
	private $statRepository; 

	public function __construct( StatRepository $statRepo )
    {
        $this->statRepository = $statRepo;
    }

    public function index(Request $request) {
    	// 今日规格统计
    	$todayItems = $this->statRepository->rangeItemStats(Carbon::today(), Carbon::tomorrow());
    	$weekItems = $this->statRepository->rangeItemStats(Carbon::today()->startOfWeek(), Carbon::tomorrow());
    	$monthItems = $this->statRepository->rangeItemStats(Carbon::today()->startOfMonth(), Carbon::tomorrow());
    	//销量成本统计
    	$todaySales = $this->statRepository->rangeSaleStats(Carbon::today(), Carbon::tomorrow());
    	$weekSales = $this->statRepository->rangeSaleStats(Carbon::today()->startOfWeek(), Carbon::tomorrow());
    	$monthSales = $this->statRepository->rangeSaleStats(Carbon::today()->startOfMonth(), Carbon::tomorrow());
    	//新增用户数
    	$todayUsers = $this->statRepository->rangeUserStats(Carbon::today(), Carbon::tomorrow());
    	$weekUsers = $this->statRepository->rangeUserStats(Carbon::today()->startOfWeek(), Carbon::tomorrow());
    	$monthUsers = $this->statRepository->rangeUserStats(Carbon::today()->startOfMonth(), Carbon::tomorrow());

    	$input=$request->all();
        $customItems=null;
        $customSales=null;
        $customUsers=null;
        $show=null;
        $time_begin = Carbon::parse('2018-01-01');
        $time_end =  Carbon::tomorrow();

    	if(array_key_exists('start_time',$input) && !empty($input['start_time'])){
    	    $time_begin = Carbon::parse($input['start_time']);
    	    $show=1;
        }

        if(array_key_exists('end_time',$input) && !empty($input['end_time'])){
        	$time_end = Carbon::parse($input['end_time']);
        	$show=1;
        }

        $customItems = $this->statRepository->rangeItemStats($time_begin, $time_end);
    	$customSales = $this->statRepository->rangeSaleStats($time_begin, $time_end);
    	$customUsers = $this->statRepository->rangeUserStats($time_begin, $time_end);
        // dd($todaySales->total_sales);
        //return $todayUsers;
    	return view('admin.stat.index', compact('input','show','customItems','customSales','customUsers','todayItems', 'weekItems', 'monthItems', 'todaySales', 'weekSales', 'monthSales', 'todayUsers', 'weekUsers', 'monthUsers'));
    }

    // 下载统计报告
    public function report(Request $request) {
    	$input = $request->all();
    	if (!array_key_exists('timerange', $input)) {
    		return '请输入时间段信息';
    	}
    	$timerange = $request['timerange'];
    	$dateArr = explode(" - ", $timerange);
    	if (sizeof($dateArr) == 2) {
    		//$startDate = Carbon::createFromFormat('Y-m-d', $dateArr[0]);
    		//$endDate = Carbon::createFromFormat('Y-m-d', $dateArr[1]);
    		// 查询数据
    		$data01 = $this->statRepository->ItemStats($timerange);
    		$data02 = $this->statRepository->OrderStats($timerange);
    		$data03 = $this->statRepository->UserStats($timerange);
    		Excel::create($timerange.'报告', function($excel) use($data01, $data02, $data03) {
	    		// Our first sheet
			    $excel->sheet('菜品销量', function($sheet) use($data01) {
			    	$sheet->setWidth(array(
					    'A'     =>  10,
					    'B'     =>  10,
					    'C'     =>  10,
					    'D'     =>  10
					));
			    	// Append row as very last
			    	$sheet->appendRow(array('商品名称', '规格', '数量', '日期'));
			    	$valueArr = $data01->toArray();
			    	foreach ($valueArr as $key => $value) {
			    		$sheet->appendRow($value);
			    	}
			    	
			    });
			    $excel->sheet('订单详情', function($sheet) use($data02) {
			    	$sheet->setWidth(array(
					    'A'     =>  10,
					    'B'     =>  10,
					    'C'     =>  10,
					    'D'     =>  10,
					    'E'     =>  10,
					    'F'     =>  10,
					    'G'     =>  10,
					    'H'     =>  10,
					    'I'     =>  10,
					    'J'     =>  10,
					    'K'     =>  10,
					    'L'     =>  10,
					    'M'     =>  10,
					    'N'     =>  10,
					    'O'     =>  10,
					    'P'     =>  10,
					    'Q'     =>  10,
					    'R'     =>  10,
					    'S'     =>  10
					));
			    	// Append row as very last
			    	$sheet->appendRow(array('订单编号', '价格', '成本', '原价', '优惠', '运费', '送货日期', '支付类型', '发票抬头', '税号', '订单状态', '送货状态', '支付状态', '备注', '餐厅名称', '收货人', '联系方式', '地址', '订单提交日期'));
			    	$data02 = $data02->each(function ($item, $key) use(&$sheet) {
			    		$sheet->appendRow(array(
			    			$item->snumber,
			    			$item->price,
			    			$item->cost,
			    			$item->origin_price,
			    			$item->preferential,
			    			$item->freight,
			    			$item->sendtime,
			    			$item->pay_type,
			    			$item->invoice_title,
			    			$item->tax_no,
			    			$item->order_status,
			    			$item->order_delivery,
			    			$item->order_pay,
			    			$item->remark,
			    			$item->canteen()->first()->name,
			    			$item->canteen()->first()->fuzeren,
			    			$item->canteen()->first()->contact,
			    			$item->canteen()->first()->address,
			    			$item->created_at
			    		));
					});
			    });
			    $excel->sheet('用户数', function($sheet) use($data03) {
			    	$sheet->setWidth(array(
					    'A'     =>  10,
					    'B'     =>  10
					));
			    	// Append row as very last
			    	$sheet->appendRow(array('新增用户',  '日期'));
			    	$valueArr = $data03->toArray();
			    	foreach ($valueArr as $key => $value) {
			    		$sheet->appendRow($value);
			    	}
			    });
			})->download('xls');
    	}else{
    		return '时间段信息输入不正确';
    	}
    	
    }
}
