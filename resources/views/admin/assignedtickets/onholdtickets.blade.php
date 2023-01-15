?v=<?php echo time(); ?>@extends('layouts.adminmaster')

		@section('styles')

		<!-- INTERNAL Data table css -->
		<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />

		<!-- INTERNAL Sweet-Alert css -->
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />


		@endsection

							@section('content')

							<!--Page header-->
							<div class="page-header d-xl-flex d-block ">
								<div class="page-leftheader">
									<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">On-Hold Tickets</span></h4>
								</div>
							</div>
							<!--End Page header-->

							<!--On-Hold Tickets List -->
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-header border-0">
										<h4 class="card-title">On-Hold Tickets</h4>
									</div>
									<div class="card-body" >
										<div class="table-responsive spruko-delete">
											

											<table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="onholdtickets">
												<thead >
													<tr >
														<th >Id</th>
														<th >Si No</th>
														<th >#ID</th>
														<th >User</th>
														<th >Tilte</th>
														<th >Priority</th>
														<th >Category</th>
														<th >Date</th>
														<th >Status</th>
														<th >Assign to</th>
														<th >Last reply</th> 
														<th >Action</th>
													</tr>
												</thead>
												<tbody >
													
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- End On-Hold Tickets List -->

							@endsection


		@section('scripts')

		<!-- INTERNAL Data tables -->
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>

		<!-- INTERNAL Index js-->
		<script src="{{asset('assets/js/support/support-sidemenu.js')}}"></script>
		<script src="{{asset('assets/js/support/support-admindash.js')}}"></script>
		<script src="{{asset('assets/js/select2.js')}}"></script>

		<!-- INTERNAL Sweet-Alert js-->
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
		
		<script type="text/javascript">
			"use strict";

			(function($)  {

				// Variables
				var SITEURL = '{{url('')}}';

				// Csrf Field
				$.ajaxSetup({
					headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				// DataTable
				var table = $('#onholdtickets').DataTable({
					processing:true,
					serverSide:true,
					ajax: {
						url: "{{ url('admin/onholdtickets') }}"
					},
					columns: [
						{data: 'id', name: 'id', 'visible': false},
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
						
						{ data: 'ticket_id', name: 'ticket_id' },
						{ data: 'user_id', name: 'user_id' },
						
						{ data: 'subject', name: 'subject' },
						{ data: 'priority', name: 'priority' },
						{ data: 'category_id', name: 'category_id' },
						{ data: 'created_at', name: 'created_at' },
						{ data: 'status', name: 'status' },
						{ data: 'toassignuser_id', name: 'toassignuser_id' },
						{ data: 'last_reply', name: 'last_reply' },
						{data: 'action', name: 'action', orderable: false},
					],
					order:[],
					responsive: true,
					drawCallback: function () {
						var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
						var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
							return new bootstrap.Tooltip(tooltipTriggerEl)
						});
						$('.form-select').select2({
							minimumResultsForSearch: Infinity,
							width: '100%'
						});
						$('#customCheckAll').prop('checked', false);
					},
				});

				// TICKET DELETE SCRIPT
				$('body').on('click', '#show-delete', function () {
					var _id = $(this).data("id");
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
								type: "get",
								url: SITEURL + "/admin/delete-ticket/"+_id,
								success: function (data) {
									var oTable = $('#onholdtickets').dataTable();
									oTable.fnDraw(false);
									toastr.error(data.error);
								},
								error: function (data) {
								console.log('Error:', data);
								}
							});
						}
					});

				});

				//Mass Delete 
				$('body').on('click', '#massdelete', function () {
					var id = [];
					$('.checkall:checked').each(function(){
						id.push($(this).val());
					});
					if(id.length > 0){
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
									url:"{{ url('admin/ticket/delete/tickets')}}",
									method:"GET",
									data:{id:id},
									success:function(data)
									{
										$('#onholdtickets').DataTable().ajax.reload();
										toastr.error(data.error);		
									},
									error:function(data){

									}
								});
							}
						});			
					}else{
						toastr.error('{{trans('langconvert.functions.checkboxselect')}}');
					}
				});

				// When user click its get modal popup to assigned the ticket
				$('body').on('click', '#assigned', function () {

					var assigned_id = $(this).data('id');
					$('.select2_modalassign').select2({
						dropdownParent: ".sprukosearch",
						minimumResultsForSearch: '',
						placeholder: "Search",
						width: '100%'
					});
					
					$.get('assigned/' + assigned_id , function (data) {
						$('#AssignError').html('');
						$('#assigned_id').val(data.assign_data.id);
						$(".modal-title").text('{{trans('langconvert.admindashboard.assigntoagent')}}');
						$('#username').html(data.table_data);
						$('#addassigned').modal('show');
					});
				});

				// Assigned Submit button 
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
							var oTable = $('#onholdtickets').dataTable();
							oTable.fnDraw(false);
							toastr.success(data.success);
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
						title: `{{trans('langconvert.admindashboard.agentremove')}}`,
						text: "{{trans('langconvert.admindashboard.agentremove1')}}",
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
								var oTable = $('#onholdtickets').dataTable();
								oTable.fnDraw(false);
								toastr.error(data.error);
								},
								error: function (data) {
								console.log('Error:', data);
								}
							});

						}
					});
				});
			
				// Checkbox checkall
				$('#customCheckAll').on('click', function() {
					$('.checkall').prop('checked', this.checked);
				});

			})(jQuery);

		</script>

		@endsection

		@section('modal')

		@include('admin.modalpopup.assignmodal')

		@endsection