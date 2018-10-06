<div class="card mt-4">
	<form action="{{ route('setting.hr.update') }}" method="POST">

		@csrf

		<div class="card-header c-pointer" data-toggle="collapse" data-target="#approved_email_template" aria-expanded="true" aria-controls="approved_email_template">Approved email to Applicant</div>
		<div id="approved_email_template" class="collapse">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[approved_mail_subject]">Subject</label>
							<input type="text" name="setting_key[approved_mail_subject]" class="form-control" value="{{ isset($settings['approved_mail_subject']->setting_value) ? $settings['approved_mail_subject']->setting_value : '' }}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="setting_key[approved_mail_body]">Mail body:</label>
							<textarea name="setting_key[approved_mail_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['approved_mail_body']->setting_value) ? $settings['approved_mail_body']->setting_value : '' }}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</div> 
	</form>
</div>
