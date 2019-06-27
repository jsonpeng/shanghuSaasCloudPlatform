<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\GroupSaleRepository;
use Illuminate\Support\Facades\Config;

class ProductGroupController extends Controller
{

	private $groupSaleRepository;

    public function __construct(GroupSaleRepository $groupSaleRepo)
    {
        $this->groupSaleRepository = $groupSaleRepo;
    }


    public function index()
    {
    	$groups = $this->groupSaleRepository->getActiveGroupSale();
    	return view(frontView('groupsales.index'), compact('groups'));
    }
}
