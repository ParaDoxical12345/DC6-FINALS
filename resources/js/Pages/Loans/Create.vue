<template>
    <div>
      <h1>Create Loan</h1>
      <form @submit.prevent="submitForm">
        <label>Customer Name:</label>
        <input v-model="form.customer_name" required />

        <label>Amount:</label>
        <input v-model="form.amount" type="number" step="0.01" required />

        <label>Due Date:</label>
        <input v-model="form.due_date" type="date" required />

        <button type="submit">Submit</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        form: {
          customer_name: '',
          amount: '',
          due_date: '',
        },
      };
    },
    methods: {
      submitForm() {
        this.$inertia.post('/loans', this.form);
      },
    },
  };
  </script>
