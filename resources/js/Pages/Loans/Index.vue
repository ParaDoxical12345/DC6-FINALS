<!-- YourComponent.vue -->

<template>
    <div>
      <Head title="Loan" />

      <SideBarLayout>
        <template #header>
          <div class="flex justify-between">
            <h2 class="font-semibold text-xl leading-tight">List of Loans</h2>
            <!-- <div style="position:relative">
              <input
                type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-9 p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search loan here"
                v-model="search"
              />
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="#444 "
                width="20px"
                height="20px"
                viewBox="0 0 16 16"
                style="position:absolute; top:10px; right:10px"
              >
                <path
                  d="M12.027 9.92L16 13.95 14 16l-4.075-3.976A6.465 6.465 0 0 1 6.5 13C2.91 13 0 10.083 0 6.5 0 2.91 2.917 0 6.5 0 10.09 0 13 2.917 13 6.5a6.463 6.463 0 0 1-.973 3.42zM1.997 6.452c0 2.48 2.014 4.5 4.5 4.5 2.48 0 4.5-2.015 4.5-4.5 0-2.48-2.015-4.5-4.5-4.5-2.48 0-4.5 2.014-4.5 4.5z"
                  fill-rule="evenodd"
                />
              </svg>
            </div> -->
            <div class="flex">
              <button
                type="button"
                class="button1 mb-2 py-2 px-3 bg-green-300 shadow border-gray-300 border hover:bg-green-400 rounded mr-3"
                @click="openAddItemModal"
              >
                Create Loan
              </button>
            </div>
          </div>
          <div v-if="$page.props.flash.success" id="flash-success-message" class="absolute top-20 right-1 p-4 bg-green-300 border border-gray-300 rounded-md shadow-md">
            {{ $page.props.flash.success }}
            <div class="progress-bar success"></div>
          </div>

          <div v-if="$page.props.flash.error" id="flash-error-message" class=" absolute top-20 right-1 p-4 bg-red-300 border border-gray-300 rounded-md shadow-md">
            {{ $page.props.flash.error }}
            <div class="progress-bar error"></div>
          </div>
        </template>
        <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-7" :class="themeMode">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
              <table class="min-w-max w-full table-auto">
                <thead>
                  <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Customer Name</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Due Date</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                  </tr>
                </thead>
                <tbody class="text-sm font-light">
                  <tr v-if="!loans.length">
                    <td colspan="4" class="text-center text-lg py-6">No loan records available</td>
                  </tr>
                  <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="loan in loans" :key="loan.id">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ loan.customer_name }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">${{ loan.amount }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ loan.due_date }}</td>
                    <td class="py-3 px-6 text-center">
                      <div class="flex item-center justify-center">
                        <button
                          type="button"
                          class="text-indigo-600 hover:text-indigo-900 mx-1"
                          @click="edit(loan)"
                        >
                          Edit
                        </button>
                        <button
                          type="button"
                          class="text-red-600 hover:text-red-900 mx-1"
                          @click="remove(loan)"
                        >
                          Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <Modal :show="showAddItemModal" @close="closeAddItemModal">
                        <div class="p-4 sm:p-10 text-center ">
                            <div class=" pr-6">
                            <h4 class="px-5 text-xl font-bold text-navy-700 dark:text-black">
                                Loan Details
                            </h4>
                            <hr>
                            <form @submit.prevent="submit" >
                                <div class="px-4 py-5">

                                    <label class="font-semibold text-sm text-gray-600  text-left block" for="name">Loan Name</label>
                                    <input type="text" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full text-gray-600 "  v-model="form.name"/>
                                    <div class="text-red-600" v-if="form.errors.name">{{ form.errors.name }}</div>

                                    <label class="font-semibold text-sm text-gray-600 text-left block" for="amount">Amount</label>
                                    <input type="number" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full text-gray-600 "  v-model="form.amount"/>
                                    <div class="text-red-600" v-if="form.errors.amount">{{ form.errors.amount }}</div>

                                    <label class="font-semibold text-sm text-gray-600 text-left block" for="due_date">Due date</label>
                                    <input type="date" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full text-gray-600 "  v-model="form.due_date"/>
                                    <div class="text-red-600" v-if="form.errors.due_date">{{ form.errors.due_date }}</div>


                                    <div class="mt-6 flex justify-center gap-x-4">
                                        <SecondaryButton @click="closeAddItemModal">Cancel</SecondaryButton>
                                        <PrimaryButton  @click="addItem()">Add Loan</PrimaryButton>
                                    </div>
                                </div>
                            </form>

                        </div>

                        </div>
                    </Modal>
                    <Modal :show="showUpdateItemModal" @close="closeUpdateItemModal">
                        <div class="p-4 sm:p-10 text-center ">
                            <div class=" pr-6">
                            <h4 class="px-5 text-xl font-bold text-navy-700 dark:text-black">
                                Loan Details
                            </h4>
                            <hr>
                            <form @submit.prevent="update" >
                                <div class="px-4 py-5">

                                    <label class="font-semibold text-sm text-gray-600  text-left block" for="name">Loan Name</label>
                                    <input type="text" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full text-gray-600 "  v-model="form.name"/>
                                    <div class="text-red-600" v-if="form.errors.name">{{ form.errors.name }}</div>

                                    <label class="font-semibold text-sm text-gray-600 text-left block" for="amount">Amount</label>
                                    <input type="number" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full text-gray-600 "  v-model="form.amount"/>
                                    <div class="text-red-600" v-if="form.errors.amount">{{ form.errors.amount }}</div>


                                    <label class="font-semibold text-sm text-gray-600 text-left block" for="due_date">Due date</label>
                                    <input type="date" class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full text-gray-600 "  v-model="form.due_date"/>
                                    <div class="text-red-600" v-if="form.errors.due_date">{{ form.errors.due_date }}</div>

                                    <div class="mt-6 flex justify-center gap-x-4">
                                        <SecondaryButton @click="closeUpdateItemModal">Cancel</SecondaryButton>
                                        <PrimaryButton  @click="update()">Edit Loan</PrimaryButton>
                                    </div>
                                </div>
                            </form>

                        </div>

                        </div>
                    </Modal>
              <Modal :show="showConfirm" @close="closeModal">
                        <div class="p-4 sm:p-10 text-center overflow-y-auto">
                            <!-- Icon -->
                            <span class="mb-4 inline-flex justify-center items-center w-[62px] h-[62px] rounded-full border-4 border-red-50 bg-red-100 text-red-500">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                                </svg>
                            </span>
                            <!-- End Icon -->

                            <h3 class="mb-2 text-2xl font-bold text-gray-800">
                                Delete Loan
                            </h3>
                            <p class="text-gray-500">
                                Are you sure you want like to delete this Loan?
                            </p>

                            <div class="mt-6 flex justify-center gap-x-4">
                                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                <DangerButton @click="deletePos()">Delete</DangerButton>
                            </div>
                        </div>
                    </Modal>
            </div>
          </div>
          <Pagination v-if="loans.length > 0" :links="loans.links" class="mt-6 flex justify-center" />
        </div>
      </SideBarLayout>
    </div>
  </template>

  <script setup>
    import { defineProps, ref, onMounted } from 'vue';
    import SideBarLayout from '@/Layouts/SideBarLayout.vue';
    import { Head, Link, router, useForm } from '@inertiajs/vue3';
    import moment from 'moment';
    import Modal from '@/Components/Modal.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import DangerButton from '@/Components/DangerButton.vue';
    import { inject } from 'vue';

  const themeMode = inject('themeMode');

  const props = defineProps({
    loans: Array
  })

  const form = useForm({
    customer_name: '',
    amount: '',
    due_date: '',
  });


  const showAddItemModal = ref(false);

  function closeModal() {
    showConfirm.value = false;
  }

  const openAddItemModal = () => {
    showAddItemModal.value = true;
  };

  const closeAddItemModal = () => {
    showAddItemModal.value = false;
  };

  const addItem = () => {
  console.log('Form data before submission:', form.data());
  form.post('/loans').then(() => {
    console.log('Form submission successful!');
    form.reset();
    closeAddItemModal();
  }).catch((error) => {
    console.error('Form submission error:', error);
  });
};

  let showConfirm = ref(false);
  let selectedLoanForDelete = null;
  let selectedLoan = null;
  let deleteForm = useForm({});

  const showUpdateItemModal = ref(false);
  const closeUpdateItemModal = () => {
    showUpdateItemModal.value = false;
  };

  function edit(loan) {
    selectedLoan = loan;
    showUpdateItemModal.value = true;
    form.customer_name = loan.customer_name;
    form.amount = loan.amount;
    form.due_date = loan.due_date;
  }

  function remove(loan) {
    selectedLoanForDelete = loan;
    showConfirm.value = true;
  }

  function deleteLoan() {
    deleteForm.delete('/loans/' + selectedLoanForDelete.id);
    showConfirm.value = false;
  }

  const update = () => {
    form.put('/loans/' + selectedLoan.id);
    form.customer_name = '';
    form.amount = '';
    form.due_date = '';
    closeUpdateItemModal();
  };

  onMounted(() => {
    // Set a timeout to hide the success flash message after 3 seconds
    const successFlashMessage = document.getElementById('flash-success-message');
    if (successFlashMessage) {
      setTimeout(() => {
        successFlashMessage.style.display = 'none';
      }, 3000);
    }

    // Set a timeout to hide the error flash message after 3 seconds
    const errorFlashMessage = document.getElementById('flash-error-message');
    if (errorFlashMessage) {
      setTimeout(() => {
        errorFlashMessage.style.display = 'none';
      }, 3000);
    }
  });


  </script>

  <style scoped>
  #flash-success-message {
    animation: fadeOut 6s ease-in-out forwards;
  }

  .progress-bar {
    height: 5px;
    width: 100%;
    background-color: #4CAF50; /* Green color */
    animation: progressBar 3s linear;
  }

  #flash-error-message {
    animation: fadeOut 7s ease-in-out forwards;
  }

  .success .progress-bar {
    animation: progressBar 5s linear;
  }

  .error .progress-bar {
    background-color: #FF5733; /* Red color */
    animation: progressBar 5s linear;
  }

  @keyframes fadeOut {
    from {
      opacity: 1;
    }
    to {
      opacity: 0;
    }
  }

  @keyframes progressBar {
    0% {
      width: 100%;
    }
    100% {
      width: 0;
    }
  }
  </style>
