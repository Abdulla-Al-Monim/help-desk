				<!-- Header-->
				<div class="landingmain-header header">
					<div class="horizontal-main landing-header clearfix sticky">
						<div class="horizontal-mainwrapper container clearfix">
							<div class="d-flex">
								<div class="headerlanding-logo">
									<a class="header-brand" href="{{url('/')}}">
										
										<img src="{{asset('uploads/logo/darklogo/logo.png')}}" class="header-brand-img desktop-lgo"
											alt="logo">

										
										
									
									
									</a>

								</div>
								<nav class="horizontalMenu clearfix order-lg-2 my-auto ms-auto">
									<ul class="horizontalMenu-list custom-ul">
										<li>
											<a href="{{url('/')}}">Home</a>
										</li>
										

										<li>
											<a href="" class="sub-icon">knowledge </a>
										</li>
										

										<li>
											<a href="" class="sub-icon">FAQ</a>
										</li>
										

										<li>
											<a href="">Contact</a>
										</li>

										@if (Auth::guard('customer')->check())
										<li class="dropdown profile-dropdown">
											<a href="#" class="nav-link pe-1 ps-0 py-0 mt-1 leading-none" data-bs-toggle="dropdown">
												<span>
													@if (Auth::guard('customer')->user()->image == null)

													<img src="{{asset('uploads/profile/user-profile.png')}}" class="avatar avatar-md bradius rounded-circle" alt="default">
													@else

													<img src="{{asset('uploads/profile/'.Auth::guard('customer')->user()->image)}}" alt="{{Auth::guard('customer')->user()->image}}" class="avatar avatar-md bradius">
													@endif

												</span>
											</a>
											<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
												<div class="p-3 text-center border-bottom">
													<a href="#" class="text-center user pb-0 font-weight-bold">{{Auth::guard('customer')->user()->username}}</a>
													<p class="text-center user-semi-title">{{Auth::guard('customer')->user()->email}}</p>
												</div>

												<a class="dropdown-item d-flex" href="{{route('client.dashboard')}}">
													<i class="feather feather-grid me-3 fs-16 my-auto"></i>
													<div class="mt-1">Dashboard</div>
												</a>
												<a class="dropdown-item d-flex" href="{{route('client.profile')}}">
													<i class="feather feather-user me-3 fs-16 my-auto"></i>
													<div class="mt-1">Profile</div>
												</a>
												<a class="dropdown-item d-flex" href="{{route('activeticket')}}">
													<i class="ri-ticket-2-line me-3 fs-16 my-auto"></i>
													<div class="mt-1">Tickets</div>
												</a>
												<form id="logout-form" action="{{route('client.logout')}}" method="POST">
													@csrf

													<button type="submit" class="dropdown-item d-flex">
														<i class="feather feather-power me-3 fs-16 my-auto"></i>
													<div class="mt-1">Logout</div>
													</button>
											</form>

											</div>
										</li>
										@endif
										
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<!--Header-->

