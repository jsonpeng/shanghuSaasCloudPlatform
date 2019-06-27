<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateStoreShopRequest;
use App\Http\Requests\UpdateStoreShopRequest;
use App\Repositories\StoreShopRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class StoreShopController extends AppBaseController
{
    /** @var  StoreShopRepository */
    private $storeShopRepository;

    public function __construct(StoreShopRepository $storeShopRepo)
    {
        $this->storeShopRepository = $storeShopRepo;
    }

    /**
     * Display a listing of the StoreShop.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->storeShopRepository->pushCriteria(new RequestCriteria($request));

        //$storeShops = $this->defaultSearchState($this->storeShopRepository->model());

        $storeShops = account($this->storeShopRepository->model());

        $admin_package = getAdminPackageStatus();

        $storeShops_num = count($storeShops->get());

        $storeShops = paginate($storeShops);
        // return  $admin_package;
        return view('admin.store_shops.index')
            ->with('admin_package',$admin_package)
            ->with('storeShops', $storeShops)
            ->with('storeShops_num',$storeShops_num);
    }

    public function selectShopRedirect(Request $request,$shop_id){
        session([admin()->id.'shop_id'=>$shop_id]);
        $redirect_url = '/zcjy/settings/setting';
        $input = $request->all();
        if(array_key_exists('redirect_url',$input)){
            $redirect_url = $input['redirect_url'];
        }
        return redirect($redirect_url);
    }

    /**
     * Show the form for creating a new StoreShop.
     *
     * @return Response
     */
    public function create()
    {
        $admin_package = getAdminPackageStatus();
        if(count($admin_package['shops']) >= $admin_package['package']['canuse_shop_num']){
                return redirect(route('storeShops.index'))
                        ->withErrors('当前套餐的店铺已添加到上限,如想继续添加店铺请升级套餐');
                        
        }
        return view('admin.store_shops.create');
    }

    /**
     * Store a newly created StoreShop in storage.
     *
     * @param CreateStoreShopRequest $request
     *
     * @return Response
     */
    public function store(CreateStoreShopRequest $request)
    {
        $input = $request->all();
        
        $input = attachAccoutInput($input);

       

        $storeShop = $this->storeShopRepository->create($input);

        Flash::success('保存成功.');

        return redirect(route('storeShops.index'));
    }

    /**
     * Display the specified StoreShop.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $storeShop = $this->storeShopRepository->findWithoutFail($id);

        if (empty($storeShop)) {
            Flash::error('Store Shop not found');

            return redirect(route('storeShops.index'));
        }

        return view('admin.store_shops.show')->with('storeShop', $storeShop);
    }

    /**
     * Show the form for editing the specified StoreShop.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $storeShop = $this->storeShopRepository->findWithoutFail($id);

        if (empty($storeShop)) {
            Flash::error('Store Shop not found');

            return redirect(route('storeShops.index'));
        }

        return view('admin.store_shops.edit')->with('storeShop', $storeShop);
    }

    /**
     * Update the specified StoreShop in storage.
     *
     * @param  int              $id
     * @param UpdateStoreShopRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStoreShopRequest $request)
    {
        $storeShop = $this->storeShopRepository->findWithoutFail($id);

        if (empty($storeShop)) {
            Flash::error('Store Shop not found');

            return redirect(route('storeShops.index'));
        }

        $storeShop = $this->storeShopRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('storeShops.index'));
    }

    /**
     * Remove the specified StoreShop from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $storeShop = $this->storeShopRepository->findWithoutFail($id);

        if (empty($storeShop)) {
            Flash::error('Store Shop not found');

            return redirect(route('storeShops.index'));
        }

        $this->storeShopRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('storeShops.index'));
    }
}
