
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

import 'jquery-ui/ui/widgets/datepicker.js';

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});

$('#page-hr-applicant-edit .applicant-round-form').on('click', '.round-submit', function(){
	var form = $(this).closest('.applicant-round-form');
	form.find('[name="round_status"]').val($(this).data('status'));
	form.submit();
});

$('.date-field').datepicker({
	dateFormat: "dd/mm/yy"
});

$('#form_create_invoice, #form_edit_invoice').on('change', '#client_id', function(){
	let form = $(this).closest('form');
	let client_id = $(this).val();
	if (! client_id) {
		form.find('#project_ids').html('');
		return false;
	}
	updateClientProjects(form, client_id);
});

function updateClientProjects(form, client_id) {
	$.ajax({
		url : '/clients/' + client_id + '/get-projects',
		method : 'GET',
		success : function (res) {
			form.find('#project_ids').html(getProjectList(res));
		},
		error : function (err) {
			console.log(err);
		}

	});
}

function getProjectList(projects) {
	let html = '';
	for (var index = 0; index < projects.length; index++) {
		let project = projects[index];
		html += '<option value="' + project.id + '">';
		html += project.name;
		html += '</option>';
	}
	return html;
}
