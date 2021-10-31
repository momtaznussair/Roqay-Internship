<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Phone;
use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserRegister extends Component
{
    use WithFileUploads;

    public  $email, $password, $password_confirmation, $avatar, $phone;

    public  $phones = [];

    public $name = 'momtaz';


    public function render()
    {
        return view('livewire.user-register');
    }

    protected function rules()
    {
       $rules =  Arr::except(User::rules(), ['phones', 'phones.*']);
       $rules['phone'] = 'required|digits:11|numeric|distinct|unique:phones,number';
       return $rules;
    }

    
    //realtime validation
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function addPhone()
    {
       $this->phones[] = $this->phones;
    }

    public function register()
    {
        $validData = $this->validate();

        //1 hashing pasword
        $password = $validData['password'];
        $validData['password'] = Hash::make($password);
        
        //2 store image
        $image = Storage::putFile('users', $validData['avatar']);
        $validData['avatar'] = $image;

        //3 create user
        $user = User::create($validData);

        //4 store phone number
        $phone = new Phone();
        $phone->number = $validData['phone'];
        $user->phones()->save($phone);

        //5 login and redirect to home
        Auth('web')->login($user);

        return redirect('/');

    }
}
