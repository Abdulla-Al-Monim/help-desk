
												@foreach ($comments as $comment)
												{{--Admin Reply status--}}
													@if($comment->user_id != null)
														@if ($loop->first)

															<div class="card-body">
																<div class="d-sm-flex">
																	<div class="d-flex me-3">
																		<a href="#">
																			@if ($comment->user != null)
																			@if ($comment->user->image == null)

																			<img src="{{asset('uploads/profile/user-profile.png')}}"  class="media-object brround avatar-lg" alt="default">
																			@else

																			<img class="media-object brround avatar-lg" alt="{{$comment->user->image}}" src="{{asset('uploads/profile/'. $comment->user->image)}}">
																			@endif
																			@else

																			<img src="{{asset('uploads/profile/user-profile.png')}}"  class="media-object brround avatar-lg" alt="default">
																			@endif

																		</a>
																	</div>
																	<div class="media-body">
																		@if($comment->user != null)

																		<h5 class="mt-1 mb-1 font-weight-semibold">{{ $comment->user->name }} {{$comment->user->role->role_name	}}</h5>
																		@else

																		<h5 class="mt-1 mb-1 font-weight-semibold text-muted">~</h5>
																		@endif
																		
																		<small class="text-muted"><i class="feather feather-clock"></i> {{ $comment->created_at->diffForHumans() }}</small>
																		<div class="fs-13 mb-0 mt-1">
																			{!! $comment->comment !!}
																		</div>
																		<div class="editsupportnote-icon animated" id="supportnote-icon-{{$comment->id}}">
																			<form action="{{url('admin/ticket/editcomment/'.$comment->id)}}" method="POST">
																				@csrf

																				<textarea class="editsummernote" name="editcomment"> {{$comment->comment}}</textarea>
																			<div class="btn-list mt-1">
																				<input type="submit" class="btn btn-secondary" onclick="this.disabled=true;this.form.submit();" value="Update">
																			</div>
																			</form>
																		</div>
                                                                        
																		

																	</div>
																	@if (Auth::id() == $comment->user_id)
																	@if($comment->display != null)

																	<div class="ms-auto">
																		<span class="action-btns supportnote-icon" onclick="showEditForm('{{$comment->id}}')"><i class="feather feather-edit text-primary fs-16"></i></span>
																	</div>
																    @endif
																    @endif

																</div>
															</div>
														@else

															<div class="card-body">
																<div class="d-sm-flex">
																	<div class="d-flex me-3">
																		<a href="#">
																			@if($comment->user != null)
																			@if ($comment->user->image == null)

																			<img src="{{asset('uploads/profile/user-profile.png')}}"  class="media-object brround avatar-lg" alt="default">
																			@else

																			<img class="media-object brround avatar-lg" alt="{{$comment->user->image}}" src="{{asset('uploads/profile/'. $comment->user->image)}}">
																			@endif
																			@else

																			<img src="{{asset('uploads/profile/user-profile.png')}}"  class="media-object brround avatar-lg" alt="default">
																			@endif

																		</a>
																	</div>
																	<div class="media-body">
																		@if($comment->user != null)

																		<h5 class="mt-1 mb-1 font-weight-semibold">{{ $comment->user->name }}{{$comment->user->role->role_name}}</span></h5>
																		@else

																		<h5 class="mt-1 mb-1 font-weight-semibold text-muted">~</h5>
																		@endif

																		<small class="text-muted"><i class="feather feather-clock"></i> {{ $comment->created_at->diffForHumans() }}</small>
																		<div class="fs-13 mb-0 mt-1">
																			{!! $comment->comment !!}
																		</div>
																		
																	</div>
																</div>
															</div>
														@endif
														{{--Admin Reply status end--}}

														{{--Customer Reply status--}}
														@else

															<div class="card-body">
																<div class="d-sm-flex">
																	<div class="d-flex me-3">
																		<a href="#">
																			@if ($comment->user->image == null)

																			<img src="{{asset('uploads/profile/user-profile.png')}}"  class="media-object brround avatar-lg" alt="default">
																			@else

																			<img class="media-object brround avatar-lg" alt="{{$comment->cust->image}}" src="{{asset('uploads/profile/'. $comment->cust->image)}}">
																			@endif

																		</a>
																	</div>
																	<div class="media-body">
																		<h5 class="mt-1 mb-1 font-weight-semibold">{{ $comment->user->username }}<span class="badge badge-danger-light badge-md ms-2">{{ $comment->user->userType }}</span></h5>
																		<small class="text-muted"><i class="feather feather-clock"></i> {{ $comment->created_at->diffForHumans() }}</small>
																		<div class="fs-13 mb-0 mt-1">
																			{!! $comment->comment !!}

																		</div>
																		
																	</div>
																</div>
															</div>
															
														@endif
													{{--Customer Reply status end--}}
												@endforeach
												