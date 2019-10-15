@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<!--HERE CONTENT -->
<div class="container-fluid">

	<div class="content-db" id="content">
		<div class="row">
			<div class="col-md-10 offset-md-1 pt-3">

				@include('includes.message')

				<div class="row">
					@if($nodes)
					@foreach($nodes as $node)
					<div class="col-md-3 db-item-wrap">
						<a href="{{ route('node.view', $node->id) }}" class="db-item" data-toggle="tooltip" data-placement="right" title="{{ $node->description }}">
						<div class="db-item-top">
							<p>{{ $node->name }}</p>
						</div>
						<div class="db-item-bottom">
							@if(count($node->sensors) > 0)
							<p>{{ implode(', ', array_column(json_decode($node->sensors), 'name')) }}</p>
							@else
							<p>-</p>
							@endif
						</div>
					</a>
				</div>
				@endforeach
				@endif

				<div class="col-md-3 db-item-wrap">
					<a href="javascript:void(0)" class="db-item" data-toggle="modal" data-target="#newNodeModal">
						<div class="db-item-top db-add-btn">
							<p>+</p>
						</div>
						<div class="db-item-bottom">
							<p>Tambah node baru</p>
						</div>
					</a>
				</div>
			</div>

		</div>
	</div>
</div>
</div>

<!-- The Modal -->
<div class="modal fade" id="newNodeModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Node baru</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<form method="post" action="{{ route('node.post') }}">
				@csrf
				
				<div class="modal-body">
					<div class="setting-item">
						<label>Nama node</label>
						<input type="text" class="form-control" name="name" required>
					</div>

					<div class="setting-item">
						<label>Deskripsi (opsional)</label>
						<input type="text" class="form-control" name="description" required>
					</div>

					<div class="setting-item">
						<label>Akses</label>
						<div class="form-check">
							<label class="form-check-label" for="radio1">
								<input type="radio" class="form-check-input" id="radio1" name="access_type" value="1" checked>
								<i class="fa fa-users" aria-hidden="true"></i> Publik
							</label>
						</div>
						<div class="form-check">
							<label class="form-check-label" for="radio2">
								<input type="radio" class="form-check-input" id="radio2" name="access_type" value="2"><i class="fa fa-lock" aria-hidden="true"></i> Privat
							</label>
						</div>
					</div>

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
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
@endsection
