<div class="row row-sm mt-2">
    <div class="col-xl-3 col-lg-3 col-md-12 mb-3 mb-md-0">
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 mb-0 font-weight-bold text-uppercase">{{__('Category')}}</div>
            <div class="card-body pb-0">
                <div class="form-group">
                    <label class="form-label">{{__('Categories')}}</label>
                    <select wire:model="category" name="beast" id="select-beast" class="form-control  nice-select  custom-select">
                        <option selected value="">All</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-9 col-md-12">
        <div class="card">
            <div class="card-body p-2">
                <div class="input-group">
                    <input wire:model="search" type="text" class="form-control" placeholder="{{__('Search')}} ...">
                </div>
            </div>
        </div>
       
        <div class="row row-sm">
            @forelse ($products as $product)
                <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="pro-img-box">
                                <img class="w-100" style="height: 300px" src="{{URL::asset("storage/$product->cover")}}" alt="product-image">
                                <a wire:click='AddToCart("{{$product->id}}", "{{$product->name}}", "1", "{{$product->price}}", "{{URL::asset("storage/$product->cover")}}")'  class="adtocart @if ($cart->contains($product->id)) border-info @endif"> 
                                    <i class="las la-shopping-cart"></i>
                                </a>
                            </div>
                            <div class="text-center pt-3">
                                <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase">{{$product->name}}</h3>
                                <span class="tx-15 ml-auto badge badge-info">
                                    {{$product->category->name}}
                                </span>
                                <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">{{"$" . $product->price}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="row mt-4 w-100">
                    <p class="mx-auto">{{__('No results found for') . ($search ?  ' "' . $search . '"'  : ' ') }}</p>
                </div>
            @endforelse
        </div>
        <div class="pagination product-pagination mr-auto float-left row">
            {{$products->links()}}
        </div>
    </div>
</div>