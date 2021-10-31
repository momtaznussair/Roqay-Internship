@extends('layouts.master')
@section('title')
    {{__('Posts')}}
@stop
@section('css')
<style>
    td{
        vertical-align: middle !important;
    }
</style>
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('Posts')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Add New Post')}}</span>
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
                    <div class="col">
                        <a class="btn btn-outline-primary" data-toggle="modal" href="#addModal">{{__('Add New Post')}}</a>
                    </div>
                @endcan              
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="posts" class="table text-md-nowrap">
                        <thead>
                            <tr class="text-center">
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">{{__('Title')}}</th>
                                <th class="border-bottom-0">{{__('Thumbnail')}}</th>
                                <th class="border-bottom-0">{{__('Category')}}</th>
                                <th class="border-bottom-0">{{__('Operations')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                            <tr class="text-center">
                                <td class="align-middle">{{$loop->iteration}}</td>
                                <td class="align-middle">{{$post->title}}</td>
                                <td class="align-middle">
                                    <img src="{{asset('storage/'.$post->images[0]->image)}}" style="width: 100px; border:1px solid black; border-radius:3px">
                                </td>
                                <td><span class="badge badge-secondary font-weight-bold tx-10">{{$post->category->name}}</span></td>
                                <td>
                                    @can('Post_edit')
                                    <a  class="modal-effect btn btn-sm btn-info"
                                    data-effect="effect-scale" data-toggle="modal" href="#editModal" data-post="{{$post}}"
                                    data-images="{{$post->images->map(function ($image) {
                                        $image->image =  asset('storage/'.$image->image);
                                        return $image;
                                    });}}"
                                    title="{{__('modal.Edit')}}"><i class="las la-pen"></i></a> 
                                @endcan
                            
                                @can('Post_delete')
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                    data-id="{{$post->id}}" data-title="{{$post->title}}"
                                    data-toggle="modal" href="#deleteModal" title="{{__('modal.Delete')}}"><i
                                    class="las la-trash"></i></a>
                                @endcan      
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               <div class="row">
                {{$posts->links()}}
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
                    <h6 class="modal-title">{{__('Delete Post')}}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form  method="post" id="deleteForm">
                    <div class="modal-body">
                        <p>{{__('modal.Delete Form')}}</p><br>
                        <input class="form-control" name="title" id="title" type="text" readonly>
                        <input type="hidden" name='id' id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('modal.Cancel')}}</button>
                        <button type="submit" class="btn btn-danger">{{__('modal.Confirm')}}</button>
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
                    <h6 class="modal-title">{{__('Add New Post')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body p-4">
                        <form id="addForm" method="POST" autocomplete="off" enctype="multipart/form-data">
                        {{-- 1 --}}
                        <div class="row form-group">
                            <div class="col-7">
                                <label for="title" class="form-label">{{__('Title')}} <span class="tx-danger">*</span></label>
                                <input class="form-control" id="title" name="title" required type="text">
                            </div>
                            <div class="col-5">
                                <label for="category" class="form-label">{{__('Category')}} <span class="tx-danger">*</span></label>
                                <select id="category" class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- 2 --}}
                        <div class="row form-group px-2">
                            <label for="content" class="form-label">{{__('Content')}} <span class="tx-danger">*</span></label>
                                <textarea class="form-control" id="content" name="body" required rows="3"></textarea>
                        </div>
                        {{-- 3 --}}
                        <div class="row form-group px-2">
                            <label for="images" class="form-label">{{__('Images')}} 
                                <span class="tx-danger">*</span>
                                <span class="tx-danger ml-2">(png, jpg, jpeg)</span>
                            </label>
                            <input type="file" id="images" class="dropify" name="images[]" multiple="multiple" data-height="70" />
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

    {{-- edit modal --}}
    <div class="modal" id="editModal">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{__('Edit Post')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body row">
                   <div class="col-8">
                        <form id="editForm">
                            @method('PUT')
                            <input type="hidden" name="id" id="id">
                        {{-- 1 --}}
                        <div class="row form-group">
                            <div class="col-7">
                                <label for="title" class="form-label">{{__('Title')}} <span class="tx-danger">*</span></label>
                                <input class="form-control" id="title" name="title" required type="text">
                            </div>
                            <div class="col-5">
                                <label for="category" class="form-label">{{__('Category')}} <span class="tx-danger">*</span></label>
                                <select id="category" class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- 2 --}}
                        <div class="row form-group px-2">
                            <label for="content" class="form-label">{{__('Content')}} <span class="tx-danger">*</span></label>
                                <textarea class="form-control" id="content" name="body" required rows="8"></textarea>
                        </div>
                         {{-- 3 --}}
                        <div class="row form-group px-2">
                            <label for="images" class="form-label">{{__("Add Images")}} 
                                <span class="tx-danger">*</span>
                                <span class="tx-danger ml-2">(png, jpg, jpeg)</span>
                            </label>
                            <input type="file" id="images" class="dropify" name="images[]" multiple="multiple"  data-height="70" />
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('cancel')}}</button>
                            <button class="btn ripple btn-primary" type="submit">{{__('confirm')}}</button>
                        </div>
                        </form>
                   </div>
                   <div class="col-4 imageFrame" id="images" style="overflow: scroll; max-height:100%">

                   </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end of edit modal --}}

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
    
// delete modal
$('#deleteModal').on('show.bs.modal', function(event) {
    let button = $(event.relatedTarget)
    let id = button.data('id')
    let title = button.data('title')
    let modal = $(this)
    modal.find('.modal-body #title').val(title);
    modal.find('.modal-body #id').val(id);
})

// edit modal
$('#editModal').on('show.bs.modal', function(event) {
    let button = $(event.relatedTarget)
    let post = button.data('post')
    let images = button.data('images')
    let modal = $(this)
    modal.find('.modal-body input[name="title"]').val(post.title);
    modal.find('.modal-body #id').val(post.id);
    modal.find('.modal-body #content').val(post.body);
    modal.find(`.modal-body #category option[value=${post.category_id}]`).prop('selected', true);
    let imagesFrame = modal.find('.modal-body #images');
    imagesFrame.empty();
    images.forEach((image) => {
        imagesFrame.append(`
        <div>
        <a class="font-weight-bold tx-20 removeImage" style="color:red" id=${image.id}>&times;</a>
        <img src="${image.image}"></div>`
        );
    });
    if(images.length == 1)
    {
        $('.removeImage').remove();
    }
})

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
    postRequest("POST", "{{route('posts.store')}}", formData, '#addForm', '#addModal');
});

//edit request
$('#editForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    postRequest("POST", `posts/${formData.get('id')}`, formData, '#editForm', '#editModal');
});


// delete request
$('#deleteForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    postRequest("DELETE", `posts/${formData.get('id')}`, formData, '#deleteForm', '#deleteModal');
});

function postRequest(method, url, formData, formId, modalId) {
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
            $('#posts').load(window.location.href + " #posts" );
            // notify user
            notif({
                msg: response,
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
//end of postRequest function

//remove an image
$('#editModal').click(function (e) {
    if($(e.target).hasClass('removeImage')){
        let id = e.target.id;
        if(confirm('{{__("Are you sure you want to delete this image ?")}}'))
        {
            $.ajax({
            type: 'DELETE',
            url: `post-images/${id}`,
            processData: false,
            contentType: false,

            success: function (response) {
                $('#posts').load(window.location.href + " #posts" );
                $(`#editModal #images #${id}`).parent().remove();
                console.log($('#images div').length);
                if($('.imageFrame>div').length == 1)
                {
                    $('.removeImage').remove();
                }
                // notify user
                notif({
                    msg: response,
                    type: "success"
                })
            }
            });
        }
    }
});
</script>
<!--Internal Fileuploads js-->
<script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

@endsection