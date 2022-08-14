<div wire:ignore.self class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content card" wire:ignore.self class="modal fade">
        <div class="modal-header card-header">
          <h5 class="modal-title" id="pageModalLabel">@if($recordId == 0) Create @else Update @endif {{$curPage}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="card-body"  wire:submit.prevent="submit" method="POST">
          <div class="modal-body">
            <div class="row">      
                <div class="row clearfix">
                  <div class="col-md-12 col-sm-12">
                      <div class="form-group">
                          <label><b> Title</b></label>
                          <input type="hidden" wire:model.lazy="recordId">
                          <input wire:keydown="updateSlag" wire:model="title" type="text" class="form-control">
                          @error('title') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                      </div>
                  </div>
                  <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                      <label><b> Slug</b></label>
                      <input  wire:model="slug" type="text" class="form-control">
                      @error('slug') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-12">
                    <label><b>Image</b></label>
                      <div class="custom-file">
                        <input wire:model.lazy="image"  type="file" class="form-control custom-file-input" id="customFile" onchange="loadFile(event)">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                      </div>
                      @error('image') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group col-md-6 col-sm-12 mt-1 text-center">
                    @if ($image)
                      <img class="preview_image" id="preview_image" src="{{ $image->temporaryUrl() }}">
                    @elseif($recordId > 0)
                      <img class="preview_image" src="{{ $image_thumbnail }}">
                    @endif
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group mt-3">
                      <label><b>Description</b></label>
                      <textarea wire:model.lazy="description" rows="2" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                      @error('description') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer card-header">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">@if($recordId == 0) Submit @else Update @endif</button>
          </div>
        </form>
    </div>
  </div>
</div>

<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content card" wire:ignore.self class="modal fade">
      <div class="modal-header card-header">
        <h5 class="modal-title card-title" id="pageModalLabel">{{$curPage}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!--  -->
      @if(isset($modalData) && $modalData != null)
      <div class="container-fluid">
          <div class="row clearfix">
              <div class="col-12">
                  @if($modalData->image??true)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{$curPage}} Image</h3>
                        </div>
                        <div class="card-body text-center">
                        <img class="rounded" height="250" src="{{$modalData->image?? ''}}" alt="">
                        </div>
                    </div>
                  @endif
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title">{{$curPage}} Detail</h3>
                      </div>
                      <div class="card-body">
                          <ul class="list-group">
                              <li class="list-group-item">
                                  <small class="text-muted">Title: </small>
                                  <p class="mb-0">{{$modalData->title ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">Slug: </small>
                                  <p class="mb-0">{{$modalData->slug ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">Description: </small>
                                  <p class="mb-0">{{$modalData->description ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">Created On: </small>
                                  <p class="mb-0">{{$modalData->created_at->format('d-m-Y H:i:s') ?? '-'}}</p>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      @endif
      <!--  -->
      </div>
      <div class="modal-footer card-header">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button type="button" class="btn btn-success AddModalBtn" wire:click="viewAddModal()"><i class="fa fa-plus fa2"></i></button>

@push('css')
<style>
  .preview_image{
    height: 70px;
  }

</style>
@endpush
@push('js')
<script>
</script>
@endpush
