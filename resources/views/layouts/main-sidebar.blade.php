<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				{{-- //logo --}}
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							@if (Auth('admin')->user()->avatar)
								<img alt="user-img" class="avatar avatar-xl brround" src="{{asset('uploads/'.Auth('admin')->user()->avatar)}}"><span class="avatar-status profile-status bg-green"></span>
							@else
								<img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/faces/6.jpg')}}"><span class="avatar-status profile-status bg-green"></span>
							@endif
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{Auth('admin')->user()->name}}</h4>
						</div>
					</div>
				</div>
				<ul class="side-menu">
					<li class="side-item side-item-category">{{__('main-sidebar.Main')}}</li>
					<li class="slide">
						<a class="side-menu__item" href="/"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">{{__('main-sidebar.Dashboard')}}</span></a>
					</li>
					@can('Category_access')
					<li class="side-item side-item-category">{{__('admins.Admins')}}</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('categories.index') }}">
							<i class="fas fa-layer-group mx-1" style="color: gray; font-size:1.3rem;"></i>
							<span class="side-menu__label" style="color: gray;">{{__('main-sidebar.Categories')}}</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
					</li>
					@endcan

					@can('User_access')
					<li class="side-item side-item-category">{{__('Users')}}</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('users.index') }}">
							<i class="fas fa-user mx-1" style="color: gray; font-size:1.3rem;"></i>
							<span class="side-menu__label" style="color: gray;">{{__('Users')}}</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
					</li>
					@endcan

					@can('Admin_access')
					<li class="side-item side-item-category">{{__('admins.Admins')}}</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('admins.index') }}">
							<i class="fas fa-user-shield mx-1" style="color: gray; font-size:1.3rem;"></i>
							<span class="side-menu__label" style="color: gray;">{{__('admins.Admins')}}</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
					</li>
					@endcan

					@can('Role_access')
						<li class="side-item side-item-category">{{__('roles.Roles')}}</li>
						<li class="slide">
							<a class="side-menu__item" href="{{ route('roles.index') }}">
								<i class="fas fa-key mx-1" style="color: gray; font-size:1.3rem;"></i>
								<span class="side-menu__label" style="color: gray;">{{__('roles.Roles')}}</span>
								<i class="angle fe fe-chevron-down"></i>
							</a>
						</li>
					@endcan
				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
