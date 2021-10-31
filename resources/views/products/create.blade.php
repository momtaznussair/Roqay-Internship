  <a wire:click="getCategories" class="btn btn-outline-primary" data-toggle="modal" href="#addModal">{{__('Add New Product')}}</a>
  
  {{-- add modal --}}
  <div wire:ignore.self class="modal" id="addModal">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{__('Add New Product')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
                <div class="modal-body p-4">
                    <form wire:submit.prevent="store" id="addForm" method="POST" autocomplete="off" enctype="multipart/form-data">
                    {{-- 1 --}}
                    <div class="row form-group">
                        <div class="col">
                            <label for="name_en" class="form-label">{{__('Name In English')}} <span class="tx-danger">*</span></label>
                            <input wire:model="name_en" class="form-control" id="name_en" name="name_en" required type="text">
                            @error('name_en') <span class="tx-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="col">
                            <label for="name_ar" class="form-label">{{__('Name In Arabic')}} <span class="tx-danger">*</span></label>
                            <input wire:model="name_ar" class="form-control" id="name_ar" name="name_ar" required type="text">
                            @error('name_ar') <span class="tx-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col">
                            <label for="category" class="form-label">{{__('Category')}} <span class="tx-danger">*</span></label>
                            <select wire:model="category_id" id="category" class="form-control" name="category_id">
                                <option selected>Choose category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id') <span class="tx-danger">{{$message}}</span> @enderror
                    </div>
                    {{-- 2 --}}
                    <div class="row form-group">
                        <div class="col">
                            <label for="cover" class="form-label">{{__('Cover')}} 
                                <span class="tx-danger">*</span>
                                <span class="tx-danger ml-2">(png, jpg, jpeg)</span>
                            </label>
                            <input wire:model="cover" type="file" id="cover" class="form-control" name="cover"/>
                            @error('cover') <span class="tx-danger">{{$message}}</span> @enderror
                        </div>

                        <div class="col">
                            <label for="price" class="form-label">{{__('Price')}} <span class="tx-danger">*</span></label>
                            <input wire:model="price" class="form-control" id="price" name="price" required type="number">
                            @error('price') <span class="tx-danger">{{$message}}</span> @enderror
                        </div>
                    </div>

                    {{-- 4 --}}
                    <div class="row form-group">
                        <div class="col">
                            <label for="title" class="form-label">{{__('Description In English')}} <span class="tx-danger">*</span></label>
                            <textarea wire:model="description_en" class="form-control" name="description_en" required rows="3"></textarea>
                            @error('description_en') <span class="tx-danger">{{$message}}</span> @enderror
                        </div>
                    </div>

                    {{-- 5 --}}
                    <div class="row form-group">
                        <div class="col">
                            <label for="title" class="form-label">{{__('Description In Arabic')}} <span class="tx-danger">*</span></label>
                            <textarea wire:model="description_ar" class="form-control" name="description_ar" required rows="3"></textarea>
                            @error('description_ar') <span class="tx-danger">{{$message}}</span> @enderror
                        </div>
                    </div>

                    {{-- 6 --}}
                    <div class="row form-group px-2">
                        <label for="images" class="form-label mb-3">{{__('Images')}} 
                            <span class="tx-danger">*</span>
                            <span class="tx-danger ml-2">(png, jpg, jpeg)</span>
                        </label>
                        <input wire:model="images" type="file" id="images" class="form-control" name="images[]" multiple="multiple" />
                        @error('images') <span class="tx-danger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="cancel" class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('cancel')}}</button>
                    <button class="btn ripple btn-primary" type="submit">{{__('confirm')}}</button>
                </div>
            </form>
        </div>
    </div>
   </div>
{{-- end of add modal --}}
