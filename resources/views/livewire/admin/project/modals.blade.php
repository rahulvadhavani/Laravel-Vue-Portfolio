<div wire:ignore.self class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content card" wire:ignore.self class="modal fade">
        <div class="modal-header card-header">
          <h5 class="modal-title" id="pageModalLabel">@if($recordId == 0) Create @else Update @endif {{$curPage}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form class="card-body"  wire:submit.prevent="submit" method="POST">
          <div class="modal-body">
            <div class="">      
                <div class="row clearfix">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label><b> Title</b></label>
                            <input type="hidden" wire:model.lazy="recordId">
                            <input wire:keydown="updateSlag" wire:model="title" type="text" class="form-control">
                            @error('title') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group">
                        <label><b> Slug</b></label>
                        <input  wire:model="slug" type="text" class="form-control">
                        @error('slug') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <label><b> Category</b></label>
                      <select wire:model.lazy="category_id" class="form-control show-tick">
                          <option selected>-- category --</option>
                          @forelse($categories as $category)
                          <option value="{{$category['id']}}">{{$category['name']}}</option>
                          @empty
                          <option>-no record found-</option>
                          @endforelse
                      </select>
                      @error('category_id') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 col-sm-12">
                      <div class="form-group">
                        <label><b>Team Size</b></label>
                        <input wire:model.lazy="team_size" type="number" min="1" class="form-control">
                        @error('team_size') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
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
                  <div class="form-group col-md-3 col-sm-12 mt-1">
                    @if ($image)
                      <img class="preview_image" id="preview_image" src="{{ $image->temporaryUrl() }}">
                    @elseif($recordId > 0)
                      <img class="preview_image" src="{{ $previewImage }}">
                    @endif
                  </div>
                  <div class="form-group col-sm-12" wire:ignore>
                    <label for="">Technologies</label>
                    <div class="bs-example" wire:ignore.self>
                      <input wire:ignore type="hidden" wire:model.lazy="technologies" >
                      <input type="text" class="form-control" data-role="tagsinput" id="technologiesId">
                    </div>
                  </div>
                  <div class="form-group col-sm-12">
                  @error('technologies') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group mt-3">
                      <label><b>Description</b></label>
                      <textarea wire:model.lazy="description" rows="5" class="form-control no-resize" placeholder="Please type description"></textarea>
                      @error('description') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label><b>Start Date</b></label>
                      <input onchange="this.dispatchEvent(new InputEvent('input'))" data-date-format="yyyy-mm-dd" wire:model="start_date" type="text" class="form-control datepicker" data-provide="datepicker" placeholder="Date">
                      @error('start_date') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label><b>End Date</b></label>
                      <input onchange="this.dispatchEvent(new InputEvent('input'))" data-date-format="yyyy-mm-dd" wire:model="end_date" type="text" class="form-control datepicker" data-provide="datepicker" placeholder="Date">
                      @error('end_date') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                      <div class="form-group">
                          <label><b>Project url</b></label>
                          <input  wire:model.lazy="project_url" type="text" class="form-control">
                          @error('project_url') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                      <div class="form-group">
                          <label><b>Source code</b></label>
                          <input wire:model.lazy="source_code" type="text" class="form-control">
                          @error('source_code') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
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
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
              <div class="col-lg-4 col-md-12">
                  @if($blog_image??true)
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title">{{$curPage}} Image</h3>
                      </div>
                      <div class="card-body">
                      <img class="rounded" src="{{$modalData->image ?? ''}}" alt="">
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
                                  <small class="text-muted">Category: </small>
                                  <p class="mb-0">{{$modalData->category->name ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">Team Size: </small>
                                  <p class="mb-0">{{$modalData->team_size ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">Start date : </small>
                                  <p class="mb-0">{{$modalData->start_date ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">End date : </small>
                                  <p class="mb-0">{{$modalData->end_date ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">Status : </small>
                                  <p class="mb-0">{{$modalData->status ?? '-'}}</p>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
              <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Technologies</h3>
                    </div>
                    <div class="card-body">
                      @forelse($modalData->technologies as $technology)
                      <div class="chip mt-2">
                        <i class="fa fa-hashtag"></i>{{$technology}}
                      </div>
                      @empty
                      <small>No technology</small>
                      @endforelse
                    </div>
                </div>
                  <div class="card">
                      <div class="card-header">
                          <h3 class="card-title">Description</h3>
                      </div>
                      <div class="card-body" style="max-height: 800px; overflow:scroll">
                         {{$modalData->description}}
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
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
<style>
  .preview_image{
    height: 70px;
  }
  .bootstrap-tagsinput {
    width: 100%;
  }
  .bootstrap-tagsinput .tag {
    margin-right: 2px;
    color: #ffffff;
    background-color: #e74c3e;
  }
</style>
@endpush
@push('js')
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script>
      $('#technologiesId').on('itemAdded', function(event) {
        let technologiesVal = $("#technologiesId").val();
        @this.set('technologies', technologiesVal);
      });

      $('#technologiesId').on('itemRemoved', function(event) {
        let technologiesVal = $("#technologiesId").val();
        @this.set('technologies', technologiesVal);
      });

      window.addEventListener('addUpdateModal', event => {
        let recordId = @this.get('recordId');
        if(recordId > 0){
          @this.get('technologiesArr').map(function(val){
            $("#technologiesId").tagsinput('add', val);
          });
        }else{
          $("#technologiesId").tagsinput('removeAll');
          $('#preview_image').attr('src',"").hide();
        }
        $("#pageModal").modal('show');
    })    
</script>
@endpush
