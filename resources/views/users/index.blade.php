@extends('layouts.master')
@section('title')
    {{__('Users')}}
@stop
@section('css')
<style>
    td{
        vertical-align: middle !important;
    }
</style>
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('Users')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Users List')}}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- success message --}}
@if (session()->has('success'))
<script>
    window.onload = function() {
        notif({
            msg: "{{ session()->get('success') }}",
            type: "success"
        })
    }
</script>
@php
    Session::forget('success')
@endphp
@endif
<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                @can('User_create')
                    <div class="col-sm-1 col-md-2">
                        <a class="btn btn-primary btn-sm" data-toggle="modal" href="#addModal">{{__('Add New User')}}</a>
                    </div>
                @endcan              
            </div>
            <div class="card-body">
                <div class="table-responsive hoverable-table">
                    <table id="users" class="table table-hover" data-page-length='50' style=" text-align: center;">
                        <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">{{__('Name')}}</th>
                                <th class="wd-20p border-bottom-0">{{__('Image')}}</th>
                                <th class="wd-15p border-bottom-0">{{__('E-mail')}}</th>
                                <th class="wd-15p border-bottom-0">{{__('Phone Numbers')}}</th>
                                <th class="wd-15p border-bottom-0">{{__('Operations')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img alt="" src="{{asset('storage/'.$user->avatar)}}" style="width: 70px; height: 70px; border-radius:50%">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <ul>
                                        @foreach ($user->phones as $phone)
                                            <li>{{$phone->number}}</li>
                                        @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        @can('User_edit')
                                            <a  class="modal-effect btn btn-sm btn-info"
                                                data-effect="effect-scale" data-toggle="modal" href="#editModal"
                                                data-user = "{{$user}}" data-img = "{{asset('storage/'.$user->avatar)}}"
                                                title="{{__('modal.Edit')}}"><i class="las la-pen"></i></a> 
                                        @endcan
                                        
                                        @can('User_delete')
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                            data-toggle="modal" href="#deleteModal" title="{{__('modal.Delete')}}"><i
                                                class="las la-trash"></i></a>
                                        @endcan                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->

    <!-- delete modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{__('Delete User')}}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="" method="post" id="deleteForm">
                    <div class="modal-body">
                        <p>{{__('modal.Delete Form')}}</p><br>
                        <input class="form-control" name="name" id="name" type="text" readonly>
                        <input type="hidden" name='id' id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">{{__('modal.Confirm')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('modal.Cancel')}}</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <!-- delete modal -->

    {{-- add modal --}}
    <div class="modal" id="addModal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{__('Add New User')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">
                        <form id="addForm" method="POST" autocomplete="off" enctype="multipart/form-data">
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label>
                                    {{__('admins.Name')}} <span class="tx-danger">*</span>
                                </label>
                                <input class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handler="#lnWrapper" name="name" value="{{old('name')}}" required type="text">
                            </div>
                            <div class="col">
                                <label>
                                    {{__('admins.E-mail')}}: <span class="tx-danger">*</span>
                                </label>
                                <input class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handler="#lnWrapper" name="email" value="{{old('email')}}" required type="email">
                            </div>
                        </div>
                        {{-- 2 --}}
                        <div class="row form-group">
                            <div class="col form-group">
                                <label>{{__('admins.Password')}} <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                    name="password" type="password" value="{{old('password')}}" required>
                            </div>
                            <div class="col">
                                <label>{{__('admins.Confirm Password')}} <span class="tx-danger">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                name="password_confirmation" type="password" value="{{old('password_confirmation')}}" required>
                            </div>
                        </div>
                        {{-- 3 --}}
                        <div class="row form-group">
                            <div class="col">
                                <label>{{__('admins.Account Image')}} <span class="tx-danger">*</span></label>
                                <input class="form-control  mg-b-20" name="avatar" value="{{old('avatar')}}" type="file" required>
                            </div>
                            <div class="col phones" style="overflow: scroll; max-height:10rem;">
                                <label>
                                    <button class=" border-0 bg-white addPhoneField"><i class="fas fa-plus-circle tx-success mx-1"></i></button>
                                    {{__('Phone Numbers')}} <span class="tx-danger">*</span>
                                </label>
                                <input class="form-control  mg-b-20" name="phones[]"  type="phone" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('cancel')}}</button>
                        <button class="btn ripple btn-primary" type="submit">{{__('confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of add modal --}}

    <div class="modal" id="editModal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{__('Edit User Account')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @method('PUT')
                            <input type="hidden" name="id">
                        {{-- image --}}
                        <div class="row d-flex justify-content-md-center mb-2">
                            <img alt="" style="width: 100px; height: 100px; border-radius:50%">
                        </div>
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label>
                                    {{__('admins.Name')}} <span class="tx-danger">*</span>
                                </label>
                                <input class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handler="#lnWrapper" name="name" value="{{old('name')}}" required type="text">
                            </div>
                            <div class="col">
                                <label>
                                    {{__('admins.E-mail')}}: <span class="tx-danger">*</span>
                                </label>
                                <input class="form-control form-control-sm mg-b-20"
                                data-parsley-class-handler="#lnWrapper" name="email" value="{{old('email')}}" required type="email">
                            </div>
                        </div>
                        {{-- 2 --}}
                        <div class="row form-group">
                            <div class="col form-group">
                                <label>{{__('admins.Password')}} <span class="tx-warning">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                    name="password" type="password" value="{{old('password')}}">
                            </div>
                            <div class="col">
                                <label>{{__('admins.Confirm Password')}} <span class="tx-warning">*</span></label>
                                <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper"
                                name="password_confirmation" type="password" value="{{old('password_confirmation')}}">
                            </div>
                        </div>
                        {{-- 3 --}}
                        <div class="row form-group">
                            <div class="col">
                                <label>{{__('admins.Account Image')}} <span class="tx-warning">*</span></label>
                                <input class="form-control  mg-b-20" name="avatar" value="{{old('avatar')}}" type="file">
                            </div>
                            <div class="col" style="overflow: scroll; max-height:10rem;">
                                <label>
                                    <button class=" border-0 bg-white addPhoneField"><i class="fas fa-plus-circle tx-success mx-1"></i></button>
                                    {{__('Phone Numbers')}} <span class="tx-danger">*</span>
                                </label>
                                <div class="phones">
                                    {{-- phone numbers --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('cancel')}}</button>
                        <button class="btn ripple btn-primary" type="submit">{{__('confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

</div>
<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')

<script>
    
//validating form
$('#addForm, #editForm').on('submit', function () {
    if($(this).find('input[name="password"]').val() !== $(this).find('input[name="password_confirmation"]').val())
    {
        notif({
                msg: `{{__("admins.Passwords Don't Match")}}`,
                type: "error"
            });
        return false;
    }
});
// delete modal
$('#deleteModal').on('show.bs.modal', function(event) {
    let button = $(event.relatedTarget)
    let id = button.data('id')
    let name = button.data('name')
    let modal = $(this)
    modal.find('.modal-body #name').val(name);
    modal.find('.modal-body #id').val(id);
})

// I've declared it globally to use it in edit form and in addPhoneField
let newPhoneField = `
    <button class=" border-0 bg-white removePhone"><i class="fas fa-minus-circle tx-danger removePhone"></i></button>
    <input class="form-control  mg-b-20" name="phones[]" type="phone"
`;
// edit modal
$('#editModal').on('show.bs.modal', function(event) {
    let button = $(event.relatedTarget)
    let user = button.data('user')
    let img = button.data('img');
    let modal = $(this)
    // console.log(user.name)
    modal.find('.modal-body input[name="name"]').val(user.name);
    modal.find('.modal-body input[name="id"]').val(user.id);
    modal.find('.modal-body input[name="email"]').val(user.email);
    modal.find('.modal-body img').prop('src', img);
    let phones = modal.find('.modal-body .phones');
    phones.empty();
    user.phones.forEach((phone, index) => {
        if(index == 0)
        phones.append(`<input class="form-control  mg-b-20" name="phones[]" value="${phone.number}" type="phone" required>`);
        else
        phones.append(`<div class="extraPhone">${newPhoneField} value="${phone.number}" /> </div>`)
    });

})

// {{-- add phone field --}}
$('.addPhoneField').click(function (e) { 
    e.preventDefault();
    $('.phones').append(`<div class="extraPhone">${newPhoneField} /> </div>`);
});

// remove phone on click
$('.phones').click(function (e) { 
    if($(e.target).hasClass('removePhone'))
    {
        e.preventDefault();
        e.target.closest('div').remove();
    }
});

// ajax requests 

// set csrf token
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

// add request

$('#addForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    userRequest("POST", "{{route('users.store')}}", formData, '#addForm', '#addModal');
});

//edit request
$('#editForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    userRequest("POST", `users/${formData.get('id')}`, formData, '#editForm', '#editModal');
});


//delete request
$('#deleteForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    userRequest("DELETE", `users/${formData.get('id')}`, formData, '#deleteForm', '#deleteModal');
});

function userRequest(method, url, formData, formId, modalId) {
    $.ajax({
        type: method,
        url: url,
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            // hide modal and reset add form
            $(formId).trigger("reset")
            $(modalId).modal('hide')
            $('#users').load(window.location.href + " #users" );
            // notify user
            notif({
                msg: response.msg,
                type: "success"
            })

        },
        error: function(xhr, status, error) {
            let result = ''
            let errors = xhr.responseJSON.errors
            $.each(errors, function (index, error) {
                    result += `<p>${error}</p>`
            });

            notif({
                    type: "error",
                    msg: result == '' ? "{{__('Unknown Error')}}" : result,
                    position: "right",
                    width: 300,
                    autohide: false,
                    multiline: true
            });
        }
    })
}
//end of userRequest function

</script>

@endsection