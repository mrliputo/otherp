@extends('layouts.main')

@section('title', 'View')

@section('content')
<!--HERE CONTENT -->
<div class="container-fluid">
	<div class="content" id="content">
		<div class="row">
			<div class="col-md-12 node-info">
				<p data-toggle="tooltip" data-placement="right" title="{{ $thisNode->description }}">{{ $thisNode->name }} </p>
				
				@if(count($thisNode->sensors) > 0)
				<p>Sensor: {{ implode(', ', array_column(json_decode($thisNode->sensors), 'name')) }}</p>
				@else
				<p>Sensor: -</p>
				@endif

				<p>Dibuat pada: {{ date("d M Y", strtotime($thisNode->created_at)) }}</p>

				@if($thisNode->access_type == 1)
				<p>Akses: Publik (<a href="{{ route('node.monitor', $thisNode->id) }}">{{ route('node.monitor', $thisNode->id) }}</a>)</p>
				@else
				<p>Akses: Private</p>
				@endif

				@include('includes.message')
			</div>



			<div class="col-md-12 text-center tabs">

				<nav class="nav-left ">
					<div class="nav nav-tabs " id="nav-tab" role="tablist">
						<a class="tab-item nav-item nav-link active" id="pop1-tab" data-toggle="tab" href="#pop1" role="tab" aria-controls="pop1" aria-selected="true">Monitoring</a>
						<a class="tab-item nav-item nav-link" id="pop2-tab" data-toggle="tab" href="#pop2" role="tab" aria-controls="pop2" aria-selected="false">Pengaturan</a>
						<a class="tab-item nav-item nav-link" id="pop3-tab" data-toggle="tab" href="#pop3" role="tab" aria-controls="pop3" aria-selected="false">Sensor</a>
						<a class="tab-item nav-item nav-link" id="pop4-tab" data-toggle="tab" href="#pop4" role="tab" aria-controls="pop4" aria-selected="false">Impor/Ekspor</a>
					</div>
				</nav>

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

					<div class="tab-pane fade" id="pop2" role="tabpanel" aria-labelledby="pop2-tab">
						<div class="col-md-12">
							<form method="post" action="{{ route('node.update', $thisNode->id) }}">
								@csrf

								<div class="setting-item">
									<label>Nama node</label>
									<input type="text" class="form-control" name="name" value="{{ $thisNode->name }}">
								</div>

								<div class="setting-item">
									<label>Deskripsi (opsional)</label>
									<input type="text" class="form-control" name="description" value="{{ $thisNode->description }}">
								</div>

								<div class="setting-item">
									<label>Akses</label>
									<div class="form-check">
										<label class="form-check-label" for="radio1">
											<input type="radio" class="form-check-input" id="radio1" name="access_type" value="1" {{ ($thisNode->access_type == 1) ? 'checked' : '' }}>
											<i class="fa fa-users" aria-hidden="true"></i> Publik
										</label>
									</div>
									<div class="form-check">
										<label class="form-check-label" for="radio2">
											<input type="radio" class="form-check-input" id="radio2" name="access_type" value="2" {{ ($thisNode->access_type == 2) ? 'checked' : '' }}><i class="fa fa-lock" aria-hidden="true"></i> Private
										</label>
									</div>
								</div>

								<button type="submit" class="btn btn-primary">Simpan</button>

							</form>

							<div class="api-div">
								<h3>API Key</h3>
								<div class="card">
									<p class="mb-3">Gunakan API key ini untuk menulis data ke node</p>

									<div class="btn-group mb-3">
										<input disabled type="text" class="form-control wdth3" name="" value="{{ $thisNode->api_key }}">
										<button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="{{ $thisNode->api_key }}" title="Salin key">
											<!-- icon from google's material design library -->
											<svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 24 24"><path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" /></svg>
										</button>
									</div>

									<p>API request untuk menulis data</p>
									@if(count($thisNode->sensors) > 0)
									<div class="api-url">
										GET <span class="str">{{ Request::getSchemeAndHttpHost() }}/write?api_key=<span class="customcode">{{ $thisNode->api_key }}</span>&[kode_sensor]=<span class="customcode">0</span></span>
									</div>
									@else
									<div class="api-url">
										GET <span class="str">https://api.example.com/write?api_key=<span class="customcode">{{ $thisNode->api_key }}</span></span>
									</div>
									@endif

								</div>
							</div>

							<div class="api-div">
								<div class="card card-danger">

									<div class="danger-item mb-3">
										<div class="danger-info float-left">
											<p>Bersihkan data</p>
											<p>Semua data yang telah masuk akan dihapus. Data yang dihapus tidak dapat dikembalikan.</p>
										</div>
										<button class="btn btn-danger float-right"
										onclick="event.preventDefault();
										if(confirm('Anda yakin ingin menghapus semua data sensor di node?')) {
											document.getElementById('clear-form').submit();
										}
										">Bersihkan</button>
										<form id="clear-form" action="{{ route('node.clear', $thisNode->id) }}" method="POST" style="display: none;">
											@csrf
										</form>
									</div>

									<div class="danger-item">
										<div class="danger-info float-left">
											<p>Hapus node</p>
											<p>Node "{{ $thisNode->name }}" akan dihapus. Node yang dihapus tidak dapat dikembalikan.</p>
										</div>
										<button class="btn btn-danger float-right"
										onclick="event.preventDefault();
										if(confirm('Anda yakin ingin menghapus node?')) {
											document.getElementById('delete-form').submit();
										}
										">Hapus</button>
										<form id="delete-form" action="{{ route('node.delete', $thisNode->id) }}" method="POST" style="display: none;">
											@csrf
										</form>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="pop3" role="tabpanel" aria-labelledby="pop3-tab">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">

									<button data-toggle="modal" data-target="#new-sensor-modal" class="btn btn-info {{ (count($thisNode->sensors) > 0 ? 'float-right' : '') }}"><span class="fa fa-plus"></span> Tambah sensor</button>

									<div class="clear"></div>

									@if(count($thisNode->sensors) > 0)
									@foreach($thisNode->sensors as $sensor)
									<form method="post" action="{{ route('sensor.update', $sensor->id) }}">
										@csrf

										<div class="row mb-3">
											<div class="col-md-12 sensor-field-label">
												<label>Kode sensor: {{ $sensor->id }}</label>
											</div>
											<div class="col-md-6 sensor-field-left">
												<input type="text" name="name" class="form-control" placeholder="Nama sensor" value="{{ $sensor->name }}" required>
												<input type="text" name="unit" class="form-control" placeholder="Satuan nilai" value="{{ $sensor->unit }}" required>
											</div>
											<div class="col-md-6 sensor-field-right">
												<div class="caption-alert">
													Threshold sensor
												</div>
												<input type="number" name="threshold" class="form-control sfr-input" placeholder="Batas nilai" value="{{ $sensor->threshold }}" required>
											</div>
											<div class="col-md-6 sensor-field-right">
												<button type="submit" class="btn btn-primary btn-sm">Update</button>
												<button onclick="
												event.preventDefault();
												if(confirm('Anda yakin ingin menghapus sensor?')) {
													document.getElementById('sensor-id').value = '{{ $sensor->id }}';
													document.getElementById('delete-sensor').submit();
												}
												" class="btn btn-danger btn-sm">Hapus</button>
											</div>
										</div>
									</form>
									@endforeach
									
									<form id="delete-sensor" method="post" action="{{ route('sensor.delete') }}">
										<input id="node-id" type="hidden" name="node-id" value="{{ $thisNode->id }}">
										<input id="sensor-id" type="hidden" name="sensor-id">
										@csrf
									</form>

									@endif

									@if(count($thisNode->sensors) > 0)
									<p class="threshold-caption">Kirim peringatan jika sensor melebihi nilai treshold. Isi 0 untuk menonaktifkan fitur ini.</p>
									@endif

								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="pop4" role="tabpanel" aria-labelledby="pop4-tab">
						<div class="col-md-12 pt-3 export">
							<div class="row">

								<div class="col-md-6">
									<p class="label">Impor</p>
									<div class="btn-group mb-3">
										<input type="file" name="" class="form-control">
										<button type="button" class="btn btn-default" >
											<i class="fa fa-upload"></i>
										</button>
									</div>
								</div>

								<div class="col-md-6">
									<p class="label">Ekspor</p>
									<div class="btn-group mb-3">
										<a href="#" class="btn btn-primary">Download CSV</a>
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- The Modal -->
<div class="modal fade" id="new-sensor-modal">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Tambah sensor</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<form method="post" action="{{ route('sensor.post') }}">
				@csrf
				
				<div class="modal-body">
					<div class="setting-item">
						<label>Nama sensor</label>
						<input type="text" class="form-control" name="name" required>
					</div>

					<div class="setting-item">
						<label>Unit</label>
						<input type="text" class="form-control" name="unit" required>
					</div>

					<div class="setting-item">
						<label>Threshold sensor</label>
						<input value="0" type="number" class="form-control" name="threshold" required>
						<p class="caption-alert mt-2">Kirim peringatan jika nilai sensor mencapai threshold. Isi 0 untuk menonaktifkan.</p>
					</div>
					<input type="hidden" name="node_id" value="{{ $thisNode->id }}">
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>

			</form>

		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    /**
 * index.js
 * - All our useful JS goes here, awesome!
 */
 (function ($) {

 	var a = 0;
 	$('#btn-sidebars').on('click', function (e) {
 		e.preventDefault();
 		if (a == 0){
 			a = 1;
 			$('#content').removeClass('content')
 			$('.main-sidebar').removeClass('show-sidebar').addClass('hide-sidebar');
 		}else if (a  == 1) {
 			a = 0;
 			$('#content').addClass('content')
 			$('.main-sidebar').removeClass('hide-sidebar').addClass('show-sidebar');
 		}
 	});

 }(jQuery))
</script>

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
	function copyToClipboard(text, el) {
		var copyTest = document.queryCommandSupported('copy');
		var elOriginalText = el.attr('data-original-title');

		if (copyTest === true) {
			var copyTextArea = document.createElement("textarea");
			copyTextArea.value = text;
			document.body.appendChild(copyTextArea);
			copyTextArea.select();
			try {
				var successful = document.execCommand('copy');
				var msg = successful ? 'Berhasil disalin!' : 'Ups, gagal disaslin!';
				el.attr('data-original-title', msg).tooltip('show');
			} catch (err) {
				console.log('Ups, tidak bisa disalin');
			}
			document.body.removeChild(copyTextArea);
			el.attr('data-original-title', elOriginalText);
		} else {
    // Fallback if browser doesn't support .execCommand('copy')
    window.prompt("Salin key: Ctrl+C atau Command+C, Enter", text);
}
}

$(document).ready(function() {
  // Initialize
  // ---------------------------------------------------------------------

  // Tooltips
  // Requires Bootstrap 3 for functionality
  $('.js-tooltip').tooltip();

  // Copy to clipboard
  // Grab any text in the attribute 'data-copy' and pass it to the 
  // copy function
  $('.js-copy').click(function() {
  	var text = $(this).attr('data-copy');
  	var el = $(this);
  	copyToClipboard(text, el);
  });

  let hash = document.location.hash;
  $(hash + '-tab').trigger('click');
  console.log(hash);

  $(function() {
  	$('[data-toggle="tooltip"]').tooltip()
  })
});
</script>
@endsection
