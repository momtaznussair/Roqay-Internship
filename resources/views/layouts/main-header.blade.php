<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							{{-- logo --}}
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
					</div>
					<div class="main-header-right">
						{{-- switch language --}}
						<ul class="nav">
							@if (App::isLocale('en'))
							<a class="dropdown-item" rel="alternate" hreflang="ar" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
								<img src="{{ URL::asset('assets/img/flags/egypt-flag.png') }}" alt="العربية" title="العربية">
							</a>
							@else
							<a class="dropdown-item" rel="alternate" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
								<img  src="{{ URL::asset('assets/img/flags/us_flag.jpg') }}" style="width: 32px;" alt="English" title="English">
							</a>
							@endif
						</ul>
						<div class="nav nav-item  navbar-nav-right ml-auto">
							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
								@if (Auth('admin')->user()->avatar)
									<a class="profile-user d-flex" href=""><img alt="" src="{{asset('storage/' . Auth('admin')->user()->avatar)}}""></a>
								@else
									<a class="profile-user d-flex" href=""><img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}"></a>
								@endif
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div class="main-img-user">
											@if (Auth('admin')->user()->avatar)
												<a class="profile-user d-flex" href=""><img alt="" src="{{asset('storage/' . Auth('admin')->user()->avatar)}}""></a>
											@else
												<a class="profile-user d-flex" href=""><img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}"></a>
											@endif
											</div>
											<div class="mr-3 my-auto">
												<h6 class="ml-2">{{Auth('admin')->user()->name}}</h6>
											</div>
										</div>
									</div>
									<a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bx bx-log-out"></i>{{__('login.Sign Out')}}</a>
									<form action="{{route('admin.logout')}}" method="POST" id="logout-form">
										@csrf
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
