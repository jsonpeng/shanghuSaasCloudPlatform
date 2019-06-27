<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TeamSaleRepository;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

use App\Models\TeamFound;
use App\Models\Order;
use App\Models\Product;

class TeamSaleController extends Controller
{

	private $teamSaleRepository;
    public function __construct(TeamSaleRepository $teamSaleRepo)
    {
        $this->teamSaleRepository = $teamSaleRepo;
    }

    public function index()
    {
    	$teamSales = $this->teamSaleRepository->getTeamSales();
    	return view(frontView('team.index'), compact('teamSales'));
    }

    public function share(Request $request, $found_id)
    {
        $teamFound = TeamFound::where('id', $found_id)->first();
        $order = Order::where('id', $teamFound->order_id)->first();
        $orderItems = $order->items;
        $teamFollows = $order->teamFollow()->take(3)->get();
        $words = null;
        if (!empty($orderItems)) {
            $product = Product::where('id', $orderItems[0]->product_id)->first();
            if (!empty($product)) {
                $words = $product->words;
            }
        }
        return view(frontView('team.share'), compact('teamFound', 'order', 'teamFollows', 'words', 'orderItems'));
    }
}
