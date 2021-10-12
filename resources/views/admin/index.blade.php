@extends('layouts.master')
@section('title')
    {{__('admins.Admins')}}
@stop
@section('css')

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('admins.Admins')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('admins.Admins List')}}</span>
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
@endif
<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="col-sm-1 col-md-2">
                        <a class="btn btn-primary btn-sm" href="{{ route('admins.create') }}">{{__('admins.Add New Admin')}}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive hoverable-table">
                    <table class="table table-hover" id="example1" data-page-length='50' style=" text-align: center;">
                        <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">{{__('admins.Name')}}</th>
                                <th class="wd-20p border-bottom-0">{{__('admins.E-mail')}}</th>
                                <th class="wd-15p border-bottom-0">{{__('admins.Status')}}</th>
                                <th class="wd-15p border-bottom-0">{{__('admins.Roles')}}</th>
                                <th class="wd-10p border-bottom-0">{{__('admins.Operations')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td class=''>
                                        @if ($admin->status == 'active')
                                            <span class="bagde bg-success text-light">
                                                {{ __('admins.Active') }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-light">
                                                {{ __('admins.Suspended') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if (!empty($admin->getRoleNames()))
                                            @foreach ($admin->getRoleNames() as $role)
                                                <label class="badge badge-success p-1">{{ $role }}</label>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>
                                        {{-- // can delete and this is not super admin --}}
                                        <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-sm btn-info"
                                            title="{{__('modal.Edit')}}"><i class="las la-pen"></i></a> 
                                    
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-id="{{ $admin->id }}" data-name="{{ $admin->name }}"
                                        data-toggle="modal" href="#deleteModal" title="{{__('modal.Delete')}}"><i
                                            class="las la-trash"></i></a>
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

    <!-- Modal effects -->
    <div class="modal" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{__('admins.Delete Admin')}}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="" method="post">
                    @method('delete')
                    @csrf
                    <div class="modal-body">
                        <p>{{__('modal.Delete Form')}}</p><br>
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">{{__('modal.Confirm')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('modal.Cancel')}}</button>
                    </div>
            </div>
            </form>
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
<!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>

<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var modal = $(this)
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body form').attr('actions', `admins/${id}`)
    })
</script>


@endsection