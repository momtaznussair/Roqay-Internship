<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
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
        $this->authorize('admin_access');
        $admins = Admin::paginate();
        return view('admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('admin_create');

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
        $this->authorize('admin_create');

        // hashing pasword
        $password = $request->password;
        $request->password = Hash::make($password);

        //storing avatar image
        $image = null;
        if($request->hasFile('avatar'))
        {
            $image = Storage::putFile('admins', $request->file('avatar'));
            $request->avatar = $image;
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'avatar' => $image,
        ]);

        // assigning roles
        $admin->assignRole($request->roles);

        return redirect()->route('admins.index')
        ->withSuccess(__('admins.Add success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $this->authorize('admin_edit');

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
        $this->authorize('admin_edit');

        // hashing pasword if exists
        $password = $admin->password;
        if ($request->password){
            $password = Hash::make($request->password);
        }

        //storing avatar image
        $avatar = $admin->avatar;
        if($request->hasFile('avatar'))
        {
            Storage::delete($admin->avatar);
            $avatar = Storage::putFile('admins', $request->file('avatar'));

        }
      
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'avatar' => $avatar,
            
        ]);
        // assigning roles
        $admin->assignRole($request->roles);

        return redirect()->route('admins.index')
        ->withSuccess(__('admins.Edit Success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $this->authorize('admin_delete');

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
