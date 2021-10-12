<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::all();
        return view('admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        return view('admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        // hashing pasword
        $password = $request->password;
        $request->password = Hash::make($password);

        //storing avatar image
        if($request->hasFile('avatar'))
        {
            $path = $request->file('avatar')->store('admins');
            $request->avatar = $path;
        }

        $admin = Admin::create($request->all());
        // assigning roles
        $admin->assignRole($request->roles);

        return redirect()->route('admins')->withSuccess(__('admins.Add success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view('admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $roles = Role::select('id', 'name')->get();
        return view('admin.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        // hashing pasword if exists
        if ($request->password){

            $password = $request->password;
            $request->password = Hash::make($password);
        }
        else
        {
            $request = Arr::except($request, ['password']);
        }

        //storing avatar image
        $avatar = $admin->avatar;
        if($request->hasFile('avatar'))
        {
            Storage::delete($avatar);
            $avatar = $request->file('avatar')->store('admins');
        }
        $request->avatar = $avatar;

        $admin->update($request->all());
        // assigning roles
        $admin->assignRole($request->roles);

        return redirect()->route('admins')->withSuccess(__('admins.Edit success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        Storage::delete($admin->avatar);
        $admin->delete();
        return back()->withSuccess(__('admins.Delete Success'));
    }

    public function page($id)
    {
        if(view()->exists($id)){
            return view($id);
        }
        return view('404');

    }
}
