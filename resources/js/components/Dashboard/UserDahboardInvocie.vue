<template>
  <div class="card">
    <div class="card-header p-1">
      <h3 class="text-center"><a href="/invoice">Invoices</a></h3>
    </div>
    <div class="card-body pt-3" style="height: 18em;overflow: auto;">
      <ul class="list list-group unstyled-list">
        <li class="d-flex justify-content-between" style="font-size:16px;">
          <span> Pending invoices </span>
          <div class="'cost badge  cost p-2 '" v-text="sentInvoiceCount"></div>
        </li>
        <hr class="mt-1 w-full" />
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: [],
  data() {
    return {
      sentInvoiceCount: 0,
    };
  },

  methods: {
    async getDashboardData() {
      let response = await axios.get("/invoice/dashboard");
      let sentInvoices = response.data;
      this.sentInvoiceCount = sentInvoices.length;
    },
  },

  mounted() {
    this.getDashboardData();
  },
};
</script>
