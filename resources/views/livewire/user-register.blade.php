<div class="container-fluid px-0">
   <div class="row">
       <div class="col-lg-12 col-md-12">
           {{-- <div class="card"> --}}
               <div class="card-body">
                   {{-- change language --}}
                   <div class="lang d-flex justify-content-end">
                       @if (App::isLocale('en'))
                           <a  rel="alternate" hreflang="ar" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                               <img src="{{ URL::asset('assets/img/flags/egypt-flag.png') }}" style="padding-top:1rem" alt="العربية" title="العربية">
                           </a>
                       @else
                           <a  rel="alternate" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                               <img  src="{{ URL::asset('assets/img/flags/us_flag.jpg') }}" style="width: 32px; padding-top:1rem" alt="English" title="English">
                           </a>
                       @endif
                   </div>
                   <div class="row">
                       <div class="col-md-10 col-lg-8 col-xl-6 mx-auto d-block">
                           <div class="card card-body pd-20 pd-md-40 border shadow-none">
                               <h5 class="card-title mg-b-20 mx-auto">{{__('Registration')}}</h5>
                               {{-- registration form --}}
                                   <form wire:submit.prevent='register'  method="POST" autocomplete="off" enctype="multipart/form-data">
                                   {{-- 1 --}}
                                   <div class="row">
                                       <div class="col">
                                           <label>
                                               {{__('admins.Name')}} <span class="tx-danger">*</span>
                                           </label>
                                           <input wire:model="name" class="form-control form-control mg-b-20" type="text">
                                           @error('name') <span class="tx-danger">{{$message}}</span> @enderror
                                       </div>
                                       <div class="col">
                                           <label>
                                               {{__('admins.E-mail')}}: <span class="tx-danger">*</span>
                                           </label>
                                           <input wire:model="email" class="form-control form-control mg-b-20"
                                            name="email" required type="email">
                                           @error('email') <span class="tx-danger">{{$message}}</span> @enderror     
                                       </div>
                                   </div>
                                   {{-- 2 --}}
                                   <div class="row form-group">
                                       <div class="col form-group">
                                           <label>{{__('admins.Password')}} <span class="tx-danger">*</span></label>
                                           <input wire:model="password" class="form-control form-control mg-b-20" 
                                               name="password" type="password" required>
                                           @error('password') <span class="tx-danger">{{$message}}</span> @enderror                                   
                                       </div>
                                       <div class="col">
                                           <label>{{__('admins.Confirm Password')}} <span class="tx-danger">*</span></label>
                                           <input wire:model="password_confirmation" class="form-control form-control mg-b-20" 
                                           name="password_confirmation" type="password"  required>
                                           @error('password_confirmation') <span class="tx-danger">{{$message}}</span> @enderror                                   
                                       </div>
                                   </div>
                                   {{-- 3 --}}
                                   <div class="row form-group">
                                       <div class="col">
                                           <label>{{__('admins.Account Image')}} <span class="tx-danger">*</span></label>
                                           <input wire:model="avatar" class="form-control  mg-b-20" type="file" required>
                                           @error('image') <span class="tx-danger">{{$message}}</span> @enderror                                   
                                       </div>
                                       <div class="col phones" style="overflow: scroll; max-height:10rem;">
                                           <label>
                                               {{__('Phone Numbers')}} <span class="tx-danger">*</span>
                                           </label>
                                           <input wire:model="phone" class="form-control  mg-b-20" type="phone" required>
                                          @error('phone') <span class="tx-danger">{{$message}}</span> @enderror                                   
                                       </div>

                                   </div>
                               {{-- end of  registration form --}}
                               <p class=" text-center"><a href="{{route('login')}}">{{__('Already have an account ?')}}</a></p>
                               <button class="btn btn-main-primary btn-block">{{__('Register')}}</button>
                           </div>
                       </div>
                   </div>
               </div>
           {{-- </div> --}}
       </div>
   </div>
</div>