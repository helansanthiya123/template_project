<?php

namespace App\Http\Controllers;

use App\Models\AddFruit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MyProduct extends Controller
{
    public function showIndex()
    {
        $fruits=AddFruit::get();
        return view('template_folder.index',compact('fruits'));
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $credential=$request->only('email','password');
        
        if(Auth::attempt($credential))
        {
            return redirect()->intended('index')->with('message','Signed In');
            
        }
        else{
            return redirect('sign-in')->with('message','Login details are invalid');
           
        }

    }

    public function register(Request $request)
    {

       
            $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:6'
            ]);

            $data=$request->all();
            User::create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>Hash::make($data['password'])
            ]);
           
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->intended('index')
                            ->withSuccess('Signed in');
            }
    }
    public function dashboard()
    {
        
        if(Auth::check())
        {
            return view('admin.index');
            // return  view('dashboard');
            
        }
        else
        {
            return redirect('sign-in'); 
           
        }
       
    }

    public function signout()
    {
        Session::flush();
        Auth::logout();

        return redirect('sign-in');
    }
    public function adminprofile()
    {
        if(Auth::check())
        {
            return view('admin.profile');
            // return  view('dashboard');
            
        }
        else
        {
            return redirect('sign-in'); 
           
        }
       
    }
    public function showfruit()
    {
        if(Auth::check())
        {
            return view('admin.addfruit');
        }
        else
        {
            return redirect('sign-in'); 
        }
       
    }
    public function addfruit(Request $request)
    {
            $request->validate([
                'image'=>'mimes:png,jpg,jpeg'
            ]);

        $addfruit = new AddFruit;

        $addfruit->image_name=$request->image->getClientOriginalName();
        $image_name=$request->image->getClientOriginalName();
        $request->file('image')->move(public_path('/images'),$image_name);
        $addfruit->rate=$request->rate;
        $addfruit->fruit_name=$request->fruit_name;
        
        $addfruit->save();
        Session::flash('add_fruit_success','New Fruits Added');
        return back();
    }
}
