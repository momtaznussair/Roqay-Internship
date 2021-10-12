@extends('layouts.master')
@section('css')
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal  treeview -->
@if (App::isLocale('ar'))
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@else
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@endif

{{-- mass selection styles --}}
<style>
    #dAll{
        display: none;
    }
    #sAll, #dAll{
        font-weight: bold;
        margin-right: .5rem;
    }
    #sAll:hover, #dAll:hover{
        cursor: pointer;
    }
</style>
@section('title')
{{__('roles.Edit Role')}}
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('roles.Roles')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('roles.Edit Role')}}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

{{-- error messages --}}
@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{!! Form::model($role, ['method' => 'PUT','route' => ['roles.update', $role->id]]) !!}
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-header">
                <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}">{{__('main-sidebar.Back')}}</a>
            </div>
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="col-xs-7 col-sm-7 col-md-7">
                        <div class="form-group">
                            <p>
                                {{__('roles.Name') . ' : '}}
                                <span class="text-danger"> *</span>
                            </p>
                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'true')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-4 mb-5">

                        {{-- mass selection --}}
                       <div class='ht-15 mb-2'>
                        <a class="fas fa-check-circle text-success" id="sAll" onclick="selectAll();"><span class="mx-1">{{__('roles.Select All')}}</span></a>
                        <a class="far fa-check-circle text-secondary" id="dAll" onclick="deSelectAll();"><span class="mx-1">{{__('roles.Deselect All')}}</span></a>
                       </div>

                        <ul id="treeview1">
                            <li>
                                <a href="#">{{__('roles.Permissions')}}</a>
                                <span class="text-danger"> *</span>
                            <ul>
                            </li>
                            @foreach($permissions as $permission)
                            <label style="font-size: 16px; display:block; margin-right:.4rem; margin-left:.4rem;">
                                {{ Form::checkbox('permissions[]', $permission->id, $role->hasPermissionTo($permission->name) ? true : false, ['class' => 'name']) }}
                                {{ $permission->name }}</label>
                            @endforeach
                            </li>

                        </ul>
                        </li>
                        </ul>
                    </div>
                    <!-- /col -->
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-5 fixed-bottom">
                        {!! Form::submit(__('modal.Confirm'), ['class' => 'btn btn-main-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->

{!! Form::close() !!}
@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
{{-- select all and deselect all --}}
<script>
        function selectAll()    
        {
            options = $('input[type="checkbox"]').prop('checked', true);
            $('#sAll').hide();
            $('#dAll').show();
        }
        function deSelectAll()    
        {
            options = $('input[type="checkbox"]').prop('checked', false);
            $('#dAll').hide();
            $('#sAll').show();
        }

</script>
@endsection