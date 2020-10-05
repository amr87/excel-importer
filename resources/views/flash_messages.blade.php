{{--  Flash Messages --}}
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
@if(session($msg))
<div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
    <strong> {{session($msg) }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@endforeach


{{--  Validation Errors --}}
@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong> {{ $error }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endforeach
@endif