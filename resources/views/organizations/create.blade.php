@extends('layouts.app')

@section('content')
<div class="container" id="page_onboard_organization">
    <br>
    <div class="offset-md-3 col-md-6">
        <h1 class="form-row">Create your organization</h1>
        <br>
        <div class="card border-light card-form">
            <div class="card-header border-light">Step <span v-text="step"></span> of <span v-text="totalSteps"></span>  </div>
            <div class="card-body">
                <div class="progress">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" :style="'width: ' + progress + '%'"></div>
                </div>
                <br>
                @if (sizeof($errors))
                    <div class="alert alert-danger" role="alert">
                        <p><strong>There were some errors. Please resolve them and try again.</strong></p>
                        <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                        </ul>
                    </div>
                    <br>
                @endif
                <form action="{{ route('organizations.store') }}" method="POST" enctype="multipart/form-data" id="onboard_organization">
                    {{ csrf_field() }}
                    <section class="step-onboarding" v-show="isStep(1)">
                        <h3 class="mt-2 mb-4">Organization Details</strong></h3>
                        <div class="form-group">
                            <label class="font-weight-bold" for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required="required">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="admin_email">G Suite admin email</label>
                            <input type="text" name="admin_email" id="admin_email" class="form-control" value="{{ old('admin_email') }}" required="required">
                        </div>
                    </section>
                    <section class="step-onboarding" v-show="step == 2">
                        <h3 class="mt-2 mb-4">Setup G Suite API credentials</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong><a href="https://console.developers.google.com/projectcreate" target="_blank">Create a new project</a></strong> from your Google Developer Console.<br>
                                <figure class="image-card mt-2">
                                    <img src="/images/onboarding/new-project.png">
                                </figure>
                            </li>
                            <li class="list-group-item">
                                <strong><a href="https://console.developers.google.com/iam-admin/serviceaccounts" target="_blank">Create a service account</a>
                                </strong> for the project that you just created. While creating the service account, <strong>make sure you check the private key and domain-wide delegation options</strong>. Download the private key. We'll need it in the next step.
                                <figure class="image-card mt-2">
                                    <img src="/images/onboarding/create-service-account.png">
                                </figure>
                            </li>
                            <li class="list-group-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="new_project" id="new_project" required="required">
                                    <label class="custom-control-label" for="new_project">I have created a new project</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="new_service_account" id="new_service_account" required="required">
                                    <label class="custom-control-label" for="new_service_account">I have created a service account</label>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <section class="step-onboarding" v-show="step == 3">
                        <h3 class="mt-2 mb-4">Complete your service account details.</h3>
                        <div class="form-group">
                            <label class="font-weight-bold" for="gsuite_dwd_private_key">Service Account Private Key (downloaded in the previous step)</label>
                            <input type="file" name="gsuite_dwd_private_key" id="gsuite_dwd_private_key" class="form-control-file" accept=".json" required="required">
                            <small class="form-text text-muted">We'll never share these credentials with anyone else.</small>
                        </div>
                    </section>
                    <section class="step-onboarding" v-show="step == 4">
                        <h3 class="mt-2 mb-4">Enable Google APIs</h3>
                        <div class="form-group">
                            <p>Enable the following Google APIs for your project so that Employee Portal can make requests and access your organizational data.</p>
                            <ul>
                                <li><a href="https://console.developers.google.com/apis/api/admin.googleapis.com/overview" target="_blank">Enable Admin SDK</a></li>
                                <li><a href="https://console.developers.google.com/apis/library/calendar-json.googleapis.com" target="_blank">Enable Calendar API</a></li>
                            </ul>
                        </div>
                    </section>
                    <section class="step-onboarding" v-show="step == 5">
                        <h3 class="mt-2 mb-4">Enable G Suite API reference</h3>
                        <div class="form-group">
                            <ul>
                                <li><strong><a href="https://admin.google.com" target="_blank">Go to your G Suite domain's admin console</a></strong></li>
                                <li>Select <strong>Security</strong> from the list of controls. If you don't see <strong>Security</strong> listed, select <strong>More controls</strong> from the gray bar at the bottom of the page, then select <strong>Security</strong> from the list of controls.</li>
                                <li>Select <strong>API reference</strong> from the list of options.</li>
                                <li>Click the <strong>Enable API access</strong> checkbox.</li>
                                <figure class="image-card mt-2">
                                    <img src="/images/onboarding/enable-api-access.png">
                                </figure>
                            </ul>
                        </div>
                    </section>
                    <section class="step-onboarding" v-show="step == 6">
                        <h3 class="mt-2 mb-4">Enable domain-wide delegation for your G Suite admin</h3>
                        <div class="form-group">
                            <p class="mb-1">This will help us to access your following organizational G Suite details without troubling your team members for their consent.</p>
                            <ul>
                                <li><strong><a href="https://admin.google.com" target="_blank">Go to your G Suite domain's admin console</a></strong></li>
                                <li>Select <strong>Security</strong> from the list of controls. If you don't see <strong>Security</strong> listed, select <strong>More controls</strong> from the gray bar at the bottom of the page, then select <strong>Security</strong> from the list of controls.</li>
                                <li>Select <strong>Advanced settings</strong> from the list of options.</li>
                                <figure class="image-card mt-2">
                                    <img src="/images/onboarding/gsuite-advanced-settings.png">
                                </figure>
                                <li>Select <strong>Manage API client access</strong> in the <strong>Authentication</strong> section.</li>
                                <li>In the <strong>Client name</strong> field enter the service account's <strong>Client ID</strong>.</li>
                                <li>Copy the following text and paste them in the <strong>One or More API Scopes</strong> field:</li>
                                <div class="card card-block flex-row align-items-start mt-2 mb-4 p-2 bg-light" id="domain_wide_delegation_scopes">
                                    <p class="text-wrap mb-0">https://www.googleapis.com/auth/calendar, https://www.googleapis.com/auth/calendar.readonly, https://www.googleapis.com/auth/admin.directory.user, https://www.googleapis.com/auth/admin.directory.user.readonly</p>
                                    <button type="button" class="btn btn-secondary btn-clipboard" id="copy_domain_wide_delegation_scopes" data-clipboard-target="#domain_wide_delegation_scopes" data-original-title="Copy to clipboard">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </div>
                                <figure class="image-card mt-2">
                                    <img src="/images/onboarding/manage-api-client-access.png">
                                </figure>
                                <li>Click the <strong>Authorize</strong> button.</li>
                            </ul>
                        </div>
                    </section>
                    <section class="step-onboarding" v-show="step == 7">
                        <h3 class="mt-2 mb-4">Set up your workspace</h3>
                        <div class="form-group">
                            <label class="font-weight-bold" for="slug">Your workspace name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="myorganization" name="slug" id="slug" value="{{ old('slug') }}" required="required">
                                <div class="input-group-append">
                                    <span class="input-group-text">.coloredcow.com</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
            <div class="card-footer border-light">
                <div class="actions-block d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" v-if="step > 1" @click="showPreviousStep()">&larr; Previous step</button>
                    <button type="button" class="btn btn-primary" v-if="step < totalSteps" @click="showNextStep()">Next step &rarr;</button>
                    <button type="submit" class="btn btn-success" v-if="step == totalSteps">Complete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
