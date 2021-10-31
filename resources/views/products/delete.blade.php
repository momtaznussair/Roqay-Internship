 <!-- delete modal -->
 <div wire:ignore.self class="modal" id="deleteModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{__('Delete Post')}}</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form  wire:submit.prevent="delete">
                <div class="modal-body">
                    <p>{{__('modal.Delete Form')}}</p><br>
                    <input  class="form-control" type="text" value="{{$product->name ?? 'Not Found'}}" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('modal.Cancel')}}</button>
                    <button type="submit" class="btn btn-danger">{{__('modal.Confirm')}}</button>
                </div>
        </div>
        </form>
    </div>
</div>