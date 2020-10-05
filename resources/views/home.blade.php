@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Import Excel Sheet</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @include('flash_messages')
                    <form action="{{ route('processImport') }}" method="POST" enctype="multipart/form-data">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="sheet" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <br />
                        <br />
                        <button type="submit" class="btn btn-primary">Submit</button>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection