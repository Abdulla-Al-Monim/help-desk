		@extends('layouts.usermaster')

		@section('styles')


		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

		<!-- INTERNAl DropZone css -->
		<link href="{{asset('assets/plugins/dropzone/dropzone.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<link href="{{asset('assets/plugins/wowmaster/css/animate.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')

							<!-- Section -->
							<section>
								<div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
									<div class="header-text mb-0">
										<div class="container ">
											<div class="row text-white">
												<div class="col">
													<h1 class="mb-0">Create Ticket}</h1>
												</div>
												<div class="col col-auto">
													<ol class="breadcrumb text-center">
														<li class="breadcrumb-item">
															<a href="{{url('/')}}" class="text-white-50">Home</a>
														</li>
														<li class="breadcrumb-item active">
															<a href="#" class="text-white">Create Ticket</a>
														</li>
													</ol>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<!-- Section -->

							<!--Section-->
							<section>
								<div class="cover-image sptb">
									<div class="container ">
										<div class="row">
											@include('includes.user.verticalmenu')

											<div class="col-xl-9">
												<div class="card">
													<div class="card-header  border-0">
														<h4 class="card-title">New Ticket</h4>
													</div>
													<form method="POST" id="user_form" enctype="multipart/form-data">

														@csrf

														<div class="card-body">
															<div class="form-group ">
																<div class="row">
																	<div class="col-md-3">
																		<label class="form-label mb-0 mt-2">Ticket Subject  <span class="text-red">*</span></label>
																	</div>
																	<div class="col-md-9">
																		<input type="text" id="subject"
																			class="form-control @error('subject') is-invalid @enderror"
																			placeholder="Subject" name="subject" value="{{ old('subject') }}">
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
																		<select
																			class="form-control select2-show-search  select2 @error('category') is-invalid @enderror"
																			data-placeholder="Select Category" name="category" id="category">
																			<option label="Select Category"></option>
																			@foreach ($categories as $category)

																			<option value="{{ $category->id }}" @if(old('category')) selected @endif>{{ $category->name }}</option>
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
																		<label class="form-label mb-0 mt-2">Ticket Description <span class="text-red">*</span></label>
																	</div>
																	<div class="col-md-9">
																		<textarea class="summernote form-control @error('message') is-invalid @enderror"
																			name="message" rows="4" cols="400">{{old('message')}}</textarea>
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
																		<input type="file" id="file"
																			class="form-control @error('file') is-invalid @enderror"
																			placeholder="Subject" name="file" value="{{ old('file') }}">
																			<span id="file" class="text-danger alert-message"></span>
																		@error('file')

																		<span class="invalid-feedback" role="alert">
																			<strong>{{ $message }}</strong>
																		</span>
																		@enderror
																	</div>
																</div>
															</div>
															
															
														</div>
														<div class="card-footer">
															<div class="form-group float-end">
																<input type="submit" class="btn btn-secondary btn-lg purchasecode" value="Create Ticket">
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<!--Section-->

							@endsection
		@section('scripts')

		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/js/select2.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Dropzone js-->
		<script src="{{asset('assets/plugins/dropzone/dropzone.js')}}?v=<?php echo time(); ?>"></script>

		<!-- wowmaster js-->
		<script src="{{asset('assets/plugins/wowmaster/js/wow.min.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">
            "use strict";
			
			(function($){
				
				// Variables
				var SITEURL = '{{url('')}}';

				// Csrf Field
				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				// Summernote
				$('.summernote').summernote({
					placeholder: '',
					tabsize: 1,
					height: 200,
					toolbar: [['style', ['style']], ['font', ['bold', 'underline', 'clear']], // ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
					['fontname', ['fontname']], ['fontsize', ['fontsize']], ['color', ['color']], ['para', ['ul', 'ol', 'paragraph']], // ['height', ['height']],
					['table', ['table']], ['insert', ['link']], ['view', ['fullscreen']], ['help', ['help']]]
				});


				// summernote 
				$('.note-editable').on('keyup', function(e){
					localStorage.setItem('usermessage', e.target.innerHTML)
				})

				$('#subject').on('keyup', function(e){
					localStorage.setItem('usersubject', e.target.value)
				})

				$(window).on('load', function(){
					if(localStorage.getItem('usersubject') || localStorage.getItem('usermessage')){

						document.querySelector('#subject').value = localStorage.getItem('usersubject');
						document.querySelector('.summernote').innerHTML = localStorage.getItem('usermessage');
						document.querySelector('.note-editable').innerHTML = localStorage.getItem('usermessage');
					}
				})


				$('body').on('submit', '#user_form', function (e) {
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
						url: '{{route('client.ticketcreate')}}',
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
							if(localStorage.getItem('usersubject') || localStorage.getItem('usermessage')){
								localStorage.removeItem("usersubject");
								localStorage.removeItem("usermessage");
							}
							window.location.replace('{{url('customer/')}}');
							
							
							
							
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
				
			})(jQuery);


			


		</script>

		@endsection