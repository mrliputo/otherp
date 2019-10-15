@extends('layouts.dashboard')

@section('title', 'View')

@section('content')
<!--HERE CONTENT -->
<div class="container-fluid">
	<div id="content" class="col-md-10 offset-md-1">
		<div class="row">
			<div class="col-md-12 node-info">
				<p data-toggle="tooltip" data-placement="left" title="{{ $thisNode->description }}">{{ $thisNode->name }} </p>
				
				@if(count($thisNode->sensors) > 0)
				<p>Sensor: {{ implode(', ', array_column(json_decode($thisNode->sensors), 'name')) }}</p>
				@else
				<p>Sensor: -</p>
				@endif

				<p>Dibuat pada: {{ date("d M Y", strtotime($thisNode->created_at)) }}</p>

				@include('includes.message')
			</div>

			<div class="col-md-12 text-center tabs">

				<div class="tab-content text-left" id="nav-tabContent">

					<div class="tab-pane fade show active" id="pop1" role="tabpanel" aria-labelledby="pop1-tab">
						<div class="row">

							<div class="mb-4 mt-2 filter">
								<div class="row">
									<span class="text-filter">Filter data dari</span>
									<input type="datetime-local" name="" class="form-control form-filter">
									<span class="text-filter">hingga</span>
									<input type="datetime-local" name="" class="form-control form-filter">
									<button class="btn btn-primary btn-sm btn-filter">OK</button>
								</div>
								<div class="row show-per-wrapper">
									<span class="text-filter">Tampilkan per</span>
									<select class="form-control show-per">
										<option>Semua</option>
										<option>10 data</option>
										<option>20 data</option>
										<option>30 data</option>
									</select>
									<button class="btn btn-primary btn-sm btn-filter">OK</button>
								</div>
							</div>

							@if(count($thisNode->sensors) > 0)
							@foreach($thisNode->sensors as $sensor)
							<div class="col-md-6 chart-wrapper">
								<canvas id="line-chart-{{ $sensor->id }}"></canvas>
								<div class="sensor-sum">
									<div class="row">
										<div class="col-md-6 sensor-sum-1">
											<p>Tertinggi: <span id="max-{{ $sensor->id }}"></span> <span class="unit-{{ $sensor->id }}"></span> (<span id="max-{{ $sensor->id }}-date"></span>)</p>
											<p>Terendah: <span id="min-{{ $sensor->id }}"></span> <span class="unit-{{ $sensor->id }}"></span> (<span id="min-{{ $sensor->id }}-date"></span>)</p>
										</div>
										<div class="col-md-6">
											<p>Kode sensor: <span class="monitor-sensor-code">{{ $sensor->id }}</span></p>
											<p>Rata-rata: <span id="avg-{{ $sensor->id }}"></span> <span class="unit-{{ $sensor->id }}"></span></p>
											{{-- <p>Data terakhir: <span id="last-{{ $sensor->id }}"></span> <span id="unit-{{ $sensor->id }}"></span> (<span id="unit-{{ $sensor->id }}-date"></span>)</p> --}}
										</div>
									</div>
								</div>
							</div>
							@endforeach
							@else
							<div class="col-md-12 chart-wrapper">
								<div class=" no-data">
									<p >Tidak ada data</p>
								</div>
							</div>
							@endif

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script>
	@if(count($thisNode->sensors) > 0)
	@foreach($thisNode->sensors as $sensor)

	@php
	$created_at = [];
	$values = [];
	$max = 0;
	$min = 0;
	$avg = 0;
	$maxDate = '-';
	$minDate = '-';

	foreach($sensor->values as $k => $value) {
		$created_at[$k] = date('d-m-Y H:i', strtotime($value['created_at']));
		$values[$k] = $value['value'];

		if(max($values) <= $value['value']) {
			$max = $value['value'];
			$maxDate = $created_at[$k];
		}

		if(min($values) >= $value['value']) {
			$min = $value['value'];
			$minDate = $created_at[$k];
		}
	}

	if(count($values) > 0) {
		$avg = array_sum($values) / count($values);
	}

	@endphp

	$('#max-{{ $sensor->id }}').html('{{ $max }}');
	$('#max-{{ $sensor->id }}-date').html('{{ $maxDate }}');
	$('#min-{{ $sensor->id }}').html('{{ $min }}');
	$('#min-{{ $sensor->id }}-date').html('{{ $minDate }}');
	$('.unit-{{ $sensor->id }}').html('{{ $sensor->unit }}');
	$('#avg-{{ $sensor->id }}').html('{{ number_format($avg, 1, ',', '.') }}');

	new Chart(document.getElementById("line-chart-{{ $sensor->id }}"), {
		type: 'line',
		data: {
			labels: {!! json_encode($created_at) !!},
			datasets: [{ 
				data: {!! json_encode($values) !!},
				label: "{{ $sensor->name }}",
				borderColor: "{{ randColor() }}",
				fill: false
			}
			]
		},
		options: {
			legend: {
				display: false,
			},
			title: {
				display: true,
				text: '{{ $sensor->name }} ({{ $sensor->unit }})'
			}
		}
	});
	@endforeach
	@endif
</script>

<script type="text/javascript">

$(document).ready(function() {
  // Initialize
  // ---------------------------------------------------------------------

  // Tooltips
  // Requires Bootstrap 3 for functionality
  $('.js-tooltip').tooltip();
  $(function() {
  	$('[data-toggle="tooltip"]').tooltip()
  })
});
</script>
@endsection
