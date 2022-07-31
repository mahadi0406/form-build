@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12 pt-5">
			<table class="table">
				<thead>
				    <tr>
				      	<th scope="col">Title</th>
				      	<th scope="col">Link</th>
				      	<th scope="col">Status</th>
				      	<th scope="col">Action</th>
				    </tr>
				</thead>
			  <tbody>
				@forelse(auth()->user()->forms as $form)
				    <tr>
				      	<td>{{$form->title}}</td>
				      	<td>{{url('').'/'.$form->hash_code}}</td>
				      	<td>
				      		@if($form->status == App\Enums\FormStatus::ACTIVE->value)
					            <span class="badge bg-success">Active</span>
					        @else
					        	<span class="badge bg-warning">Inactive</span>
					        @endif
				      		<a href="javascript:void(0)"  class="badge bg-info ms-2 statusupdate"  data-bs-toggle="modal" 
				      		data-bs-target="#exampleModal" 
				      		data-id="{{$form->id}}"
				      		data-status="{{$form->status}}"><i class="las la-info-circle"></i></a>
				      	</td>
				      	<td>
				      		<a href="{{route('user.csv.download', $form->id)}}" class="btn btn-sm btn-primary">@lang('Download')
				      		</a>
				      		<a href="javascript:void(0)" class="btn btn-sm btn-danger formdelete" data-bs-toggle="modal" 
				      		data-bs-target="#delete" 
				      		data-id="{{$form->id}}"
				      		>@lang('Delete')
				      		</a>
				      	</td>
				    </tr>
				@empty
					<tr>
                        <td class="text-muted text-center" colspan="100%">Data Not Found</td>
                    </tr>
				@endforelse
			  </tbody>
			</table>
		</div>
	</div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Status Update</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{route('user.form.update')}}" method="POST">
				@csrf
				<input type="hidden" value="" name="id">
				<div class="modal-body">
					<select class="form-select" name="status">
						<option value="1">Active</option>
						<option value="2">Inactive</option>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>



<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Form Delete</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{route('user.form.delete')}}" method="POST">
				@csrf
				<input type="hidden" value="" name="id">
				<div class="modal-body">
					<p>Are you sure want to delete this form ?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('script')
<script type="text/javascript">
	"use strict";
	$('.statusupdate').on('click', function(){
		var modal = $('#exampleModal');
		modal.find('input[name=id]').val($(this).data('id'));
		modal.find('select[name=status]').val($(this).data('status'));
		modal.modal('show');
	});

	$('.formdelete').on('click', function(){
		var modal = $('#delete');
		modal.find('input[name=id]').val($(this).data('id'));
		modal.modal('show');
	});
</script>
@endpush