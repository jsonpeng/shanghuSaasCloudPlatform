<?php

namespace App\Http\Controllers\Admin\Headquarter;

use App\Http\Requests\CreateChargePackageRequest;
use App\Http\Requests\UpdateChargePackageRequest;
use App\Repositories\ChargePackageRepository;
use App\Models\Word;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Config;

class ChargePackageController extends AppBaseController
{
    /** @var  ChargePackageRepository */
    private $chargePackageRepository;

    public function __construct(ChargePackageRepository $chargePackageRepo)
    {
        $this->chargePackageRepository = $chargePackageRepo;
    }

    /**
     * Display a listing of the ChargePackage.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->chargePackageRepository->pushCriteria(new RequestCriteria($request));
        $chargePackages = $this->chargePackageRepository->all();
        

        return view('headquarter.charge_packages.index')
            ->with('chargePackages', $chargePackages);
    }

    /**
     * Show the form for creating a new ChargePackage.
     *
     * @return Response
     */
    public function create()
    {
        $packages = Config::get('zcjy.shop.package');
        $wordlist=Word::all();
        $selectedWords=[];
        return view('headquarter.charge_packages.create')
                ->with('packages',$packages)
                ->with('wordlist',$wordlist)
                ->with('selectedWords',$selectedWords);
    }

    /**
     * Store a newly created ChargePackage in storage.
     *
     * @param CreateChargePackageRequest $request
     *
     * @return Response
     */
    public function store(CreateChargePackageRequest $request)
    {
        $input = $request->all();

        $varify = $this->varifyInput($input);

        if($varify){
             return redirect(route('chargePackages.create'))
                    ->withErrors($varify)
                    ->withInput($input);
        }

        $create_input =  array_filter( $input, function($v, $k) {
            return $k != 'prices' && $k != 'years';
        }, ARRAY_FILTER_USE_BOTH );

        $chargePackage = $this->chargePackageRepository->create($create_input);

        $this->attachPackagePrices($input,$chargePackage);

        Flash::success('保存成功.');

        return redirect(route('chargePackages.index'));
    }

    /**
     * [验证下套餐组合金额]
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    private function varifyInput($input){
        $status = false;
        if(array_key_exists('prices',$input)){
            if(empty($input['prices'])){
                $status = '请输入套餐组合金额';
            }
            else{
                foreach ($input['prices'] as $key => $val) {
                    if(empty($val)){
                         $status = '请输入套餐组合金额';
                    }
                }
            }
        }
        return $status;
    }

    /**
     * [关联套餐组合金额]
     * @param  [type] $input         [description]
     * @param  [type] $chargePackage [description]
     * @return [type]                [description]
     */
    private function attachPackagePrices($input,$chargePackage){
            #先置空
            app('commonRepo')->packagePriceRepo()->emptyById($chargePackage->id);
            $attr = $input['years'];
            foreach ($attr as $k => $val) {
                   #重新添加
                   app('commonRepo')->packagePriceRepo()->create([
                    'package_id' => $chargePackage->id,
                    'years' => $input['years'][$k],
                    'price'=> $input['prices'][$k],
                    'origin_price' => $input['origin_prices'][$k],
                    'bonus_one' => $input['bonus_ones'][$k],
                    'bonus_two' => $input['bonus_twos'][$k]
                    ]);
            }

    }
    /**
     * Display the specified ChargePackage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $chargePackage = $this->chargePackageRepository->findWithoutFail($id);

        if (empty($chargePackage)) {
            Flash::error('没有找到该套餐');

            return redirect(route('chargePackages.index'));
        }

        return view('headquarter.charge_packages.show')->with('chargePackage', $chargePackage);
    }

    /**
     * Show the form for editing the specified ChargePackage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $chargePackage = $this->chargePackageRepository->findWithoutFail($id);

        if (empty($chargePackage)) {
            Flash::error('没有找到该套餐');

            return redirect(route('chargePackages.index'));
        }
        //套餐组合金额
        $prices = $chargePackage->prices()->orderBy('years','asc')->get();
        $packages = Config::get('zcjy.shop.package');
        $wordlist=Word::all();
        $selectedWords=[];
        $package_words= $chargePackage->words()->get();
        if(!empty($package_words)){
           foreach ($package_words as $item){
               array_push($selectedWords,$item->id);
           }
       }

        return view('headquarter.charge_packages.edit')
            ->with('packages',$packages)
            ->with('prices',$prices)
            ->with('chargePackage', $chargePackage)
            ->with('wordlist',$wordlist)
            ->with('selectedWords',$selectedWords);
    }

    /**
     * Update the specified ChargePackage in storage.
     *
     * @param  int              $id
     * @param UpdateChargePackageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateChargePackageRequest $request)
    {
        $chargePackage = $this->chargePackageRepository->findWithoutFail($id);

        if (empty($chargePackage)) {
            Flash::error('没有找到该套餐');

            return redirect(route('chargePackages.index'));
        }

        $input = $request->all();

        $varify = $this->varifyInput($input);

        if($varify){
             return redirect(route('chargePackages.edit',$id))
                    ->withErrors($varify)
                    ->withInput($input);
        }

        $update_input =  array_filter($input, function($v, $k) {
            return $k != 'prices' && $k != 'years';
        }, ARRAY_FILTER_USE_BOTH);

        $chargePackage = $this->chargePackageRepository->update($update_input, $id);

        $this->attachPackagePrices($input,$chargePackage);

        Flash::success('更新成功.');

        return redirect(route('chargePackages.index'));
    }

    /**
     * Remove the specified ChargePackage from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $chargePackage = $this->chargePackageRepository->findWithoutFail($id);

        if (empty($chargePackage)) {
            Flash::error('没有找到该套餐');

            return redirect(route('chargePackages.index'));
        }

        $this->chargePackageRepository->delete($id);

        app('commonRepo')->packagePriceRepo()->emptyById($id);

        Flash::success('删除成功.');

        return redirect(route('chargePackages.index'));
    }


    public function wordsList(){
        $wordList=Word::all();
        return view('headquarter.word.wordlist')
            ->with('wordList',$wordList);
    }

    public function wordsListAdd(){
        return view('headquarter.word.wordlist_add');
    }

    public function wordsListStore(Request $request){
        $input=$request->all();
        if(empty($input['name'])){
                return redirect(route('wordlist.create'))
                    ->withErrors('名称不能为空')
                    ->withInput($input);
        }
        Word::create($input);
        Flash::success('套餐条目添加成功');
        return redirect(route('wordlist.index'));
    }

    public function wordsListDestroy($id){
        //删除与套餐的关联信息
        
        $packageWord=Word::find($id);

        if(!empty($packageWord)){
            $packageWord->packages()->sync([]);
            $packageWord->delete();
        }

        Flash::success('套餐条目删除成功');
        return redirect(route('wordlist.index'));
    }

    public function wordsListUpdate(Request $request,$id){
        $input=$request->all();
        $word=Word::find($id);
        if(!empty($word)){
            $word->update(['name'=>$input['name']]);
            return ['code'=>0,'message'=>$input['name']];
        }else {
            return ['code'=>1,'message'=>'未知错误'];
        }
    }


}
