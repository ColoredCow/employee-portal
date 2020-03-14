Vue.component('invoice', require('../components/Finance/Invoice.vue'));
Vue.component('invoice-create', require('../components/Finance/InvoiceCreate.vue'));
Vue.component('amc-form', require('../components/Finance/AMCForm.vue'));

if (document.getElementById('form_invoice')) {
    const invoiceForm = new Vue({
        el: '#form_invoice',
    });
}

if (document.getElementById('form_amc')) {
    const invoiceForm = new Vue({
        el: '#form_amc',
    });
}
