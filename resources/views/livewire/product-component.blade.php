<div class="col-xl-12">
    <div class="card">
        <div class="card-header pb-0">
            @can('Product_create')
                <div class="col">
                       @include('products.create')
                </div>
            @endcan              
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="posts" class="table text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">{{__('Name')}}</th>
                            <th class="border-bottom-0">{{__('Cover')}}</th>
                            <th class="border-bottom-0">{{__('Category')}}</th>
                            <th class="border-bottom-0">{{__('Price')}}</th>
                            <th class="border-bottom-0">{{__('Description')}}</th>
                            <th class="border-bottom-0">{{__('Created By')}}</th>
                            <th class="border-bottom-0">{{__('Operations')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr class="text-center">
                            <td class="align-middle">{{$loop->iteration}}</td>
                            <td class="align-middle">{{$product->name}}</td>
                            <td>
                                <img src="{{asset('storage/'.$product->cover)}}" style="width: 200px; border:1px solid black; border-radius:3px">
                            </td>
                            <td><span class="badge badge-success font-weight-bold tx-10">{{$product->category->name}}</span></td>
                            <td class="align-middle">{{'$' . $product->price}}</td>
                            <td class="align-middle">{{$product->description}}</td>
                            <td class="align-middle">{{$product->created_by->name}}</td>
                            <td>
                                @can('Product_edit')
                                    <a  class="btn btn-sm btn-info text-light" wire:click="edit({{$product->id}})"
                                    data-toggle="modal" data-target="#editModal"
                                    title="{{__('modal.Edit')}}"><i class="las la-pen"></i></a> 
                                @endcan
                            
                                @can('Product_delete')
                                    <a wire:click="setDeletedProduct('{{$product->id}}')" class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
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
    @include('products.delete')
    @include('products.edit')
</div>
