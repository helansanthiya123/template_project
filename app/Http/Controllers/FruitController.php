<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddFruit;
use App\Models\Cart; 
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
    public function removeCart($cart_id)
    {
        Cart::destroy($cart_id);
        return redirect('cartlisting');
    }

}
