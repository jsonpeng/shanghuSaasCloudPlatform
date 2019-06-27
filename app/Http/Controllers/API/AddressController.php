<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Repositories\AddressRepository;
use App\Repositories\CityRepository;

class AddressController extends Controller
{

    private $addressRepository;
    private $cityRepository;
    public function __construct(AddressRepository $addressRepo,CityRepository $cityRepo)
    {
        $this->addressRepository = $addressRepo;
        $this->cityRepository=$cityRepo;
    }



    public function default(Request $request, $address_id, $default)
    {
        $user = auth()->user();
        if ($default) {
            $user->addresses()->update(['default' => 'false']);
        }
        $this->addressRepository->update(['default' => $default], $address_id);

        return ['status_code'=>0,'data'=>'设置默认地址成功'];
    }


    /**
     *获取地址列表
     */
    public function getAddressList(Request $request){
        $user = auth()->user();
        $addresses = $user->addresses()->get();
        return ['status_code' => 0, 'data' => $addresses];
    }

    /**
     * 获取单个地址
     * @param  Request $request    [description]
     * @param  [type]  $address_id [description]
     * @return [type]              [description]
     */
    public function getAddressOne($address_id){
        $address = $this->addressRepository->findWithoutFail($address_id);
        $cities_level1=$this->cityRepository->getBasicLevelCities();
        $selectedCities=['province'=>$address->province,'city'=>$address->city,'district'=>$address->district];
        if (empty($address)) {
            return ['status_code' => 1, 'data' => '没有找到该地址'];
        }
        $cities_level2=$this->cityRepository->getLevelNumCities(2);
        $cities_level3=$this->cityRepository->getLevelNumCities(3);

        return ['status_code' => 0, 'data' => ['address'=>$address, 'cities_level1'=>$cities_level1,'cities_level2'=>$cities_level2,'cities_level3'=>$cities_level3,'selectedCities'=>$selectedCities]];
    }

	/**
	 * 增加地址
	 * @param Request $request [description]
     * input提交过来的值
     * name
     * default 带上当前添加为默认地址
     * phone
     * province
     * city
     * district
     * detail
     * checknow 带上结算时添加地址
	 */
	public function addAddress(Request $request)
	{
		# code...
        $inputs = $request->all();

        $user = auth()->user();
        $inputs['user_id'] = $user->id;
        if (array_key_exists('default', $inputs)) {
            $inputs['default'] = 'true';
            $user->addresses()->update(['default' => 'false']);
        }
        //新建地址
        $address = Address::create($inputs);
        $redirect_url='address_list_url';
        if(array_key_exists('checknow', $inputs)){
            if(!empty($inputs['checknow'])){
                $redirect_url='checknow_url';
            }
        }
        return ['status_code' => 0, 'data' => $address,'redirect_url'=>$redirect_url];

	}

	/**
	 * 修改地址
	 * @param  Request $request    [description]
	 * @param  [type]  $address_id [description]
	 * @return [type]              [description]
	 */
	public function modifyAddress(Request $request, $address_id)
	{
		# code...
        $address = $this->addressRepository->findWithoutFail($address_id);
        if (empty($address)) {
            return ['status_code' => 1, 'data' => '没有找到该地址'];
        }
        //处理默认地址
        $inputs = $request->all();
        $user = auth()->user();
        if (array_key_exists('default', $inputs)) {
            $inputs['default'] = 'true';
            $user->addresses()->update(['default' => 'false']);
        }

        $inputs['user_id'] = $user->id;

        $address = $this->addressRepository->update($inputs, $address_id);
        return ['status_code' => 0, 'data' => $address];

	}

	/**
	 * 删除地址
	 * @param  Request $request    [description]
	 * @param  [type]  $address_id [description]
	 * @return [type]              [description]
	 */
	public function deleteAddress(Request $request, $address_id)
	{
		# code...
        $address = $this->addressRepository->findWithoutFail($address_id);

        if (empty($address)) {
            return ['status_code' => 0, 'data' => '地址信息不存在'];
        }

        $this->addressRepository->delete($address_id);
        return ['status_code' => 0, 'data' => '删除成功'];
	}

	/**
	 * 获取省份列表
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function provinces(Request $request)
	{
		# code...
        $provinces=$this->cityRepository->getBasicLevelCities();
        return ['status_code' => 0, 'data' => $provinces];

	}

	/**
	 * 获取市列表
	 * @param  Request $request     [description]
	 * @param  [type]  $province_id [description]
	 * @return [type]               [description]
	 */
	public function cities(Request $request, $cities_id)
	{
		# code...
        $cities_list=$this->cityRepository->getChildCitiesById($cities_id);
        return ['status_code' => 0, 'data' => $cities_list];
	}

	/**
	 * 获取区列表
	 * @param  Request $request [description]
	 * @param  [type]  $city_id [description]
	 * @return [type]           [description]

	public function districts(Request $request, $city_id)
	{
		# code...
	}
     */

}
