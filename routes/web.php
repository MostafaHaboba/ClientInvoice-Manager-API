<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/setup',function(){
//     $credentials = [
//         'email'=>'admin@admin.com',
//         'password'=>'password'
//     ];

//     if (!Auth::attempt($credentials)){
//         $user=new User();

//         $user->name= 'Admin';
//         $user->email=$credentials['email'];
//         $user->password=Hash::make($credentials['password']);

//         $user->save();

//         if(Auth::attempt($credentials)){
//             $user=Auth::user();

//             $adminToken=$user->createToken('admin-token',['create','update','delete']);
//             $updateToken=$user->createToken('update-token',['create','update']);
//             $basicToken=$user->createToken('basic-token');
            
//             return[
//                 'admin'=>$adminToken->plainTextToken,
//                 'update'=>$updateToken->plainTextToken,
//                 'basic'=>$basicToken->plainTextToken,

//             ];
//         }
//     }
// }

// );

Route::get('/setup', function() {
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'password'
    ];

    // Attempt to authenticate
    if (!Auth::attempt($credentials)) {
        // Create a new user if the credentials don't exist
        $user = new User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();
    }

    // Authenticate the user
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Generate the tokens
        $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete', 'view']);
        $updateToken = $user->createToken('update-token', ['update', 'view']);
        $basicToken = $user->createToken('basic-token', ['view']);

        // Return the tokens
        return [
            'admin' => $adminToken->plainTextToken,
            'update' => $updateToken->plainTextToken,
            'basic' => $basicToken->plainTextToken,
        ];
    }

    return response()->json(['message' => 'User setup failed or credentials invalid'], 500);
});

