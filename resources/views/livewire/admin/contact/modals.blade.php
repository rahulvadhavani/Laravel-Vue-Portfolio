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
                  <div class="card">
                      <div class="card-body">
                          <ul class="list-group">
                              <li class="list-group-item">
                                  <small class="text-muted">User Name: </small>
                                  <p class="mb-0">{{$modalData->name ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">Email: </small>
                                  <p class="mb-0">{{$modalData->email ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">Subject: </small>
                                  <p class="mb-0">{{$modalData->subject ?? '-'}}</p>
                              </li>
                              <li class="list-group-item">
                                  <small class="text-muted">Message: </small>
                                  <p class="mb-0">{{$modalData->message ?? '-'}}</p>
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

@push('css')
<style>
  .preview_image{
    height: 70px;
  }

</style>
@endpush
