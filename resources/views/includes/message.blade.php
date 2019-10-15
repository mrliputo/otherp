@if(count($errors) > 0)
	@foreach($errors->all() as $error)
		<div class="alert alert-danger alert-dismissible">{{ $error }}</div>
	@endforeach
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	{{ session('error') }}
</div>
@endif
