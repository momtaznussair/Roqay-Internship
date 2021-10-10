@extends('layouts.master2')

@section('title')
   {{__('login.Login')}}
@stop


@section('css')
@endsection
@section('content')
    <div class="container-fluid px-0">
        <div class="row no-gutter">
            <!-- The image half -->
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                 {{-- switch languages --}}
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
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                   
                                    <div class="mb-5 d-flex"> <a href="{{ url('/' . ($page = 'Home')) }}"><img
                                                src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                                                class="sign-favicon ht-40" alt="logo"></a>
                                        <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28 mr-1">{{__('login.Roqay Internship')}}</h1>
                                    </div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2>{{__('login.welcome')}}</h2>
                                            <h5 class="font-weight-semibold mb-4">{{__('login.Login')}}</h5>
                                            <form method="POST" action="{{ route('admin.authenticate') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>{{__('login.E-mail')}}</label>
                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email') }}" required
                                                        autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ __('auth.failed') }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label>{{__('login.Password')}}</label>

                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" required autocomplete="current-password">

                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="form-group row">
                                                        <div class="col-md-6 offset-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="remember" id="remember"
                                                                    {{ old('remember') ? 'checked' : '' }}>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                <label class="form-check-label" for="remember">
                                                                    {{ __('تذكرني') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-main-primary btn-block">
                                                    {{ __('login.Login') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->

            <!-- The image half -->

            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent px-0">
				{{-- <div class="position-fixed text-light" style="bottom: 1.5rem; left:1.25rem">
					<h1 class='text-left'>Invoices</h1>
                    <p class="text-muted mb-0">Copyright © 2021 Momtaz Nussair</p>
				</div> --}}
                {{-- <h2 class="position-fixed text-light" style="bottom: 1.5rem; left:1.25rem">Invoices
                    <p class="text-muted mb-0">Copyright © 2021 Momtaz Nussair</p>
                </h2> --}}
                <img src="{{ URL::asset('assets/img/media/dominik.jpg') }}" class="img-fluid" alt="logo">
            </div>


        </div>
    </div>
@endsection
@section('js')
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection