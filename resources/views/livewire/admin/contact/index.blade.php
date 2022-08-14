<div class="section-body mt-4">    
    <div class="col-12">
        <div class="card p-3">
            <div class="table-responsive">
                <livewire:admin.contact.table />
            </div>
        </div>
    </div>
    @include('livewire.admin.contact.modals')
</div>
@section('page')
{{$page}}
@endsection
@push('js')
<script>
    $(document).ready(function () {
        $(".detail-modal").on('click', function () {
            Livewire.emit('view',$(this).data("id"))
        });
        
        $(".edit-modal").on('click', function () {
            Livewire.emit('view',$(this).data("id"))
        });
    });
  
 
</script>
@endpush

