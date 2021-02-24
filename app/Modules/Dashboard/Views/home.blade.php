@extends('layouts.admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

@section('content')
<div class="card">
	<div class="card-header">
		Dashboard
	</div>
	<div class="card-body" style="margin-top:0px; border-top: 1px solid lightgray;">
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-4 col-md-4" style="float:left;">
					<h6 style="font-weight: 600;">Activity Stream</h6>
					<div class="col-lg-12 text-center" style="border: 1px solid lightgray; height: 510px; border-radius: 5px; padding: 5px;">
						<span class="text-center" style="font-size: 13px;">
							No activity in the last 30 days.
						</span>
					</div>
				</div>
				<div class="col-lg-4 col-md-4" style="float:left;">
					<h6 style="font-weight: 600;">Goal Progress</h6>
					<div class="col-lg-12" style="border: 1px solid lightgray; height: 210px; border-radius: 5px;">
					</div>
				</div>
				<div class="col-lg-4 col-md-4" style="float:left;">
					<h6 style="font-weight: 600;">Current Goal Outlook</h6>
					<div class="col-lg-12" style="border: 1px solid lightgray; height: 210px; border-radius: 5px; padding-top: 3%;">
						<canvas id="pie-chart" width="800" height="450"></canvas>
					</div>
				</div>
				<div class="col-lg-8 col-md-8" style="float:right;">
					@if(Session::has('activeCompany') && Session::has('activeCompany'))
					@if(Session::get('currentEmployee')->id == Session::get('activeEmployee')->id)
					<h6 style="font-weight: 600; margin-top: 25px;">Outstanding Items</h6>
					<div class="col-lg-12" style="border: 1px solid lightgray; height: 250px; border-radius: 5px; padding-top: 10px;">
						<ul class="nav nav-tabs">
							<li class="active borderedLi">
								<a data-toggle="tab" href="#todos" style="margin: 10px;">
									To-Dos
								</a>
							</li>
							<li>
								<a data-toggle="tab" href="#reviewForms" style="margin: 10px;">
									Review Forms
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="todos" class="tab-pane fade in active show">
							</div>
							<div id="reviewForms" class="tab-pane fade in">
								<div class="table-responsive">
									<table id="users-list-datatable" class="table">
										<thead>
											<tr>
												<th></th>
											</tr>
										</thead>
										<tbody>
											@foreach($formsINeedToDo as $key => $form)
											<tr>
												<td>
													<a href="/admin/reviews/form/{{$form->id}}">
														{{$form->form_title}} of {{$form->signer_first_name}} {{$form->signer_last_name}}
													</a>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					@endif
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('page-scripts')
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css">
<style>
	.picker__holder {
		margin-top:-100px;
	}
	.borderedLi {
		border-top: 1px solid lightgray;
		border-right: 1px solid lightgray;
		border-left: 1px solid lightgray;
		border-radius: 5px;
	}
</style>
<script type="text/javascript">
	$(document).on('click', 'li', function () {
		$('li').removeClass('borderedLi');
		$(this).addClass('borderedLi');
	});
	window.onload = function() {
		let statuses = {!! json_encode($statuses) !!};
		let statusCounts = {!! json_encode($statusCounts) !!};
		new Chart(document.getElementById("pie-chart"), {
			type: 'pie',
			data: {
				labels: statuses,
				datasets: [{
					label: "Goals",
					backgroundColor: ["#35AA47", "#FAB613","#F1634F","#000000","#404041"],
					data: statusCounts
				}]
			},
			options: {
				title: {
					display: false,
					text: 'Goal Outlook'
				},
				legend: {
				    position: "right",
				    align: "middle"
				},
			}
		});
	}
</script>