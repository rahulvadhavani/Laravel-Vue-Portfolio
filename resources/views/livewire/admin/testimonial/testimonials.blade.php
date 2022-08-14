<div class="section-body mt-4">    
    <div class="col-12">
        <div class="card p-3">
            <div class="table-responsive">
                <livewire:admin.testmonial.table />
            </div>
        </div>
    </div>
    @include('livewire.admin.testimonial.modals')
</div>
@section('page')
{{$page}}
@endsection

