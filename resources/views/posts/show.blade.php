<div class="row d-flex justify-content-between">
    @foreach ($posts as $post)
    <div class="card col-lg-4 col-md-12">
        <img class="card-img-top w-100 pt-2" style="max-height: 200px" src="{{asset('storage/'.$post->images[0]->image)}}" alt="">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <h4 class="card-title mb-3">{{$post->title}}
                </div>
                <div class="col-4">
                    @can('Post_edit')
                        <a  class="modal-effect btn btn-sm btn-info"
                        data-effect="effect-scale" data-toggle="modal" href="#editModal"
                        data-id="{{$post->id}}" data-title="{{$post->title}}"
                        title="{{__('modal.Edit')}}"><i class="las la-pen"></i></a> 
                    @endcan
                
                    @can('Post_delete')
                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                        data-id="{{$post->id}}" data-title="{{$post->title}}"
                        data-toggle="modal" href="#deleteModal" title="{{__('modal.Delete')}}"><i
                        class="las la-trash"></i></a>
                    @endcan      
                </div>
            </div>
            </h4>
            <span class="badge badge-success mb-2">{{$post->category->name}}</span>
            <p class="card-text">{{  Str::of($post->body)->limit(100); }}</p>
        </div>
    </div>
    @endforeach
</div>