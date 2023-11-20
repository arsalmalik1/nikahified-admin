@section('page-title', __tr('Payment Checkout'))
@section('head-title', __tr('Payment Checkout'))
@section('keywordName', __tr('Payment Checkout'))
@section('keyword', __tr('Payment Checkout'))
@section('description', __tr('Payment Checkout'))
@section('keywordDescription', __tr('Payment Checkout'))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h5 class="h5 mb-0 text-gray-200">
		<span class="text-primary"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
		<?= __tr('Payment Checkout') ?></h5>
</div>

<!-- payment checkout container -->
<div class="container-fluid">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-body">
				<h1 class="text-3xl md:text-5xl font-extrabold text-center uppercase mb-12 bg-gradient-to-r from-indigo-400 via-purple-500 to-indigo-600 bg-clip-text text-transparent transform -rotate-2">Make A Payment</h1>
				@if (session()->has('success'))
					<div class="alert alert-success">
						{{ session()->get('success') }}
					</div>
				@endif
				<form action="{{ route('user.checkout-process') }}" method="POST" id="card-form">
					@csrf
					{{--<div class="mb-3">
						<label for="card-name" class="inline-block font-bold mb-2 uppercase text-sm tracking-wider">Your name</label>
						<input type="text" name="name" id="card-name" class="border-2 border-gray-200 h-11 px-4 rounded-xl w-full">
					</div>
					<div class="mb-3">
						<label for="email" class="inline-block font-bold mb-2 uppercase text-sm tracking-wider">Email</label>
						<input type="email" name="email" id="email" class="border-2 border-gray-200 h-11 px-4 rounded-xl w-full">
					</div>--}}
					<input type="hidden" name="plan_id" value="{{ $planId }}" />
					<div class="mb-3">
						<label for="card" class="inline-block font-bold mb-2 uppercase text-sm tracking-wider">Card details</label>

						<div class="bg-gray-100 p-6 rounded-xl">
							<div id="card"></div>
						</div>
					</div>
					<button type="submit" class="w-full bg-indigo-500 uppercase rounded-xl font-extrabold text-white px-6 h-12">Pay 👉</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- / liked people container -->
<script src="https://js.stripe.com/v3/"></script>
<script>
	let stripe = Stripe('pk_test_51O07g9HHpxbwH6cFn5rtzfYlDtQqMlvhfsd7bTkKrJj0W106vBhZ4UmY0n7DxnZa9fARrnknxVW7ThEAGYRlxnkW00PkhK7a2v')
	const elements = stripe.elements()
	const cardElement = elements.create('card', {
		style: {
			base: {
				fontSize: '16px'
			}
		}
	})
	const cardForm = document.getElementById('card-form')
	const cardName = document.getElementById('card-name')
	cardElement.mount('#card')
	cardForm.addEventListener('submit', async (e) => {
		e.preventDefault()
		const { paymentMethod, error } = await stripe.createPaymentMethod({
			type: 'card',
			card: cardElement,
			billing_details: {}
		})
		if (error) {
			console.log(error)
		} else {
			let input = document.createElement('input')
			input.setAttribute('type', 'hidden')
			input.setAttribute('name', 'payment_method')
			input.setAttribute('value', paymentMethod.id)
			cardForm.appendChild(input)
			cardForm.submit()
		}
	})
</script>