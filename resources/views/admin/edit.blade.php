@extends('layouts.master')
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@section('title')
{{__('admins.Edit Admin Data')}}
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('admins.Admins')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                / {{ __('admins.Edit Admin Data') }}
                </span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">


    <div class="col-lg-12 col-md-12">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('admins.index') }}">{{__('main-sidebar.Back')}}</a>
                    </div>
                </div>
                <br>
                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                action="{{route('admins.update', $admin->id)}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div>
                    {{-- 1 --}}
                    <div class="row mg-b-20">
                        <div class="col-md-2 d-flex justify-content-center">
                           <img alt="" src="{{asset('uploads/'.$admin->avatar)}}" style="width: 70px; height: 70px; border-radius:50%">
                        </div>
                        <div class="parsley-input col-md-5" id="fnWrapper">
                            <label>{{__('admins.Name')}} <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handlr="#lnWrapper" name="name" value='{{$admin->name}}' required type="text">
                        </div>

                        <div class="parsley-input col-md-5 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>{{__('admins.E-mail')}}: <span class="tx-danger">*</span></label>
                            <input class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handler="#lnWrapper" name="email" value="{{$admin->email}}" required type="email">
                        </div>
                    </div>

                </div>

                {{-- 2 --}}
                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>{{__('admins.Password')}}</label>
                        <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                            name="password" id='password' type="password">
                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>{{__('admins.Confirm Password')}}</label>
                        <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                            name="password_confirmation" id="confirm" type="password">
                    </div>
                </div>

                {{-- 3 --}}
                <div class="row row-sm mg-b-20">
                    <div class="col">
                        <label class="form-label font-weight-bold mt-1">{{__('admins.Status')}}<span class="tx-danger mr-1">*</span></label>
                        <select class="form-control" name="status" id="select-beast" class="form-control  nice-select  custom-select" required>
                                <option class="text-success" value="active" {{$admin->status == 'active' ? 'selected' : ''}}>{{__('admins.Active')}}</option>
                                <option class="text-danger" value="suspended" {{$admin->status == 'suspended' ? 'selected' : ''}}>{{__('admins.Suspended')}}</option>
                        </select>
                    </div>

                    <div class="col">
                        <p class="mg-b-10 font-weight-bold">{{__('admins.Roles')}}<span class="tx-danger mr-1">*</span></p>
                        @if ($admin->hasRole('Super Admin'))
                        <select class="form-control" name="roles[]"  required readonly>
                            <option value="1" selected>Super Admin</option>
                        </select>
                        @else
                        <select class="form-control select2" name="roles[]" multiple="multiple" required>
                            @foreach ($roles as $role)
                                @if ($role->name != 'Super Admin')
                                    <option value="{{$role->id}}" {{$admin->hasRole($role->name) ? 'selected' : ''}}>{{$role->name}}</option>
                                @endif
                            @endforeach
                        @endif
                        </select>
                    </div>
                    <div class="col">
                        <label>{{__('admins.Account Image')}} <span class="tx-warning">*</span></label>
                        <input class="form-control  mg-b-20" name="avatar" type="file">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button class="btn btn-main-primary pd-x-20" type="submit">{{__('modal.Confirm')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<!-- Internal Form-validation js -->
<script src="{{URL::asset('assets/js/form-validation.js')}}"></script>

<script>
$('form').on('submit', function () {
    if($('#password').val() !== $('#confirm').val())
    {
        notif({
                msg: `{{__("admins.Passwords Don't Match")}}`,
                type: "error"
            });
        return false;
    }
});
</script>
@endsection