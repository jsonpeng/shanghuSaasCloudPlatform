<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Repositories\ItemRepository;
use App\Repositories\OrderRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Order;

class ItemController extends AppBaseController
{
    /** @var  ItemRepository */
    private $itemRepository;
    private $orderRepository;

    public function __construct(ItemRepository $itemRepo, OrderRepository $orderRepo)
    {
        $this->itemRepository = $itemRepo;
        $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the Item.
     *
     * @param Request $request
     * @return Response
     
    public function index(Request $request)
    {
        $this->itemRepository->pushCriteria(new RequestCriteria($request));
        $items = $this->itemRepository->all();

        return view('items.index')
            ->with('items', $items);
    }*/

    /**
     * Show the form for creating a new Item.
     *
     * @return Response
    
    public function create()
    {
        return view('items.create');
    }
 */
    /**
     * Store a newly created Item in storage.
     *
     * @param CreateItemRequest $request
     *
     * @return Response
     
    public function store(CreateItemRequest $request)
    {
        $input = $request->all();

        $item = $this->itemRepository->create($input);

        Flash::success('Item saved successfully.');

        return redirect(route('items.index'));
    }
*/
    /**
     * Display the specified Item.
     *
     * @param  int $id
     *
     * @return Response
     
    public function show($id)
    {
        $item = $this->itemRepository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error('Item not found');

            return redirect(route('items.index'));
        }

        return view('items.show')->with('item', $item);
    }
*/
    /**
     * Show the form for editing the specified Item.
     *
     * @param  int $id
     *
     * @return Response
     
    public function edit($id)
    {
        $item = $this->itemRepository->findWithoutFail($id);

        if (empty($item)) {
            Flash::error('Item not found');

            return redirect(route('items.index'));
        }

        return view('items.edit')->with('item', $item);
    }
*/
    /**
     * Update the specified Item in storage.
     *
     * @param  int              $id
     * @param UpdateItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemRequest $request)
    {
        $item = $this->itemRepository->findWithoutFail($id);

        if (empty($item)) {
            return ['message' => "您要编辑的商品不存在", 'code' => 404];
        }

        $item = $this->itemRepository->update($request->all(), $id);

        $this->orderRepository->reCaculateOrderPrice($item->order_id);
        
        return ['message' => $item, 'code' => 0];
    }

    /**
     * Remove the specified Item from storage.
     *
     * @param  int $id
     *
     * @return Response
    */
    public function destroy($id)
    {
        $item = $this->itemRepository->findWithoutFail($id);

        if (empty($item)) {
            return ['message' => '信息不存在', 'code' => 0];
        }

        $this->itemRepository->delete($id);

        $this->orderRepository->reCaculateOrderPrice($item->order_id);

        return redirect(route('orders.show', ['id' => $item->order_id]));
    }

    /*
    private function reCaculateOrderPrice($order_id)
    {
        //重新计算订单价格
        $order = $this->orderRepository->findWithoutFail($order_id);
        if (!empty($order)) {
            $items = $order->items()->get();
            $origin_price = 0;
            foreach ($items as $key => $item) {
                $origin_price += $item->price * $item->count;
            }
            //计算运费

            //如果使用了优惠券，则计算优惠价格
            $coupon = $order->coupons()->first();
            if (is_null($coupon)) {
                $new_price = $origin_price - $order->preferential + $order->freight;
                $this->orderRepository->update(['origin_price' => $origin_price, 'price' => $new_price], $order->id);
            }else{
                $youhui = 0;
                if ($coupon->type == '满减') {
                    $youhui = $coupon->given;
                } else if ($coupon->type == '打折'){
                    $youhui = $origin_price * (100 - $coupon->discount) / 100;
                }
                // 将优惠券冻结
                $new_price = $origin_price - $youhui + $order->freight;
                $this->orderRepository->update(['origin_price' => $origin_price, 'price' => $new_price, 'preferential' => $youhui], $order->id);
            }
        }
    }
    */
}
