<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TeamSaleRepository;

class TeamSaleController extends Controller
{
    private $teamSaleRepository;

    public function __construct(
        TeamSaleRepository $teamSaleRepo)
    {
        $this->teamSaleRepository = $teamSaleRepo;
    }

    /**
     * 团购商品
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function teamSaleProducts(Request $request)
    {
    	$skip = 0;
        $take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $teamSales = $this->teamSaleRepository->getTeamSales($skip, $take);
        return ['status_code' => 0, 'data' => $teamSales];
    }
}
