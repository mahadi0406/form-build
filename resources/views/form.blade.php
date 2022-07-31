@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12 pt-5">
			<img class="bg-img" src="{{@$elements->cover}}">
			<div class="card justify-content-center mt-5">
                <div class="card-header text-center">{{@$elements->title}}</div>
                <div class="card-body">
                	<h6 class="text-center">{{@$elements->description}}</h6>
                    <form method="POST" action="{{route('form.submit',$form->id)}}" enctype="multipart/form-data">
                        @csrf
                        @foreach(@$elements->form as $content)
                        	@if(@$content->type == "text")
		                        <div class="mb-3">
		                            <label for="title" class="form-label">{{@$content->label}} <sup class="text-danger">*</sup></label>
		                            <input type="text" class="{{@$content->attributes->class}}" id="title" name="{{@$content->name}}" value="{{old(@$content->name)}}" placeholder="{{@$content->label}}" required>
		                        </div>
		                    @elseif(@$content->type == "select")
		                        <div class="mb-3">
		                            <label for="status" class="form-label">{{@$content->label}} <sup class="text-danger">*</sup></label>
		                            <select class="{{@$content->attributes->class}}" id="status" name="{{@$content->name}}" aria-label="Default select example">
		                                @foreach(@$content->options as $value)
			                                <option value="{{$value}}">{{$value}}</option> 
			                            @endforeach
		                            </select>
		                        </div>
		                    @elseif(@$content->type == "button")
                        		<button type="submit" class="btn {{@$content->attributes->class}} w-100 my-4">{{@$content->name}}</button>
		                    @endif
	                    @endforeach
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection

@push('style')
<style type="text/css">
	.bg-img{
		width: 100%;
		max-height: 200px;
	}

</style>
@endpush