@extends('layouts.master')

@section('title')
	{{__('main-sidebar.Categories')}}
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{__('main-sidebar.Setting')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('main-sidebar.Categories')}}</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">

					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				{{-- store errors --}}
				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
                <!-- row -->
				<div class="row">
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0 mb-3">
								<div class="d-flex justify-content-between">
									@can('category_create')
										<div class="col-sm-6 col-md-4 col-xl-3">
											<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#addModal">{{__('category.Add New Category')}}</a>
										</div>
									@endcan
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="categoriesTable" class="table text-md-nowrap">
										<thead>
											<tr class="text-center">
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">{{__('category.Category Name')}}</th>
												<th class="border-bottom-0">{{__('category.Image')}}</th>
												<th class="border-bottom-0">{{__('category.Operations')}}</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($categories as $category)
											<tr class="text-center">
												<td class="align-middle">{{$loop->iteration}}</td>
												<td class="align-middle">{{$category->name}}</td>
												<td class="align-middle">
													<img src="{{$category->image}}" alt="{{$category->name}}" width="40">
												</td>
												<td class="align-middle">
													@can('category_edit')
														<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
														data-id="{{ $category->id }}" data-name_ar="{{ $category->name_ar }}"
														data-name_en="{{ $category->name_en }}"	data-img="{{$category->image}}" data-toggle="modal"
														href="#editModal" title="{{__('modal.Edit')}}"><i class="las la-pen"></i></a>
													@endcan
														
													@can('category_delete')
														<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
														data-id="{{ $category->id }}" data-name="{{ $category->name }}"
														data-toggle="modal" href="#deleteModal" title="{{__('modal.Delete')}}"><i
														class="las la-trash"></i></a>
													@endcan
												</td>
											</tr>
											@endforeach
                                        </tbody>
									</table>
								</div>
                                <div class="row mx-3">{{$categories->links()}} </div>
							</div>
						</div>
					</div>
					{{-- add category modal --}}
					<div class="modal fade" id="addModal">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content modal-content-demo">
								<div class="modal-header">
									<h6 class="modal-title">{{__('category.Add New Category')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<form id="addForm" autocomplete="off" enctype="multipart/form-data">
										<div class="form-group">
											<label for="name_ar">{{__('category.Name(Arabic)')}} <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="name_ar" name="name_ar" value="{{old('name_ar')}}">
										</div>

										<div class="form-group">
											<label for="name_en">{{__('category.Name(English)')}} <span class="text-danger">*</span></label>
											<input type="text" class="form-control" id="name_en" name="name_en" value="{{old('name_en')}}">
										</div>

										<div class="form-group">
											<label for="name_en">{{__('category.Image')}} <span class="text-danger">* (png, jpg)</span></label>
											<input type="file" class="form-control" id="img" name="img">
										</div>

										<div class="modal-footer">
											<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('modal.Cancel')}}</button>
											<button class="btn ripple btn-primary" type="submit">{{__('modal.Confirm')}}</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					{{--end of  add category modal --}}


					{{-- edit  modal --}}
					<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
					aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">{{__('category.Edit Category')}}</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form id="editForm" autocomplete="off" enctype="multipart/form-data">
									@csrf
									@method('PUT')
									<input type="hidden" name="id" id="id">
									<div class="form-group">
										<label for="old_name_ar">{{__('category.Name(Arabic)')}} <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="old_name_ar" name="name_ar">
									</div>

									<div class="form-group">
										<label for="old_name_en">{{__('category.Name(English)')}} <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="old_name_en" name="name_en">
									</div>

									<div class="form-group row">
										<div class="col-8">
											<label for="name_en">{{__('category.Image')}} <span class="text-danger">* (png, jpg)</span></label>
											<input type="file" class="form-control" id="img" name="img">
										</div>
										<div class="col d-flex justify-content-center">
											<img src="" alt="" id="old_img" style="width: 4rem;border: 1px solid black;">
										</div>
									</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary">{{__('modal.Confirm')}}</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('modal.Cancel')}}</button>
							</div>
							</form>
						</div>
					</div>
				</div>

				{{-- end of edit  modal --}}


				{{-- delete modal --}}
				 <div class="modal" id="deleteModal">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content modal-content-demo">
							<div class="modal-header">
								<h6 class="modal-title">{{__('category.Delete Category')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
									type="button"><span aria-hidden="true">&times;</span></button>
							</div>
							<form id="deleteForm">
								@csrf
								<div class="modal-body">
									<p>{{__('modal.Delete Form')}}</p><br>
									<input class="form-control" name="name" id="name" type="text" readonly>
									<input id="id" name='id' type="hidden">
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-danger">{{__('modal.Confirm')}}</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('modal.Cancel')}}</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				{{--end of delete modal --}}
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
{{-- modals data --}}
{{-- edit --}}
<script>
    $('#editModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let id = button.data('id')
        let name_ar = button.data('name_ar')
        let name_en = button.data('name_en')
        let img = button.data('img')
        let modal = $(this)
        modal.find('.modal-body #old_name_ar').val(name_ar);
        modal.find('.modal-body #old_name_en').val(name_en);
        modal.find('.modal-body #old_img').prop('src', img)
        modal.find('.modal-body #id').val(id);
    })
</script>
{{-- delete --}}
<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget)
        let id = button.data('id')
        let name = button.data('name')
        let modal = $(this)
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #id').val(id);
    })
</script>

{{-- add category form submission --}}
<script>
	$('#addForm').submit(function (e) {
		e.preventDefault();
		let formData = new FormData(this);
		$.ajax({
			type: "POST",
			url: "{{route('categories.store')}}",
			processData: false,
			contentType: false,
			data: formData,
			success: function (response) {
				// hide modal and reset add form
				$('#addForm').trigger("reset")
				$('#addModal').modal('hide')
				$('#categoriesTable').load(window.location.href + " #categoriesTable" );
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
						msg: result,
						position: "right",
						width: 300,
						autohide: false,
						multiline: true
				});
			}
		});
	});
</script>

{{-- delete form submission --}}
<script>

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
		url: `categories/${formData.get('id')}`,
		data: formData,
		processData: false,
		contentType: false,
		success: function (response) {
			//refresh table
			$('#categoriesTable').load(window.location.href + " #categoriesTable" );
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

{{-- edit form submission --}}
<script>
	$('#editForm').submit(function (e) {
		e.preventDefault();
		let formData = new FormData(this);
		let id = formData.get('id')
		$.ajax({
			type: "POST",
			url: `categories/${id}`,
			processData: false,
			contentType: false,
			data: formData,
			success: function (response) {
				// hide modal
				console.log('success')
				$('#categoriesTable').load(window.location.href + " #categoriesTable" );
				$('#editModal').modal('hide')
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
						msg: result,
						position: "right",
						width: 300,
						autohide: false,
						multiline: true
				});
			}
		});
	});
</script>
@endsection
