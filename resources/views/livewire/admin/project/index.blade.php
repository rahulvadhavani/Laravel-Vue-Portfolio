<div class="section-body mt-4">    
    <div class="col-12">
        <div class="card p-3">
            <div class="table-responsive">
                <livewire:admin.project.table />
            </div>
        </div>
    </div>
    @include('livewire.admin.project.modals')
</div>
@section('page')
{{$page}}
@endsection

