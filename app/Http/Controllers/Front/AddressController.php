<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use App\Repositories\AddressRepository;
use App\Repositories\CityRepository;
use App\Models\Address;
use App\User;
use Validator;
use App\Models\Cities;

use App\Http\Requests\CreateAddressRequest;
use App\Http\Requests\UpdateAddressRequest;

class AddressController extends Controller
{

    private $addressRepository;
    private $cityRepository;
    public function __construct(AddressRepository $addressRepo,CityRepository $cityRepo)
    {
        $this->addressRepository = $addressRepo;
        $this->cityRepository=$cityRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('web')->user();
        $addresses = $user->addresses()->get();

        return view(frontView('address.index'))->with('addresses', $addresses);
    }

    public function change(Request $request)
    {
        $user = auth('web')->user();
        $addresses = $user->addresses()->get();

        //返回哪个页面
        if ($request->has('backupcheck')) {
            $request->session()->flash('backupcheck', $request->input('backupcheck'));
        }

        return view(frontView('address.change'))->with('addresses', $addresses)->with('backupcheck', $request->input('backupcheck'));
    }

    public function select(Request $request, $id)
    {
        $address = $this->addressRepository->findWithoutFail($id);
        if (empty($address )) {
            $address = $this->addressRepository->getDefaultAddress();
        }
        $request->session()->put('curAddress', $address);

        if ($request->session()->has('backupcheck')) {
            if (session('backupcheck') == '1') {
                return redirect('/check');
            } else {
                return redirect($request->session()->get('checknow_url'));
            }
        } else {
            return redirect('/check');
        }
    }

    public function default(Request $request, $id, $default)
    {
        $user = auth('web')->user();
        if ($default) {
            $user->addresses()->update(['default' => 'false']);
        }
        $this->addressRepository->update(['default' => $default], $id);

        return ['code'=>0,'message'=>'设置默认地址成功'];
    }

    public function create(Request $request)
    {
        if ($request->has('backupcheck')) {
            $request->session()->put('backupcheck', $request->input('backupcheck'));
        }
        $cities=$this->cityRepository->getBasicLevelCities();

        return view(frontView('address.create'))->with('cities',$cities);
                
    }

    public function store(CreateAddressRequest $request)
    {
    	$inputs = $request->all();

        $user = auth('web')->user();
        $inputs['user_id'] = $user->id;
        if (array_key_exists('default', $inputs)) {
        	$inputs['default'] = 'true';
        	$user->addresses()->update(['default' => 'false']);
        }
        //新建地址
        $address = Address::create($inputs);
        if ($request->session()->has('backupcheck')) {
            $request->session()->put('curAddress', $address);
            if (session('backupcheck') == '1') {
                $request->session()->forget('backupcheck');
                return redirect('/check');
            } else {
                $request->session()->forget('backupcheck');
                return redirect($request->session()->get('checknow_url'));
            }
        } else {
            return redirect('/address');
        }
    }

    public function edit(Request $request, $id)
    {
        $address = $this->addressRepository->findWithoutFail($id);
        $cities=$this->cityRepository->getBasicLevelCities();
        $selectedCities=['province'=>$address->province,'city'=>$address->city,'district'=>$address->district];
        if (empty($address)) {
            return redirect('/address');
        }
        $cities_level2=$this->cityRepository->getLevelNumCities(2);
        $cities_level3=$this->cityRepository->getLevelNumCities(3);

        return view(frontView('address.edit'), compact('address','cities','cities_level2','cities_level3','selectedCities'));
        
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        $address = $this->addressRepository->findWithoutFail($id);
        if (empty($address)) {
            return redirect('/address');
        }
        //处理默认地址
        $inputs = $request->all();
        $user = auth('web')->user();
        if (array_key_exists('default', $inputs)) {
            $inputs['default'] = 'true';
            $user->addresses()->update(['default' => 'false']);
        }

        $inputs['user_id'] = $user->id;

        $address = $this->addressRepository->update($inputs, $id);

        return redirect('/address');
    }

    public function delete(Request $request, $id)
    {
        $address = $this->addressRepository->findWithoutFail($id);

        if (empty($address)) {
            return ['code' => 0, 'message' => '地址信息不存在'];
        }

        $this->addressRepository->delete($id);
        return ['code' => 0, 'message' => '删除成功'];
    }

    public function CitiesAjaxSelect($id){
        $cities=Cities::where('pid',$id)->get();
        $ajax_select=null;
        if(!empty($cities)){
            foreach ($cities as $city){
                $ajax_select .="<option value=".$city->id.">".$city->name."</option>";
            }
            return ['code'=>0,'message'=>$ajax_select];
        }else{
            return ['code'=>1,'message'=>'无'];
        }
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
        	'name' => 'required|max:10|min:2',
            'phone' => 'required|max:11|min:11',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'detail' => 'required',
        ]);
    }


}
