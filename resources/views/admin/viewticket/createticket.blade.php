
@extends('layouts.adminmaster')

@section('styles')

<!-- INTERNAl Summernote css -->
<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

<!-- INTERNAl Dropzone css -->
<link href="{{asset('assets/plugins/dropzone/dropzone.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

@endsection

					@section('content')

					<!--Page header-->
					<div class="page-header d-xl-flex d-block">
						<div class="page-leftheader">
							<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Create Ticket</span></h4>
						</div>
					</div>
					<!--End Page header-->

					<!-- Create Ticket List-->
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card ">
							<div class="card-header border-0">
								<h4 class="card-title">New Ticket</h4>
							</div>
							<form method="post"  id="admin_form" enctype="multipart/form-data">
								@csrf

								<div class="card-body">
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">Ticket Subject  <span class="text-red">*</span></label>
											</div>
											<div class="col-md-9">
												<input type="text" id="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Subject" name="subject" value="{{ old('subject') }}">
												<span id="SubjectError" class="text-danger alert-message"></span>
												@error('subject')
												
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">Ticket Category<span class="text-red">*</span></label>
											</div>
											<div class="col-md-9">
												<select  class="form-control select2-show-search  select2 @error('category') is-invalid @enderror"  data-placeholder="Select Category" name="category" id="category">
													<option label="Select Category"></option>
													@foreach ($categories as $category)

														<option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ $category->name }}</option>
													@endforeach

												</select>
												<span id="CategoryError" class="text-danger alert-message"></span>
												@error('category')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
										</div>
									</div>
									
									
									<div class="form-group ticket-summernote ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">Ticket Description<span class="text-red">*</span></label>
											</div>
											<div class="col-md-9">
												<textarea class="summernote form-control @error('message') is-invalid @enderror" rows="7" name="message">{{old('message')}}</textarea>
												<span id="MessageError" class="text-danger alert-message"></span>
												@error('message')

													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror

											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label mb-0 mt-2">Upload File</label>
											</div>
											<div class="col-md-9">
												<input type="file" name="file">
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<div class="form-group float-end">
										<input type="submit"  class="btn btn-secondary btn-lg purchasecode"  value="Create ticket" >
									</div>
								</div>
							</form>
						</div>
					</div>
					<!--End Create Ticket List-->
					@endsection

		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/js/support/support-createticket.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/js/select2.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Dropzone js-->
		<script src="{{asset('assets/plugins/dropzone/dropzone.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			
				
			// Csrf field
			$.ajaxSetup({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			


			// summernote 
			$('.note-editable').on('keyup', function(e){
				localStorage.setItem('adminmessage', e.target.innerHTML)
			})

			// store subject to local
			$('#subject').on('keyup', function(e){
				localStorage.setItem('adminsubject', e.target.value)
			})
			

			// onload get the data from local
			$(window).on('load', function(){
				if(localStorage.getItem('adminsubject') || localStorage.getItem('adminmessage') || localStorage.getItem('adminemail')){

					document.querySelector('#subject').value = localStorage.getItem('adminsubject');
					document.querySelector('#email').value = localStorage.getItem('adminemail');
					document.querySelector('.summernote').innerHTML = localStorage.getItem('adminmessage');
					document.querySelector('.note-editable').innerHTML = localStorage.getItem('adminmessage');
				}
			})

			// Create Ticket 
			$('body').on('submit', '#admin_form', function (e) {
				e.preventDefault();
				$('#SubjectError').html('');
				$('#MessageError').html('');
				$('#EmailError').html('');
				$('#CategoryError').html('');
				$('#verifyotpError').html('');
				var actionType = $('#btnsave').val();
				var fewSeconds = 2;
				$('#btnsave').html('Sending..');
				$('#btnsave').prop('disabled', true);
					setTimeout(function(){
						$('#btnsave').prop('disabled', false);
					}, fewSeconds*1000);
				var formData = new FormData(this);

				$.ajax({
					type:'post',
					url: '{{url('/admin/createticket')}}',
					data: formData,
					cache:false,
					contentType: false,
					processData: false,
	
					success: (data) => {
						

						$('#SubjectError').html('');
						$('#MessageError').html('');
						$('#EmailError').html('');
						$('#CategoryError').html('');
						$('#verifyotpError').html('');
						toastr.success(data.success);
						if(localStorage.getItem('adminsubject') || localStorage.getItem('adminmessage') || localStorage.getItem('adminemail')){
							localStorage.removeItem("adminsubject");
							localStorage.removeItem("adminmessage");
							localStorage.removeItem("adminemail");
						}
						window.location.replace('{{url('admin/dashboard')}}');
						
						
						
						
					},
					error: function(data){

						$('#SubjectError').html(data.responseJSON.errors.subject);
						$('#MessageError').html(data.responseJSON.errors.message);
						$('#EmailError').html(data.responseJSON.errors.email);
						$('#CategoryError').html(data.responseJSON.errors.category);
						$('#verifyotpError').html(data.responseJSON.errors.verifyotp);
						
					}
				});
				
			});

			

		</script>

		@endsection
