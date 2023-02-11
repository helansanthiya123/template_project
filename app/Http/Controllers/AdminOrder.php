<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdminOrder extends Controller
{
    public function order()
    {
        $orders=Order::where('status','0')->get();
        return view('admin.order',compact('orders'));
    }
    public function viewOrder($id)
    {
        $orders=Order::where('id',$id)->get();
        $orderitems=DB::table('order_items')
                        ->join('add_fruits','add_fruits.id','=','order_items.product_id')
                        ->where('order_items.order_id','=',$id)
                        ->select('order_items.*','add_fruits.fruit_name','add_fruits.image_name')
                        ->get();
        return view('admin.view_order',compact('orders','orderitems'));
    }
    public function update(Request $request,$id)
    {
        $orders=Order::find($id);
        $orders->status=$request->order_status;
        $orders->update();
        return redirect('admin_order');
    }
    public function order_history()
    {
        return view('admin.order_history');
    }
}
