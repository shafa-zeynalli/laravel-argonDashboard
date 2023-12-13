<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

            $users = User::all(); // hamisini getirir
            $users = User::all()->toArray(); // array veziyyetine cevirir

            $coll = collect($users);

//          $collection = $coll->all();    //  hamisini getirir
//          $collection = $coll->avg('id'); // idye gore ortalayir idnin reqemini yazir ex: 4

//          $collection = $coll->contains(function ($user) {
//              return $user['id'] > 54;      //idsi 54den boyuk 1 dene bele data varsa true gonderecek , hec yoxdusa false olacaq
//          });

//            $collection=$coll->count();  //tabledeki item larin sayini gosterir

//            $collection=$coll->filter(function ($value) {
//                return $value['id'] > 98;
//            })->all();;  //tabledeki  idsi 98 den boyuk olan butun item larin gosterir

            $collection=$coll->first(function ($value) {
                return $value['id'] > 98;
            });;  //tabledeki  idsi 98 den boyuk olan ilk item i gosterir  ancaq 99 un melumatlarini getirir


//            echo $collection;
            dd($collection);




            Auth::logout();
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
//        }
//        return redirect()->route('admin.dashboard');

    }
    public function profile(){
        $user = Auth::user();
//        dd($user);
        return view('admin.users.profile', compact('user'));
    }

    public function updateProfile(ProfileUpdateRequest $request){
//        $image = $request->imageFile->move(public_path('uploads'),'xxx.jpg');

//        $file=$request->file('imageFile');
//        $file->store('uploads');  // oz adi ile getirir

        $user = User::find(auth()->user()->id);
//        dd($user);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($user->image) {
            Storage::delete($user->image);
        }

        $fileName = $request->file('imageFile')->store('uploads');
        $user->image = $fileName;
        $user->save();

//        $users = Storage::url($user->image);
//        dd($users);
        return view('admin.users.profile', compact('user'));
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

    public function users(Request $request){
//        $users = User::query()->latest()->orderBy('id','desc')->paginate(10);

        $userQuery = User::query();

        if ($request->filled('name')) {
            $userQuery->where('name', 'like', "%".$request->get('name')."%");
        }

        if ($request->filled('email')) {
            $userQuery->where('email', 'like', "%".$request->get('email')."%");
        }

        if ($request->filled('startDate')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->get('startDate'));
//            dd($startDate);
            $userQuery->where('created_at', '>=',  $startDate);
        }
        if ($request->filled('endDate')) {
//            dd($request->get('endDate'));
            $endDate = Carbon::createFromFormat('Y-m-d', $request->get('endDate'))->setTimezone('Asia/Baku');
//            $endDate->setTimezone('Asia/Baku');
//            $endDate->subDay();
//            dd($endDate);
            $userQuery->where('created_at', '<=', $endDate);
        }


        $users = $userQuery->paginate($request->get('pageSize') ?? 10);

        return view('admin.users.index', compact('users'));
    }

    public function products(Request $request){
//        $products = Product::query()->with('user')->paginate(10);
        $productQuery = Product::query()->with('user');

        if ($request->filled('product_name')) {
            $productQuery->where('name', 'like', "%".$request->get('product_name')."%");
        }
        if ($request->filled('user_name')) {
//            $productQuery->where('name', 'like', "%".$request->get('pName')."%");
            $productQuery->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', "%".$request->get('user_name')."%");
            });
//            dd($productQuery);
        }
        if ($request->filled('slug')) {
            $productQuery->where('slug', 'like', "%".$request->get('slug')."%");
        }
        if ($request->filled('price')) {
            $productQuery->where('price', $request->get('price'));
        }
        if ($request->filled('status')) {
            $productQuery->where('status', 'like', "%".$request->get('status')."%");
        }
        if ($request->filled('startDate')) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->get('startDate'));
            $productQuery->where('created_at', '>=',  $startDate->startOfDay());
        }
        if ($request->filled('endDate')) {
            $endDate = Carbon::createFromFormat('Y-m-d', $request->get('endDate'));
            $productQuery->where('created_at', '<=', $endDate->endOfDay());
//            dd($productQuery);
        }
        $products = $productQuery->paginate($request->get('pageSize') ?? 10);
        return view('admin.products.index', compact('products'));
    }


//    public function filterUsers(Request $request)
//    {
//        $name = $request->input('name');
//        $email = $request->input('email');
//
//        $userQuery = User::query();
//
//        if ($name) {
//            $userQuery->where('name', 'like', "%$name%");
//        }
//
//        if ($email) {
//            $userQuery->where('email', 'like', "%$email%");
//        }
//
//        $users = $userQuery->paginate(10);
//
//        return view('admin.users.index', compact('users'));
//    }

//    public function filterProducts(Request $request)
//    {
//        $uName = $request->input('user_name');
//        $pName = $request->input('product_name');
//        $slug = $request->input('slug');
//        $price = $request->input('price');
//        $status = $request->input('status');
//
//        $productQuery = Product::query();
//
//        if ($uName) {
//            // 'user' Relationships ile elaqe qurub filtrleme
//            $productQuery->whereHas('user', function ($query) use ($uName) {
//                $query->where('name', 'like', "%$uName%");
//            });
//        }
//
//
//        if ($pName) {
//            $productQuery->where('name', 'like', "%$pName%");
//        }
//        if ($slug) {
//            $productQuery->where('slug', 'like', "%$slug%");
//        }
//        if ($status) {
//            $productQuery->where('status', 'like', "%$status%");
//        }
//        if ($price) {
//            $productQuery->where('price',  "$price");
//        }
//
//        $products = $productQuery->paginate(10);
//
//        return view('admin.products.index', compact('products'));
//    }


    static function test(){
        Artisan::call(' send:emails userss12345');
        // terminalda php artisan tinker edib daha sonra 'App\Http\Controllers\Admin\AdminController::test()' bunu yaziriq

    }

}
