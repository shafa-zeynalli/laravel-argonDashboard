<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        if (Auth::check()){
//            dd('yes');
//        }
//        Auth::logout();

       return view('admin.dashboard');
    }

    public function tables()
    {
        $users = User::query()->get();
        $products = Product::query()->get();
//        dd($products);
       return view('admin.table.user_table', compact(['users', 'products']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(){

//        if (!Auth::check()){
            return view('admin.auth.login');
//        }else{
//            redirect();
//        }
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

//            Auth::login($credentials);
            return redirect()->intended('admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function users(){
        $users = User::query()->paginate(10);


        return view('admin.users.index', compact('users'));
    }

    public function products(){
        $products = Product::query()->with('user')->paginate(10);
//        dd($products);
        return view('admin.products.index', compact('products'));
    }


    public function filterUsers(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');

        $userQuery = User::query();

        if ($name) {
            $userQuery->where('name', 'like', "%$name%");
        }

        if ($email) {
            $userQuery->where('email', 'like', "%$email%");
        }

        $users = $userQuery->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function filterProducts(Request $request)
    {
        $uName = $request->input('user_name');
        $pName = $request->input('product_name');
        $slug = $request->input('slug');
        $price = $request->input('price');
        $status = $request->input('status');

        $productQuery = Product::query();

        if ($uName) {
            // 'user' Relationships ile elaqe qurub filtrleme
            $productQuery->whereHas('user', function ($query) use ($uName) {
                $query->where('name', 'like', "%$uName%");
            });
        }


        if ($pName) {
            $productQuery->where('name', 'like', "%$pName%");
        }
        if ($slug) {
            $productQuery->where('slug', 'like', "%$slug%");
        }
        if ($status) {
            $productQuery->where('status', 'like', "%$status%");
        }
        if ($price) {
            $productQuery->where('price',  "$price");
        }

        $products = $productQuery->paginate(10);

        return view('admin.products.index', compact('products'));
    }

}
