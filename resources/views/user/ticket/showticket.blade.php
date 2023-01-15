@extends('layouts.usermaster')

		@section('styles')

		<!-- INTERNAl Summernote css -->
		<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote.css')}}?v=<?php echo time(); ?>">

		<!-- INTERNAl Dropzone css -->
		<link href="{{asset('assets/plugins/dropzone/dropzone.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- GALLERY CSS -->
		<link href="{{asset('assets/plugins/simplelightbox/simplelightbox.css')}}?v=<?php echo time(); ?>" rel="stylesheet">

		@endsection

							@section('content')

							<!-- Section -->
							<section>
								<div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
									<div class="header-text mb-0">
										<div class="container ">
											<div class="row text-white">
												<div class="col">
													<h1 class="mb-0">Ticket View</h1>
												</div>
												<div class="col col-auto">
													<ol class="breadcrumb text-center">
														<li class="breadcrumb-item">
															<a href="#" class="text-white-50">Home</a>
														</li>
														<li class="breadcrumb-item active">
															<a href="#" class="text-white">Ticket View</a>
														</li>
													</ol>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<!-- Section -->

							<!--Ticket Show-->
							<section>
								<div class="cover-image sptb">
									<div class="container ">
										<div class="row">
											<div class="col-xl-4">
												<div id="scroll-stickybar" class="w-100 pos-sticky-scroll">
													<div class="card">
														<div class="card-body text-center item-user">
															<div class="profile-pic">
																<div class="profile-pic-img mb-2">
																	<span class="bg-success dots" data-bs-toggle="tooltip" data-placement="top" title=""
																		data-bs-original-title="online"></span>
																	@if (Auth::user()->image == null)

																	<img src="{{asset('uploads/profile/user-profile.png')}}" class="brround avatar-xxl"
																		alt="default">
																	@else

																	<img class="brround avatar-xxl" alt="{{Auth::user()->image}}"
																		src="{{asset('uploads/profile/'.Auth::user()->image)}}">
																	@endif

																</div>
																<a href="#" class="text-dark">
																	<h5 class="mb-1 font-weight-semibold2">{{Auth::user()->username}}</h5>
																</a>
																<small class="text-muted ">{{Auth::user()->email}}</small>
															</div>
														</div>
													</div>

													

													<div class="card">
														<div class="card-header  border-0">
															<div class="card-title">Ticket Information</div>
															<input type="hidden" name="" data-id="{{$ticket->id}}" id="ticket">
															<div class="float-end ms-auto"><a href="{{route('client.ticket')}}" class="btn btn-white btn-sm ms-auto"><i class="fa fa-paper-plane-o me-2 fs-14"></i>Create ticket</a></div>
														</div>
														<div class="card-body pt-2 px-0 pb-0">
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

																				<span class="font-weight-semibold">{{ $ticket->category->name }}</span>
																				@endif

																			</td>
																		</tr>
																		

																		

																		<tr>
																			<td>
																				<span class="w-50">Open Date</span>
																			</td>
																			<td>:</td>
																			<td>
																				<span class="font-weight-semibold">{{
																					$ticket->created_at->format('D-M-Y')}}</span>
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
													</div>
												</div>
											</div>

											<div class="col-xl-8">
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
														<small class="fs-13"><i class="feather feather-clock text-muted me-1"></i>Last Updated <span class="text-muted">{{$ticket->updated_at->diffForHumans()}}</span></small>
													</div>
													<div class="card-body readmores pt-2 px-6 mx-1"> 
														<div>
															<span>{!! $ticket->message !!}</span>
															<div class="row galleryopen">
																

															</div>
														</div>
													</div>
												</div>
									{{-- Reply Ticket Display --}}
									@if ($ticket->status == 'Closed')
										

									<div class="card">
										<form method="POST" action="{{url('customer/closed/' .$ticket->ticket_id)}}">
											@csrf
											

											<input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
											<div class="card-body">
												<p>This ticket is closed. Do you want to reopen it?
													<input type="submit" class="btn btn-secondary" value="Re-Open"
														onclick="this.disabled=true;this.form.submit();">
												</p>
											</div>
										</form>
									</div>
									@elseif ($ticket->status == 'On-Hold')
								
												<div class="alert alert-light-warning note" role="alert">
													<p class="m-0"><b>Note:-</b> {{$ticket->note}}</p>
												</div>
									@else

												<div class="card">
													<div class="card-header border-0">
														<h4 class="card-title">Reply Ticket</h4>
													</div>
													<form method="POST" action="{{route('client.comment', $ticket->ticket_id)}}"
														enctype="multipart/form-data">
														@csrf
														

														<input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
														<div class="card-body">
															<textarea class="summernote form-control  @error('comment') is-invalid @enderror"
																name="comment" rows="6" cols="100" aria-multiline="true"></textarea>
																
															@error('comment')

															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
															@enderror

															

															<div class="form-group mt-3">
																<label class="form-label">Upload File</label>
																
															</div>
															

															<div class="custom-controls-stacked d-md-flex mt-3">
																<label class="form-label mt-1 me-5">Status</label>
																<label class="custom-control form-radio success me-4">
																	@if($ticket->status == 'Re-Open')
																	
																	<input type="radio" class="custom-control-input" name="status"
																		value="Inprogress" {{ $ticket->status == 'Re-Open' ? 'checked' : '' }}>
																	<span class="custom-control-label">Inprogress</span>
																	@elseif($ticket->status == 'Inprogress')

																	<input type="radio" class="custom-control-input" name="status"
																		value="{{$ticket->status}}" {{ $ticket->status == 'Inprogress' ? 'checked' :
																	'' }}>
																	<span class="custom-control-label">Leave as current</span>
																	@else

																	<input type="radio" class="custom-control-input" name="status"
																		value="{{$ticket->status}}" {{ $ticket->status == 'New' ? 'checked' : '' }}>
																	<span class="custom-control-label">New</span>
																	@endif

																</label>
																<label class="custom-control form-radio success">
																	<input type="radio" class="custom-control-input" name="status" value="Closed">
																	<span class="custom-control-label">Solved</span>
																</label>
															</div>
														</div>
														<div class="card-footer">
															<div class="form-group float-end">
																<input type="submit" class="btn btn-secondary" value="Reply"
																onclick="this.disabled=true;this.form.submit();">
															</div>
														</div>
													</form>
												</div>
											
									@endif

												<!---- End Reply Ticket Display ---->

												@if($comments->isNotEmpty())

												<!---- Comments Display ---->

												<div class="card support-converbody">
													<div class="card-header border-0">
														<h4 class="card-title">Conversions</h4>
													</div>
													<div id="spruko_loaddata">

														@include('user.ticket.showticketdata')

													</div>
												</div>

												<!--- End Comments Display -->
													@endif

											</div>
										</div>
									</div>
								</div>
							</section>
							<!--Ticket Show-->

							@endsection

		@section('scripts')


		<!-- INTERNAL Vertical-scroll js-->
		<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Summernote js  -->
		<script src="{{asset('assets/plugins/summernote/summernote.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-ticketview.js')}}?v=<?php echo time(); ?>"></script>

		<!-- INTERNAL DropZone js-->
		<script src="{{asset('assets/plugins/dropzone/dropzone.js')}}?v=<?php echo time(); ?>"></script>

		<!-- GALLERY JS -->
		<script src="{{asset('assets/plugins/simplelightbox/simplelightbox.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/simplelightbox/light-box.js')}}?v=<?php echo time(); ?>"></script>

		<!--Showmore Js-->
		<script src="{{asset('assets/js/jquery.showmore.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/jquerysticky/jquery-sticky/jquery-sticky.js')}}?v=<?php echo time(); ?>"></script>
		<script src="{{asset('assets/plugins/jquerysticky/jquery-sticky.js')}}?v=<?php echo time(); ?>"></script>

		<script type="text/javascript">
            "use strict";
			
			(function($){

				// Delete Media
				$('body').on('click', '.imgdel', function () {
					var product_id = $('.imgdel').data("id");
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
								type: "DELETE",
								url: SITEURL + "/customer/image/delete/"+product_id,
								success: function (data) {
									//  table.draw();
									$('#imageremove'+ product_id).remove();
								},
								data: {
								"_token": "{{ csrf_token() }}",

								},
								error: function (data) {
									console.log('Error:', data);
								}
							});
						}
					});			
				});
			})(jQuery);


			

			// Scrolling Effect
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
				})
				.fail(function(jqXHR, ajaxOptions, thrownError)
				{
					alert('server not responding...');
				});
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

			// Readmore
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

		</script>

		@endsection