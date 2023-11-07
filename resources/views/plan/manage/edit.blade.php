<?= __yesset([
		'dist/js/tinymce/tinymce.min.js'
], true) ?>
<!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
 	<h1 class="h3 mb-0 text-gray-200"><?= __tr('Edit Plan')  ?></h1>
 	<!-- back button -->
 	<a class="btn btn-light btn-sm lw-ajax-link-action lw-action-with-url" data-title="{{ __tr('Manage Plans') }}" href="<?= route('manage.plan.read.list') ?>">
 		<i class="fa fa-arrow-left" aria-hidden="true"></i> <?= __tr('Back to Plans') ?>
 	</a>
 	<!-- /back button -->
 </div>
 <!-- Start of Page Wrapper -->
 <div class="row">
 	<div class="col-xl-12 mb-4">
 		<div class="card mb-4">
 			<div class="card-body">
 				<!-- page add form -->
 				<form class="lw-ajax-form lw-form" method="post" action="<?= route('manage.plan.write.edit', ['planUId' => $planEditData['_uid']]) ?>">

 					<!-- title input field -->
 					<div class="form-group">
 						<label for="lwTitle"><?= __tr('Title') ?></label>
 						<input type="text" value="<?= $planEditData['title'] ?>" id="lwTitle" class="form-control" name="title" placeholder="<?= __tr('Title')  ?>" required minlength="3">
 					</div>
 					<!-- / title input field -->
 					<div class="form-group row">
 						<!-- price field -->
 						<div class="col-sm-6 mb-3 mb-sm-0">
 							<label for="lwPrice"><?= __tr('Price') ?></label>
 							<div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="lwPriceAddon">{{  getCurrencySymbol() }}</span>
                                </div>
                                <input type="number" value="<?= $planEditData['price'] ?>" id="lwPrice" class="form-control" name="price" required digits="true">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="lwPriceAddon">{{  getCurrency() }}</span>
                                </div>
                            </div>
 						</div>
 						<!-- /price field -->

						<!-- Duration field -->
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label for="lwDuration"><?= __tr('Duration (in Days)') ?></label>
							<input type="number" value="<?= $planEditData['duration'] ?>" class="form-control d-block" name="duration" id="lwDuration" required digits="true">
						</div>
						<!-- / Duration field -->
					</div>
					<div class="form-group row">
						<div class="col-sm-12 mb-6 mb-sm-0">
							<label for="description"><?= __tr('Description') ?></label>
							<input type="hidden" name="description" id="description">
							<textarea id="description_editor" class="form-control" name="description_editor" required>{!! $planEditData['description'] !!}</textarea>

							</div>
					</div>
 					<br><br>
 					<!-- Update button -->
 					<button type="submit" class="lw-ajax-form-submit-action btn btn-primary btn-user lw-btn-block-mobile"><?= __tr('Update')  ?></button>
 					<!-- / Update button -->
 				</form>
 				<!-- / page add form -->
 			</div>
 		</div>
 	</div>
 </div>
 <!-- End of Page Wrapper -->
 @lwPush('appScripts')
 <script>
	 $(document).ready(function(){

		 tinymce.init({
			 selector: '#description_editor',
			 plugins: 'a11ychecker,advlist,advcode,advtable,autolink,checklist,code,codesample,directionality,emoticons,fullscreen,help,hr,image,imagetools,importcss,insertdatetime,link,lists,media,nonbreaking,pagebreak,permanentpen,preview,print,searchreplace,table,textcolor,visualblocks,wordcount',
			 toolbar: 'undo redo | formatselect | bold italic strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview',
			 setup: function (editor) {
				 editor.on('init', setContentToHiddenField),
				 editor.on('change', setContentToHiddenField)
			 }
		 });

	 });

	 function setContentToHiddenField() {
		 var editorContent = tinymce.get('description_editor').getContent(); // Get the content from TinyMCE
		 document.getElementById('description').value = editorContent; // Set the content to the hidden field
	 }

	 function afterUploadedFile(responseData) {
 		if (responseData.reaction == 1) {
 			$('.lw-gift-preview-image').attr('src', responseData.data.path);
 		}
 	}
 </script>
 @lwPushEnd