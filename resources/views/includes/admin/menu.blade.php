							<!--app header-->
							<div class="app-header header header-main">
								<div class="container-fluid">
									<div class="d-flex">
										<a class="header-brand" href="">
										

										<img src="{{asset('uploads/logo/logo/logo-white.png')}}" class="header-brand-img dark-logo" alt="logo">
										
		
										
		
										<img src="{{asset('uploads/logo/icon/icon.png')}}" class="header-brand-img mobile-logo" alt="mobile-logo">
										
										
										
		
										<img src="{{asset('uploads/logo/darkicon/icon-white.png')}}" class="header-brand-img darkmobile-logo" alt="mobile-dark-logo">
										
										</a>
										<div class="app-sidebar__toggle" data-bs-toggle="sidebar">
											<a class="open-toggle" href="#">
												<i class="feather feather-menu"></i>
											</a>
											<a class="close-toggle" href="#">
												<i class="feather feather-x"></i>
											</a>
										</div>
										<div class="header-buttons-main">
											<a class="btn btn-outline-light header-buttons text-center" href="{{url('/admin/createticket')}}"><i class="fa fa-paper-plane-o pe-lg-2"></i><span class="d-m-none">Create Ticket</span></a>
											<a class="btn btn-outline-light header-buttons text-center visitsite ms-2" href="{{route('home')}}" target="_blank"><i class="fe fe-home pe-lg-2"></i><span class="d-m-none">Home</span></a>
												
										</div><!-- SEARCH -->
										<div class="d-flex order-lg-2 my-auto ms-auto dropdown-container align-items-center">
											
											<div class="dropdown header-flags">
												<a href="#" class="text-capitalize dropdown-toggle" data-bs-toggle="dropdown">
													<span class="">Language </span>
												</a>
												<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated text-uppercase">
												

														<a href="" class="dropdown-item d-flex fs-13">
														<span class="">English</span>
														</a>
												
													
												</div>
											</div>
											
											<div class="dropdown header-fullscreen">
												<a class="nav-link icon full-screen-link">
													<i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
													<i class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
												</a>
											</div>
											
											
											<div class="dropdown profile-dropdown">
												<a href="#" class="nav-link pe-1 ps-0 leading-none" data-bs-toggle="dropdown">
													<span>
														

															<img src="{{asset('uploads/profile/user-profile.png')}}" class="avatar avatar-md bradius rounded-circle" alt="default">
														

													</span>
												</a>
												<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
													<div class="p-3 text-center border-bottom">
														<a href="{{url('/admin/profile')}}" class="text-center user pb-0 font-weight-bold">
														<p class="text-center user-semi-title">Super Admin</p>
														
													</div>
													<a class="dropdown-item d-flex" href="{{url('/admin/profile')}}">
														<i class="feather feather-user me-3 fs-16 my-auto"></i>
														<div class="mt-1">Profile</div>
													</a>
													<form id="logout-form" action="{{ route('logout') }}" method="POST">
														@csrf

														<button type="submit" class="dropdown-item d-flex">
															<i class="feather feather-power me-3 fs-16 my-auto"></i>
															<div class="mt-1" >Logout</div>
														</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--/app header-->	
