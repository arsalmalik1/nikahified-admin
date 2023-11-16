@section('page-title', __tr('Payment Plans'))
@section('head-title', __tr('Payment Plans'))
@section('keywordName', __tr('Payment Plans'))
@section('keyword', __tr('Payment Plans'))
@section('description', __tr('Payment Plans'))
@section('keywordDescription', __tr('Payment Plans'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h5 class="h5 mb-0 text-gray-200">
		<span class="text-primary"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
		<?= __tr('Payment Plans') ?></h5>
</div>

<style>
	.card {
		border:none;
		padding: 10px 50px;
		background-color: #fff;
		color: #000;
	}

	.card-title {
		font-weight: bold;
	}

	.card::after {
		position: absolute;
		z-index: -1;
		opacity: 0;
		-webkit-transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
		transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
	}

	.card:hover {
		transform: scale(1.02, 1.02);
		-webkit-transform: scale(1.02, 1.02);
		backface-visibility: hidden;
		will-change: transform;
		box-shadow: 0 1rem 3rem rgba(0,0,0,.75) !important;
	}

	.card:hover::after {
		opacity: 1;
	}

	.card-body{
		min-height: 300px;
	}

	.card-body-text{
		min-height: 250px;
	}

</style>

<!-- payment plans container -->
<div class="container-fluid">
	@if(!__isEmpty($planData))
	<div class="row row-cols-sm-1 row-cols-md-3 row-cols-lg-6 row-cols-xl-8">
		@foreach($planData as $plan)
			<div class="col-lg-4 col-md-12 mb-4">
				<div class="card h-100 shadow-lg">
					<div class="card-body">
						<div>
							<h5 class="card-title text-center">{{ $plan['title'] }}</h5>
							<br>
							<h2 class="text-center"><strong>${{$plan['price']}}</strong></h2>
							<br>
							<div class="card-body-text">
								<?= html_entity_decode($plan['description']) ?>
							</div>
							<div class="text-center">
								<button class="btn btn-outline-primary btn-lg align-center" style="border-radius:10px">Select</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	@else
	<!-- info message -->
	<div class="alert alert-info">
		<?= __tr('No payment plan found.') ?>
	</div>
	<!-- / info message -->
	@endif
</div>
<!-- / liked people container -->