@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

		<!-- DropZone CSS -->
		<link href="{{asset('assets/plugins/dropzone/dropzone.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- galleryopen CSS -->
		<link href="{{asset('assets/plugins/simplelightbox/simplelightbox.css')}}?v=<?php echo time(); ?>" rel="stylesheet">

		<!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Ticket Information</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--Row-->
							<div class="row">
								<div class="col-xl-12 col-md-12 col-lg-12">
									<div class="row">
										<div class="col-xl-9 col-lg-12 col-md-12">

											

											<div class="card">
												<div class="card-header border-0 mb-1 d-block">
													<div class="d-sm-flex d-block">
														<div>
															<h4 class="card-title mb-1 fs-22">{{ $ticket->subject }} </h4>
														</div>
														<div class="card-options float-sm-end ticket-status">
															@if($ticket->status == "New")
	
															<span class="badge badge-success">{{ $ticket->status }}</span>
															@elseif($ticket->status == "Re-Open")
	
															<span class="badge badge-teal">{{ $ticket->status }}</span>
															@elseif($ticket->status == "Inprogress")
	
															<span class="badge badge-info">{{ $ticket->status }}</span>
															@elseif($ticket->status == "On-Hold")
	
															<span class="badge badge-warning">{{ $ticket->status }}</span>
															@else
	
															<span class="badge badge-danger">{{ $ticket->status }}</span>
															@endif
	
														</div>
													</div>
													<small class="fs-13"><i class="feather feather-clock text-muted me-1"></i>Last Updated on <span class="text-muted">{{$ticket->updated_at->diffForHumans()}}</span></small>
												</div>
												<div class="card-body pt-2 readmores px-6 mx-1"> 
													<div>
														<span>{!! $ticket->message !!}</span>
	
														
													</div>

												</div>
											</div>
											{{-- Reply Ticket Display --}}
											@if ($ticket->status != 'Closed')

											<div class="card">
												<div class="card-header border-0">
													<h4 class="card-title">Reply Ticket</h4>
													
												</div>
												<form method="POST" action="{{url('admin/ticket/'. $ticket->ticket_id)}}" enctype="multipart/form-data">
													@csrf

													
													<input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
													<div class="card-body status">
														
														<div class="form-group">
															<textarea class="summernote form-control @error('comment') is-invalid @enderror" name="comment" rows="6" cols="100" aria-multiline="true">{{old('comment')}}</textarea>
															@error('comment')

																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
														<div class="form-group">
															<label class="form-label">File</label>
															<input type="file" name="file">
														</div>
														
														<div class="custom-controls-stacked d-md-flex" id="text">
															<label class="form-label mt-1 me-5">Status</label>
															<label class="custom-control form-radio success me-4">
																@if($ticket->status == 'Re-Open')

																<input type="radio" class="custom-control-input hold" name="status" value="Inprogress"
																{{ $ticket->status == 'Re-Open' ? 'checked' : '' }} >
																<span class="custom-control-label">Inprogress</span>
																@elseif($ticket->status == 'Inprogress')

																<input type="radio" class="custom-control-input hold" name="status" value="{{$ticket->status}}"
																{{ $ticket->status == 'Inprogress' ? 'checked' : '' }} >
																<span class="custom-control-label">Inprogress</span>
																@else

																<input type="radio" class="custom-control-input hold" name="status" value="Inprogress"
																{{ $ticket->status == 'New' ? 'checked' : '' }} >
																<span class="custom-control-label">New</span>
																@endif

															</label>
															<label class="custom-control form-radio success me-4">
																<input type="radio" class="custom-control-input hold" name="status" value="Solved" >
																<span class="custom-control-label">Solved</span>
															</label>
															<label class="custom-control form-radio success me-4">
																<input type="radio" class="custom-control-input" name="status" id="onhold" value="On-Hold" @if(old('status') == 'On-Hold') checked @endif {{ $ticket->status == 'On-Hold' ? 'checked' : '' }}>
																<span class="custom-control-label">On-Hold</span>
															</label>
														</div>
													</div>
													
													<div class="card-footer">
														<div class="form-group float-end">
															<input type="submit" class="btn btn-secondary" value="Reply" onclick="this.disabled=true;this.form.submit();">
														</div>
													</div>
												</form>
											</div>
											@else
											@endif
											{{-- End Reply Ticket Display --}}

											{{-- Comments Display --}}
											@if($comments->isNOtEmpty())

											<div class="card  mb-0">
												<div class="card-header border-0">
													<h4 class="card-title">Conversions</h4>
												</div>
												<div class="suuport-convercontentbody" >
													{{ csrf_field() }}
													<div id="spruko_loaddata">
														@include('admin.viewticket.showticketdata')
														
													</div>
												</div>
											</div>
											@endif
											{{-- End Comments Display --}}
											
										</div>

										<div class="col-xl-3 col-lg-6 col-md-12">
											<div class="card">
												<div class="card-header  border-0">
													<div class="card-title">Ticket Information</div>
												</div>
												<div class="card-body pt-2 ps-0 pe-0 pb-0">
													<div class="table-responsive tr-lastchild">
														<table class="table mb-0 table-information">
															<tbody>
																
																<tr>
																	<td>
																		<span class="w-50">Ticket ID</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">#{{ $ticket->ticket_id }}</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<span class="w-50">Ticket Category</span>
																	</td>
																	<td>:</td>
																	<td>
																		@if ($ticket->category_id != null)
																		
																		<span class="font-weight-semibold">{{ $ticket->category->name}}</span>
																		@if ($ticket->status != 'Closed')

																		<a href="javascript:void(0)" data-id="{{$ticket->ticket_id}}" class="p-1 sprukocategory border border-primary br-7 text-white bg-primary ms-2"> <i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Category"></i></a>
																		
																		@endif
																		@else

																		<a href="javascript:void(0)" data-id="{{$ticket->ticket_id}}" class="p-2 sprukocategory border border-primary br-7 text-white bg-primary ms-2" > <i class="feather feather-plus-square" data-toggle="tooltip" data-bs-placement="top" title="Add Category"></i></a>
																		@endif

																	</td>
																</tr>
																
																@if($ticket->priority != null)
																<tr>
																	<td>
																		<span class="w-50">Ticket Priority</span>
																	</td>
																	<td>:</td>
																	<td id="priorityid">
																		@if($ticket->priority == "Low")

																			<span class="badge badge-success-light" >{{ $ticket->priority }}</span>
																			<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																				<i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																			</button>
																		@elseif($ticket->priority == "High")

																			<span class="badge badge-danger-light">{{ $ticket->priority}}</span>
																			<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																				<i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																			</button>
																		@elseif($ticket->priority == "Critical")

																			<span class="badge badge-danger-dark">{{ $ticket->priority}}</span>
																			<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																				<i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																			</button>
																		@else

																			<span class="badge badge-warning-light">{{ $ticket->priority }}</span>
																			<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																				<i class="feather feather-edit-2" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																			</button>
																		@endif
																	</td>
																</tr>
																@else

																<tr>
																	<td>
																		<span class="w-50">Ticket Priority</span>
																	</td>
																	<td>:</td>
																	<td id="priorityid">
																		<button  id="priority" class="p-1 border border-primary br-7 text-white bg-primary ms-2"> 
																			<i class="feather feather-plus" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Change priority" aria-label="Add priority"></i>
																		</button>

																		
																	</td>
																</tr>
																@endif

																<tr>
																	<td>
																		<span class="w-50">Open Date</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{ $ticket->created_at->format('Y-m-d')}}</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<span class="w-50">Status</span>
																	</td>
																	<td>:</td>
																	<td>
																		@if($ticket->status == "New")

																		<span class="badge badge-success">{{ $ticket->status }}</span>
																		@elseif($ticket->status == "Re-Open")

																		<span class="badge badge-teal">{{ $ticket->status }}</span>
																		@elseif($ticket->status == "Inprogress")

																		<span class="badge badge-info">{{ $ticket->status }}</span>
																		@elseif($ticket->status == "On-Hold")

																		<span class="badge badge-warning">{{ $ticket->status }}</span>
																		@else

																		<span class="badge badge-danger">{{ $ticket->status }}</span>
																		@endif

																	</td>
																</tr>
																@if($ticket->replystatus != null)

																<tr>
																	<td>
																		<span class="w-50">Reply status</span>
																	</td>
																	<td>:</td>
																	<td>
																		@if($ticket->replystatus == "Solved")

																		<span class="badge badge-success">{{ $ticket->replystatus }}</span>
																		@elseif($ticket->replystatus == "Unanswered")

																		<span class="badge badge-danger-light">{{ $ticket->replystatus }}</span>
																		@elseif($ticket->replystatus == "Waiting for response")

																		<span class="badge badge-warning">{{ $ticket->replystatus }}</span>
																		@else
																		@endif

																	</td>
																</tr>
																@endif

															</tbody>
														</table>
													</div>
												</div>
												<div class="card-footer  ticket-buttons">
													@if($ticket->status == 'Closed')

														<button class="btn btn-secondary my-1" id="reopen" data-id="{{$ticket->id}}"> <i class="feather feather-rotate-ccw"></i> Reopen</button>
														
														@if($ticket->toassignuser == null)

														<button data-id="{{$ticket->id}}" id="assigned" class="btn btn-primary my-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign" disabled>
															<i class="feather feather-users"></i> Assign
														</button>
														@else

															@if($ticket->toassignuser_id != null)

															<div class="btn-group my-1" role="group" aria-label="Basic outlined example">
																<button  data-id="{{$ticket->id}}"  class="btn btn-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change" disabled>{{$ticket->toassignuser->name}}</button>
																<button  data-id="{{$ticket->id}}" class="btn btn-primary" id="btnremove" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"disabled><i class="fe fe-x" data-id="{{$ticket->id}}"></i></button>
															</div>
															@else

															<button data-id="{{$ticket->id}}" id="assigned" class="btn btn-primary my-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign" disabled>
																<i class="feather feather-users"></i> Assign
															</button>
															@endif
														@endif
													
													@else
														
														@if($ticket->toassignuser == null)

															<button data-id="{{$ticket->id}}" id="assigned" class="btn btn-primary my-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
																<i class="feather feather-users"></i> Assign
															</button>
														@else
															@if($ticket->toassignuser_id != null)

															<div class="btn-group my-1" role="group" aria-label="Basic outlined example">
																<button  data-id="{{$ticket->id}}"  class="btn btn-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">{{$ticket->toassignuser->name}}</button>
																<button  data-id="{{$ticket->id}}" class="btn btn-primary" id="btnremove"><i class="fe fe-x" data-id="{{$ticket->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></button>
															</div>
															@else

															<button data-id="{{$ticket->id}}" id="assigned" class="btn btn-primary my-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
																<i class="feather feather-users"></i> Assign
															</button>
															@endif
														@endif
														
														
													@endif

												</div>
											</div>
											<div class="card">
												<div class="card-header  border-0">
													<div class="card-title">Customer Details</div>
												</div>
												<div class="card-body text-center pt-2 px-0 pb-0 py-0">
													<div class="profile-pic">
														<div class="profile-pic-img mb-2">
															<span class="bg-success dots" data-bs-toggle="tooltip" data-bs-placement="top" title="Online"></span>
															@if ($ticket->user->image == null)

																<img src="{{asset('uploads/profile/user-profile.png')}}"  class="brround avatar-xxl" alt="default">
															@else

																<img class="brround avatar-xxl" alt="{{$ticket->user->image}}" src="{{asset('uploads/profile/'. $ticket->user->image)}}">
															@endif

														</div>
														<a href="#" class="text-dark">
															<h5 class="mb-1 font-weight-semibold2">{{$ticket->user->username}}</h5>
															<small class="text-muted ">{{ $ticket->user->email }}
															</small>
														</a>
													</div>
													<div class="table-responsive text-start tr-lastchild">
														<table class="table mb-0 table-information">
															<tbody>
																
																<tr>
																	<td>
																		<span class="w-50">Mobile Number</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{ $ticket->user->phone}}</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<span class="w-50">Country</span>
																	</td>
																	<td>:</td>
																	<td>
																		<span class="font-weight-semibold">{{ $ticket->user->country }}</span>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											{{-- ticke note --}}
											<div class="card">
												<div class="card-header  border-0">
													<div class="card-title">Ticket Note</div>
													<div class="card-options">
														@if ($ticket->status != 'Closed')

														<a href="javascript:void(0)" class="btn btn-secondary " id="create-new-note"><i class="feather feather-plus"  ></i></a>
														@endif

													</div>
												</div>
												@php $emptynote = $ticket->ticketnote()->get() @endphp
												@if($emptynote->isNOtEmpty())
												<div class="card-body  item-user">
													<div id="refresh">
														@foreach ($ticket->ticketnote()->latest()->get() as $note)

														<div class="alert alert-light-warning ticketnote" id="ticketnote_{{$note->id}}" role="alert">
															@if($note->user_id == Auth::id())

															<a href="javascript:" class="ticketnotedelete" data-id="{{$note->id}}" onclick="deletePost(event.target)">
																<i class="feather feather-x" data-id="{{$note->id}}" ></i>
															</a>
															@endif

															<p class="m-0">{{$note->ticketnotes}}</p>
															<p class="text-end mb-0"><small><i><b>{{$note->users->name}}</b> </i></small></p>
														</div>
													@endforeach

													</div>
												</div>
												@else
												<div class="card-body">
													<div class="text-center ">
														<div class="avatar avatar-xxl empty-block mb-4">
															<svg xmlns="http://www.w3.org/2000/svg" height="50" width="50" viewBox="0 0 48 48"><path fill="#CDD6E0" d="M12.8 4.6H38c1.1 0 2 .9 2 2V46c0 1.1-.9 2-2 2H6.7c-1.1 0-2-.9-2-2V12.7l8.1-8.1z"/><path fill="#ffffff" d="M.1 41.4V10.9L11 0h22.4c1.1 0 2 .9 2 2v39.4c0 1.1-.9 2-2 2H2.1c-1.1 0-2-.9-2-2z"/><path fill="#CDD6E0" d="M11 8.9c0 1.1-.9 2-2 2H.1L11 0v8.9z"/><path fill="#FFD05C" d="M15.5 8.6h13.8v2.5H15.5z"/><path fill="#dbe0ef" d="M6.3 31.4h9.8v2.5H6.3zM6.3 23.8h22.9v2.5H6.3zM6.3 16.2h22.9v2.5H6.3z"/><path fill="#FFD15C" d="M22.8 35.7l-2.6 6.4 6.4-2.6z"/><path fill="#334A5E" d="M21.4 39l-1.2 3.1 3.1-1.2z"/><path fill="#FF7058" d="M30.1 18h5.5v23h-5.5z" transform="rotate(-134.999 32.833 29.482)"/><path fill="#40596B" d="M46.2 15l1 1c.8.8.8 2 0 2.8l-2.7 2.7-3.9-3.9 2.7-2.7c.9-.6 2.2-.6 2.9.1z"/><path fill="#F2F2F2" d="M39.1 19.3h5.4v2.4h-5.4z" transform="rotate(-134.999 41.778 20.536)"/></svg>
														</div>
														<h4 class="mb-2">Don’t have any notes yet</h4>
														<span class="text-muted">Add your notes here</span>
													</div>
												</div>
												@endif
											</div>
											{{-- End ticket note --}}
										</div>
									</div>
								</div>
							</div>

						@endsection

		@section('scripts')
		
		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-ticketview.js')}}?v=<?php echo time(); ?>"></script>

		<!-- DropZone JS -->
		<script src="{{asset('assets/plugins/dropzone/dropzone.js')}}?v=<?php echo time(); ?>"></script>

		<!-- galleryopen JS -->
		<script src="{{asset('assets/plugins/simplelightbox/simplelightbox.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/simplelightbox/light-box.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}?v=<?php echo time(); ?>"></script>	
		<script src="{{asset('assets/js/select2.js')}}?v=<?php echo time(); ?>"></script>

		<!--Showmore Js-->
		<script src="{{asset('assets/js/jquery.showmore.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">

			"use strict";

			// Image Upload
			var uploadedDocumentMap = {}
			Dropzone.options.documentDropzone = {
			  url: '{{url('/admin/ticket/imageupload/' .$ticket->ticket_id)}}',
			  
			  addRemoveLinks: true,
			  
			  headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			  },
			  success: function (file, response) {
				$('form').append('<input type="hidden" name="comments[]" value="' + response.name + '">')
				uploadedDocumentMap[file.name] = response.name
			  },
			  removedfile: function (file) {
				file.previewElement.remove()
				var name = ''
				if (typeof file.file_name !== 'undefined') {
				  name = file.file_name
				} else {
				  name = uploadedDocumentMap[file.name]
				}
				$('form').find('input[name="comments[]"][value="' + name + '"]').remove()
			  },
			  init: function () {
				@if(isset($project) && $project->document)
				  var files =
					{!! json_encode($project->document) !!}
				  for (var i in files) {
					var file = files[i]
					this.options.addedfile.call(this, file)
					file.previewElement.classList.add('dz-complete')
					$('form').append('<input type="hidden" name="comments[]" value="' + file.file_name + '">')
				  }
				@endif
				this.on('error', function(file, errorMessage) {
					if (errorMessage.message) {
						var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
						errorDisplay[errorDisplay.length - 1].innerHTML = errorMessage.message;
					}
				});
			  }
			}

			// Edit Form
			function showEditForm(id) {
				var x = document.querySelector(`#supportnote-icon-${id}`);

				if (x.style.display == "block") {
					x.style.display = "none";
				}
				else {

					x.style.display = "block";
				}
			}

			// Delete Media
			function deleteticket(event) {
                var id  = $(event).data("id");
                let _url = `{{url('/admin/image/delete/${id}')}}`;

                let _token   = $('meta[name="csrf-token"]').attr('content');

				swal({
						title: `{{trans('langconvert.admindashboard.wanttocontinue')}}`,
						text: "{{trans('langconvert.admindashboard.eraserecordspermanently')}}",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
					if (willDelete) {
							$.ajax({
								url: _url,
								type: 'DELETE',
								data: {
								_token: _token
								},
								success: function(response) {
									$("#imageremove"+id).remove();
									$('#imageremove'+ id).remove();
								},
								error: function (data) {
								console.log('Error:', data);
								}
							});
						}
					});
            }
	
			@if($ticket->status != "Closed")
			
			// onhold ticket status 
			let hold = document.getElementById('onhold');
			let text = document.querySelector('.status');
			let hold1 = document.querySelectorAll('.hold');
			let  status = false;

			hold.addEventListener('click',(e)=>{
				if( status == false)
					statusDiv();
					status = true;
			}, false)

			if(document.getElementById('onhold').hasAttribute("checked") == true){
				statusDiv();
				status = true;
			}
			
			function statusDiv(){
				let Div = document.createElement('div')
				Div.setAttribute('class','d-block pt-4');
				Div.setAttribute('id','holdremove');

				let newField = document.createElement('textarea');
				newField.setAttribute('type','text');
				newField.setAttribute('name','note');
				newField.setAttribute('class',`form-control @error('note') is-invalid @enderror`);
				newField.setAttribute('rows',3);
				newField.setAttribute('placeholder','Leave a message for On-Hold');
				newField.innerText = `{{old('note',$ticket->note)}}`;
				Div.append(newField);
				text.append(Div);
			}


			hold1.forEach((element,index)=>{
				element.addEventListener('click',()=>{
					let myobj = document.getElementById("holdremove");
					myobj?.remove();

					status = false
				}, false)
			})

			@endif

				// Variables
				var SITEURL = '{{url('')}}';

				// Csrf field
				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				/*  When user click add note button */
				$('#create-new-note').on('click', function () {
					$('#btnsave').val("create-product");
					$('#ticket_id').val(`{{$ticket->id}}`);
					$('#note_form').trigger("reset");
					$('.modal-title').html("Add Note");
					$('#addnote').modal('show');

				});

				// Note Submit button
				$('body').on('submit', '#note_form', function (e) {
					e.preventDefault();
					var actionType = $('#btnsave').val();
					var fewSeconds = 2;
					$('#btnsave').html('Sending..');
					$('#btnsave').prop('disabled', true);
						setTimeout(function(){
							$('#btnsave').prop('disabled', false);
						}, fewSeconds*1000);
					var formData = new FormData(this);
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/note/create",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,

						success: (data) => {
							$('#note_form').trigger("reset");
							$('#addnote').modal('hide');
							$('#btnsave').html('Save Changes');
							location.reload();
							toastr.success(data.success);

						},
						error: function(data){
							console.log('Error:', data);
							$('#btnsave').html('Save Changes');
						}
					});
				});

				// when user click its get modal popup to assigned the ticket
				$('body').on('click', '#assigned', function () {
					var assigned_id = $(this).data('id');
					$('.select1-show-search').select2({
						dropdownParent: ".sprukosearch",
						minimumResultsForSearch: '',
						placeholder: "Search",
						width: '100%'
					});

					$.post('ticketassigneds/' + assigned_id , function (data) {
						$('#AssignError').html('');
						$('#assigned_id').val(data.assign_data.id);
						$(".modal-title").text('Assign To Agent');
						$('#username').html(data.table_data);
						$('#addassigned').modal('show');
					});

				});
		
				// Assigned Button submit 
				$('body').on('submit', '#assigned_form', function (e) {
					e.preventDefault();
					var actionType = $('#btnsave').val();
					var fewSeconds = 2;
					$('#btnsave').html('Sending..');
					$('#btnsave').prop('disabled', true);
						setTimeout(function(){
							$('#btnsave').prop('disabled', false);
						}, fewSeconds*1000);
					var formData = new FormData(this);
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/assigned/create",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						success: (data) => {
							$('#AssignError').html('');
							$('#assigned_form').trigger("reset");
							$('#addassigned').modal('hide');
							$('#btnsave').html('Save Changes');
							toastr.success(data.success);
							location.reload();
						},
						error: function(data){
							$('#AssignError').html('');
							$('#AssignError').html(data.responseJSON.errors.assigned_user_id);
							$('#btnsave').html('Save Changes');
							
						}
					});	
				});

				// Remove the assigned from the ticket
				$('body').on('click', '#btnremove', function () {
					var asid = $(this).data("id");

					swal({
							title: `Are you sure you want to unassign this agent?`,
							text: "This agent may no longer exist for this ticket.",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
						if (willDelete) {

							$.ajax({
								type: "get",
								url: SITEURL + "/admin/assigned/update/"+asid,
								success: function (data) {
								toastr.error(data.error);
								location.reload();
								
								},
								error: function (data) {
								console.log('Error:', data);
								}
								});

						}
					});



				});

				// Reopen the ticket
				$('body').on('click', '#reopen', function(){
					var reopenid = $(this).data('id');
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/ticket/reopen/" + reopenid,
						data: {
							reopenid:reopenid
						},
						success:function(data){
							
							toastr.success(data.success);
							window.location.reload();
							
						},
						error:function(data){
							toastr.error(data);
						}
					});

				});

				// change priority
				$('#priority').on('click', function () {

					$('#PriorityError').html('');
					$('#btnsave').val("save");
					$('#priority_form').trigger("reset");
					$('.modal-title').html("Priority");
					$('#addpriority').modal('show');
					$('.select2_modalpriority').select2({
						dropdownParent: ".sprukopriority",
						minimumResultsForSearch: '',
						placeholder: "Search",
						width: '100%'
					});


				});

				$('body').on('submit', '#priority_form', function (e) {
					e.preventDefault();
					var actionType = $('#pribtnsave').val();
					var fewSeconds = 2;
					$('#btnsave').html('Sending..');
					var formData = new FormData(this);
					$.ajax({
					type:'POST',
					url: SITEURL + "/admin/priority/change",
					data: formData,
					cache:false,
					contentType: false,
					processData: false,

					success: (data) => {
					$('#PriorityError').html('');
					$('#priority_form').trigger("reset");
					$('#addpriority').modal('hide');
					$('#pribtnsave').html('Save Changes');
					location.reload();
					toastr.success(data.success);
					

					},
					error: function(data){
						$('#PriorityError').html('');
						$('#PriorityError').html(data.responseJSON.errors.priority_user_id);
						$('#btnsave').html('Save Changes');
					}
					});
				});
				// end priority

				// category list
				$('body').on('click', '.sprukocategory', function(){

					var category_id = $(this).data('id');
					$('.modal-title').html("Category");
					$('#CategoryError').html('');
					$('#addcategory').modal('show');

					
					$.ajax({
						type: "get",
						url: SITEURL + "/admin/category/list/" + category_id,
						success: function(data){
							console.log(data)
							$('.select4-show-search').select2({
								dropdownParent: ".sprukosearchcategory",
							});
							$('.subcategoryselect').select2({
								dropdownParent: ".sprukosearchcategory",
							});
							$('#sprukocategory').html(data.table_data);
							$('.ticket_id').val(data.ticket.id);
							
							

							

							
							
						},
						error: function(data){

						}
					});


				});


				// when category change its get the subcat list 
				


				// category submit form
				$('body').on('submit', '#sprukocategory_form', function(e){
					e.preventDefault();
					var actionType = $('#pribtnsave').val();
					var fewSeconds = 2;
					$('#btnsave').html('Sending..');
					var formData = new FormData(this);
					$.ajax({
						type:'POST',
						url: SITEURL + "/admin/category/change",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,

						success: (data) => {
							$('#CategoryError').html('');
							$('#sprukocategory_form').trigger("reset");
							$('#addcategory').modal('hide');
							$('#pribtnsave').html('Save Changes');
							toastr.success(data.success);
							window.location.reload();
							

						},
						error: function(data){
							$('#CategoryError').html('');
							$('#CategoryError').html(data.responseJSON.errors.category);
							$('#btnsave').html('Save Changes');
						}
					});
				})


			// delete note dunction
			function deletePost(event) {
				var id  = $(event).data("id");
				let _url = `{{url('/admin/ticketnote/delete/${id}')}}`;

				let _token   = $('meta[name="csrf-token"]').attr('content');

				swal({
					title: `Are you sure you want to deleteticket this note?`,
					text: "This note may no longer exist for this ticket.",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: _url,
							type: 'DELETE',
							data: {
							_token: _token
							},
							success: function(response) {
								toastr.error(response.error);
								$("#ticketnote_"+id).remove();
							},
							error: function (data) {
								console.log('Error:', data);
							}
						});
					}
				});
			}

			// Scrolling Js Start
			var page = 1;
			$(window).scroll(function() {
				if($(window).scrollTop() + $(window).height() >= $(document).height()) {
					page++;
					loadMoreData(page);
				}
			});

			function loadMoreData(page){
				$.ajax(
				{
					url: '?page=' + page,
					type: "get",
				})
				.done(function(data)
				{
					$("#spruko_loaddata").append(data.html);
					console.log(data.html);
				})
				.fail(function(jqXHR, ajaxOptions, thrownError)
				{
					alert('server not responding...');
				});
			}

			// End Scrolling Js 

			// ReadMore JS
			let readMore = document.querySelectorAll('.readmores')
            readMore.forEach(( element, index)=>{
                if(element.clientHeight <= 200)    {
                    element.children[0].classList.add('end')
                }
                else{
                    element.children[0].classList.add('readMore')
                }
            })
            $(`.readMore`).showmore({
                closedHeight: 60,
                buttonTextMore: 'Read More',
                buttonTextLess: 'Read Less',
                buttonCssClass: 'showmore-button',
                animationSpeed: 0.5
            });

			// ReadMore Js End

			// PURCHASE CODE DETAILS GETS
			

			// Canned Maessage Select2
			$('.cannedmessage').select2({
				minimumResultsForSearch: '',
				placeholder: "Search",
				width: '100%'
			});

			// On Change Canned Messages display
			$('body').on('change', '#cannedmessagess', function(){
				let optval = $(this).val();
				$('.note-editable').html(optval);
				$('.summernote').html(optval);
			})

		</script>

		@endsection

			@section('modal')
		
	  		<!-- Add note-->
			<div class="modal fade"  id="addnote" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" ></h5>
							<button  class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="POST" enctype="multipart/form-data" id="note_form" name="note_form">
							<input type="hidden" name="ticket_id" id="ticket_id">
							@csrf
							
							<div class="modal-body">
								
								<div class="form-group">
									<label class="form-label">Note:</label>
									<textarea class="form-control" rows="4" name="ticketnote" id="note" required></textarea>
									<span id="noteError" class="text-danger alert-message"></span>
								</div>
								
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</a>
								<button type="submit" class="btn btn-secondary" id="btnsave"  >Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End  Add note  -->
	
			<!-- Assigned Tickets-->
			<div class="modal fade sprukosearch"  id="addassigned" role="dialog" aria-hidden="true" >
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" ></h5>
							<button  class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="POST" enctype="multipart/form-data" id="assigned_form" name="assigned_form">
							@csrf
							
							<input type="hidden" name="assigned_id" id="assigned_id">
							@csrf
							<div class="modal-body">
	
								<div class="custom-controls-stacked d-md-flex" >
									<select class="form-control select1-show-search filll" data-placeholder="Select Agent" name="assigned_user_id" id="username" >
	
									</select>
								</div>
								<span id="AssignError" class="text-danger"></span>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-secondary" id="btnsave"  >Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End Assigned Tickets  -->


			<!-- Priority Tickets-->
			<div class="modal fade sprukopriority"  id="addpriority" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" ></h5>
							<button  class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<form method="POST" enctype="multipart/form-data" id="priority_form" name="priority_form">
							@csrf
							
							<input type="hidden" name="priority_id" id="priority_id" value="{{$ticket->id}}">
							@csrf
							<div class="modal-body">
	
								<div class="custom-controls-stacked d-md-flex" >
									<select class="form-control select2_modalpriority" data-placeholder="Select Priority" name="priority_user_id" id="priority" >
										<option label="Select Priority"></option>
										<option value="Critical" {{($ticket->priority == 'Critical')? 'selected' :'' }}>Critical</option>
										<option value="High" {{($ticket->priority == 'High')? 'selected' :'' }}>High</option>
										<option value="Medium" {{($ticket->priority == 'Medium')? 'selected' :'' }}>Medium</option>
										<option value="Low" {{($ticket->priority == 'Low')? 'selected' :'' }}>Low</option>
									</select>	
								</div>
								<span id="PriorityError" class="text-danger"></span>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-secondary" id="pribtnsave" >Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End priority Tickets  -->

			@include('admin.viewticket.modalpopup.categorymodalpopup')

			<!-- PurchaseCode Modals -->
			<div class="modal fade sprukopurchasecode"  id="addpurchasecode" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" ></h5>
							<button  class="close" data-bs-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<input type="hidden" name="purchasecode_id" id="purchasecode_id" value="">
						<div class="modal-body">
							<div class="mb-4">
								<strong>Puchase Code :</strong>
								<span class="purchasecode"></span>
							</div>
							<div id="purchasedata">

							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End PurchaseCode Modals   -->

			@endsection

