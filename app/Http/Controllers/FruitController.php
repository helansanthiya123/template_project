<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddFruit;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use DataTables;
use PHPUnit\Framework\Constraint\Count;

class FruitController extends Controller
{
    // public function managefruit()
    // {
    //     return view('admin.manage_fruits');
    // }
    public function managefruit(Request $request)
    {
        if ($request->ajax()) {
            $data =AddFruit::select('*');
            return Datatables::of($data)
                    // ->setRowId('test')
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit"  id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                        $button .= '   <button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                        return $button;
                    })
                    // ->rawColumns(['action'])
                    ->make(true)
                    ;
        }
          
        return view('admin.manage_fruits');
    }

    public function editfruit($id)
    {
            if(request()->ajax())
            {
                $data=AddFruit::findOrFail($id);
                return response()->json(['result'=>$data]);
            }
    }

    public function updatefruit(Request $request)
    {
        $form_data = array(
            'image_name'    =>  $request->file('image')->getClientOriginalName(),
            'rate'          =>  $request->rate,
            'fruit_name'    =>  $request->fruit_name
        );
 
        AddFruit::whereId($request->edit_id)->update($form_data);
        Session::flash('success','Data is successfully updated');
        return back();
        // return response()->json(['success' => 'Data is successfully updated']); 

    }
    public function deletefruit($id)
    {
            $data=AddFruit::findOrFail($id);
            $data->delete();
            return response()->json(['success' => 'Data is successfully deleted']);
    }

    public function add_to_cart($id)
    {
        $user_id = Auth::id();
        
        if($user_id)
        {
            // return response()->json(['data'=>'success' ,'user_id'=>$user_id]);

            $cart= new Cart;
            $cart->product_id=$id;
            $cart->user_id=$user_id;
            $cart->save();
            return response()->json(['data'=>'success']);
        }
        else{
           
            return response()->json(['data'=>'fail']);
        }
        
    }
    static public function cartItem()
    {
        $userId=Auth::id();
        return Cart::where('user_id',$userId)->count();
    }
    public function cartListing()
    {
        $userId=Auth::id();
        $products=DB::table('carts')
        ->join('add_fruits','carts.product_id','=','add_fruits.id')
        ->where('carts.user_id',$userId)
        ->select('add_fruits.*','carts.id as cart_id',DB::raw("count(carts.product_id) as count"))
        // ->select('add_fruits.*','carts.id as cart_id')
        ->groupBy('carts.product_id')
        ->get();
        
        return view('template_folder.cartlisting',['products'=>$products]);
    }
    public function removeCart($product_id)
    {
        Cart::where('product_id', $product_id)->delete();
        // Cart::destroy($cart_id);
        return redirect('cartlisting');
    }

    public function increaseQuantity($product_id)
    {
        $user_id = Auth::id();
        $cart= new Cart;
        $cart->product_id=$product_id;
        $cart->user_id=$user_id;
        if($cart->save())
        {
            return response()->json(['data'=>'success']);
        }

    }
    public function decreaseQuantity($cart_id)
    {
        // $user_id = Auth::id(); 
        if(Cart::destroy($cart_id))
        {
            return response()->json(['data'=>'success']);
        }
        // return redirect('cartlisting');
    }
    public function checkout()
    {
        $userId=Auth::id();
        $products=DB::table('carts')
        ->join('add_fruits','carts.product_id','=','add_fruits.id')
        ->where('carts.user_id',$userId)
        ->select('add_fruits.*','carts.id as cart_id',DB::raw("count(carts.product_id) as count"))
        // ->select('add_fruits.*','carts.id as cart_id')
        ->groupBy('carts.product_id')
        ->get();
        
        // return view('template_folder.cartlisting',['products'=>$products]);
        return view('template_folder.checkout',['products'=>$products]);
    }
    public function placeOrder(Request $request)
    {
        $order = new Order;
        $order->userId=Auth::id();
        $order->name=$request->name;
        $order->email=$request->email;
        $order->phone=$request->phone;
        $order->address=$request->address;
        $order->message=$request->message;
        $order->subtotal=$request->subtotal;
        $order->total=$request->subtotal;
        $order->tracking_no='fruit'.rand(1111,9999);
        $order->save();

        $userId=Auth::id();
        $cart=DB::table('carts')
        ->join('add_fruits','add_fruits.id','=','carts.product_id')
        ->where('carts.user_id',$userId)
        ->select('add_fruits.fruit_name','add_fruits.id','add_fruits.rate',DB::raw("count(carts.product_id) as quantity"))
        ->groupBy('carts.product_id')
        ->get();
        
        foreach($cart as $item)
        {
                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_id'=>$item->id,
                    'quantity'=>$item->quantity,
                    'price'=>$item->rate,
                ]);
        }
        
        $cartitems=Cart::where('user_id',$userId)->get();
        Cart::destroy($cartitems);
        return redirect('front_signout');
    }
    public function order()
    {
        $userId=Auth::id();
        if($userId)
        {
            $orders=Order::where('userId',$userId)->get();
            return view('template_folder.order',compact('orders'));
        }
        else
        {
            return view('template_folder.frontlogin');
        }
    }
    public function orderLogin(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $credential=$request->only('email','password');
        
        if(Auth::attempt($credential))
        {
           
            $userId=Auth::id();
            $orders=Order::where('userId',$userId)->get();

            return  view('template_folder.order',compact('orders'));
            
        }
        else{
            return redirect('sign-in')->with('login_fail','Create account');
           
        }
    }
    public function view_order($order_id)
    {
        $orders=Order::where('id',$order_id)->where('userId',Auth::id())->get();
        // $orderitems=OrderItem::where('order_id',$order_id)->get();
        $orderitems=DB::table('order_items')
                        ->join('add_fruits','add_fruits.id','=','order_items.product_id')
                        ->where('order_items.order_id','=',$order_id)
                        ->select('order_items.*','add_fruits.fruit_name','add_fruits.image_name')
                        ->get();
        
        return view('template_folder.view_order',compact('orders','orderitems'));
    }
}
