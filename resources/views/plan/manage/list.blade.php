@section('page-title', __tr("Manage Plans"))
@section('head-title', __tr("Manage Plans"))
@section('keywordName', strip_tags(__tr("Manage Plans")))
@section('keyword', strip_tags(__tr("Manage Plans")))
@section('description', strip_tags(__tr("Manage Plans")))
@section('keywordDescription', strip_tags(__tr("Manage Plans")))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Manage Plans') ?></h1>
	<a class="btn btn-primary btn-sm lw-ajax-link-action lw-action-with-url" data-event-callback="lwPrepareUploadPlugIn" href="<?= route('manage.plan.add.view') ?>" title="{{ __tr('Add New Plan') }}"><?= __tr('Add New Plan') ?></a>
</div>
<!-- Start of Page Wrapper -->
<div class="row">
	<div class="col-xl-12 mb-4">
		<div class="card mb-4">
			<div class="card-body table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							{{--<th><?= __tr('Image') ?></th>--}}
							<th><?= __tr('Title') ?></th>
							<th><?= __tr('Price') ?></th>
							<th><?= __tr('Description') ?></th>
							<th><?= __tr('Duration') ?></th>
							<th><?= __tr('Status') ?></th>
							<th><?= __tr('Created On') ?></th>
							<th><?= __tr('Action') ?></th>
						</tr>
					</thead>
					<tbody>
						@if(!__isEmpty($planData))
						@foreach($planData as $plan)
						<tr id="lw-plan-row-<?= $plan['_uid'] ?>">
							{{--<td class="lw-photoswipe-gallery">
								<img src="<?= $plan['planImageUrl'] ?>" class="img-thumbnail lw-item-img-thumbnail lw-photoswipe-gallery-img" />
							</td>--}}
							<td><?= $plan['title'] ?></td>
							<td class="text-right"><?= priceFormat($plan['price'], true) ?></td>
							<td><?= html_entity_decode($plan['description']) ?></td>
							<td><?= $plan['duration'].' days' ?></td>
							<td><?= ($plan['status'] == 1) ? 'Active' : 'Inactive'  ?></td>
							<td><?= $plan['created_at'] ?></td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-black dropdown-toggle lw-datatable-action-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item lw-ajax-link-action lw-action-with-url" data-event-callback="lwPrepareUploadPlugIn" data-title="{{ __tr('Edit Plan') }}" href="<?= route('manage.plan.edit.view', ['planUId' => $plan['_uid']]) ?>"><i class="far fa-edit"></i> <?= __tr('Edit') ?></a>
										@if($plan['status'] == 1)
											<a data-callback="onStatusChange" data-method="post" class="dropdown-item lw-ajax-link-action" href="<?= route('manage.plan.update-status', ['planUId' => $plan['_uid'], 'action' => 'deactive']) ?>"><i class="fas fa-ban"></i> <?= __tr('Deactive') ?></a>
										@else
											<a data-callback="onStatusChange" data-method="post" class="dropdown-item lw-ajax-link-action" href="<?= route('manage.plan.update-status', ['planUId' => $plan['_uid'], 'action' => 'active']) ?>"><i class="fas fa-check"></i> <?= __tr('Activate') ?></a>
										@endif
										<a data-callback="onDelete" data-method="post" class="dropdown-item lw-ajax-link-action" href="<?= route('manage.plan.write.delete', ['planUId' => $plan['_uid']]) ?>"><i class="fas fa-trash-alt"></i> <?= __tr('Delete') ?></a>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
						@endif
						@if(__isEmpty($planData))
						<tr>
							<td colspan="7" class="text-center">
								<?= __tr('There are no records.') ?>
							</td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- End of Page Wrapper -->
@lwPush('appScripts')
<script>
	function onDelete(response) {
		//check reaction code is 1
		if (response.reaction == 1) {
			//apply class row fade in
			$("#lw-plan-row-" + response.data.planUId).addClass("lw-deleted-row");
		}
	}

	function onStatusChange(response) {
		//check reaction code is 1
		if (response.reaction == 1) {
			//apply class row fade in
			location.reload();
			//$("#lw-plan-row-" + response.data.planUId).addClass("lw-deleted-row");
		}
	}

</script>
@lwPushEnd