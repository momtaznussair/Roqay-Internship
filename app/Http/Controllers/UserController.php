<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Phone;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'avatar')->with('phones')->paginate();
        return view('users.index', compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //1 hashing pasword[bdnbnb]
        $password = $request->password;
        $request->password = Hash::make($password);
        //2 store image
        $image = Storage::putFile('users', $request->file('avatar'));
        $request->avatar = $image;
        //3 create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'avatar' => $image,
        ]);
        //4 store phone numbers
        foreach ($request->phones as  $number) {
            $phone = new Phone();
            $phone->number = $number;
            $user->phones()->save($phone);
        }
        //5 retun success message
        $data = ['msg' => __('User Added Successfully')];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
         //1 hashing pasword
        $password = $user->password;
        if($request->password){
            $password = $request->password;
            $request->password = Hash::make($password);
        }

        //2 store image
        $avatar =  $user->avatar;
        if($request->hasFile('avatar'))
        {
            Storage::delete( $avatar);
            $image = Storage::putFile('users', $request->file('avatar'));
            $avatar = $image;
        }

         //3 update user
         $user->update([
             'name' => $request->name,
             'email' => $request->email,
             'password' => $password,
             'avatar' => $avatar,
         ]);
        //4 store phone numbers
        $user->phones()->delete();
        foreach ($request->phones as  $number) {
             $phone = new Phone();
             $phone->number = $number;
             $user->phones()->save($phone);
         }

         //5 retun success message
         $data = ['msg' => __('User Edited Successfully')];
         return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Storage::delete($user->avatar);
        $user->delete();
        
        $data = [
            'msg' => __('User Deleted Successfully'),
        ];

        return response()->json($data);
    }
}
