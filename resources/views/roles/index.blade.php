@extends('layouts.master')

@section('title')
	{{__('roles.Roles')}}
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{__('roles.Roles')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('roles.Roles List')}}</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">

					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				{{--  errors --}}
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
                            msg: "{{session()->get('success')}}",
                            type: "success"
                        });
                    }
                </script>
                @endif
                <!-- row -->
				<div class="row">
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0 mb-3">
								<div class="d-flex justify-content-between">
									@can('role_create')
										<div class="col-sm-6 col-md-4 col-xl-3">
											<a class="modal-effect btn btn-outline-primary btn-block"  href="{{route('roles.create')}}">{{__('roles.Add New Role')}}</a>
										</div>
									@endcan									
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="rolesTable" class="table text-md-nowrap">
										<thead>
											<tr class="text-center">
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">{{__('roles.Name')}}</th>
												<th class="border-bottom-0">{{__('roles.Operations')}}</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($roles as $role)
											<tr class="text-center">
												<td class="align-middle">{{$loop->iteration}}</td>
												<td class="align-middle">{{$role->name}}</td>
                                                <td>
                                                    @if ($role->name == 'Super Admin')
                                                    <i class="fas fa-crown tx-warning"></i>
                                                    @else
                                                    <a class="btn btn-success btn-sm"
                                                        href="{{ route('roles.show', $role->id) }}">{{__('roles.View')}}</a>
													@can('role_edit')
														<a class="btn btn-primary btn-sm"
														href="{{ route('roles.edit', $role->id) }}">{{__('roles.Edit')}}</a> 
													@endcan

													@can('role_delete')
														<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
														data-id="{{ $role->id }}"
														data-name="{{ $role->name }}" data-toggle="modal"
														href="#deleteModal" title="{{__('roles.Delete')}}"><i class="las la-trash"></i></a>	
													@endcan
                                                    @endif 
                                                </td>
											</tr>
											@endforeach
                                        </tbody>
									</table>
								</div>
                                <div class="row mx-3">{{$roles->links()}} </div>
							</div>
						</div>
					</div>

				</div>
				{{-- row closed  --}}
                {{-- delete modal --}}
				 <div class="modal" id="deleteModal">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content modal-content-demo">
							<div class="modal-header">
								<h6 class="modal-title">{{__('category.Delete Category')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
									type="button"><span aria-hidden="true">&times;</span></button>
							</div>
                            {!! Form::open(['id' => 'deleteForm']) !!}

                            <div class="modal-body">
                                <p>{{__('modal.Delete Form')}}</p><br>
                                {{ Form::text('name', '',['class' => 'form-control', 'id' => 'name', 'readonly' => 'on']) }}
                                {!! Form::hidden('id', '', ['id' => 'id']) !!}
                            </div>
                            <div class="modal-footer">
                                {!! Form::submit(__('modal.Confirm'), ['class' => 'btn btn-danger']) !!}
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('modal.Cancel')}}</button>
                            </div>

                            {!! Form::close() !!}
						</div>
					</div>
				</div>
				{{--end of delete modal --}}
			</div>
			{{-- Container closed  --}}
		</div>
		 {{-- main-content closed --}}
@endsection

@section('js')
// delete
<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let id = button.data('id')
        let name = button.data('name')
        let modal = $(this)
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #id').val(id);
    })


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#deleteForm').submit(function (e) {
e.preventDefault();
let formData = new FormData(this);
$.ajax({
    type: "DELETE",
    url: `roles/${formData.get('id')}`,
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
        //refresh table
        $('#rolesTable').load(window.location.href + " #rolesTable" );
        // hide modal
        $('#deleteModal').modal('hide')
        // notify user
        notif({
            msg: response.msg,
            type: "success"
        })

    },
});
});
</script>
@endsection
