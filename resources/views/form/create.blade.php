@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 pt-5">
            <div class="card justify-content-center">
                <div class="card-header text-center">Build a form using json schema</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.form.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" maxlength="255" id="title" name="title" value="{{old('title')}}" placeholder="Enter Title" required>
                        </div>

                        <div class="mb-3">
                            <label for="schema_path" class="form-label">Schema File <sup class="text-danger">*</sup></label>
                            <input type="file" class="form-control" id="schema_path" name="schema_path" required>
                            <p>Supported files : <span class="fw-bold">json</span></p>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <sup class="text-danger">*</sup></label>
                            <select class="form-select" id="status" name="status" aria-label="Default select example">
                                <option selected disabled>Select Status</option>
                                <option value="1">Active</option> 
                                <option value="2">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 my-4">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection