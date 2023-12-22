<template>

    <Head title="Employee" />

    <SideBarLayout>
        <template #header >
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl leading-tight">List of Employees</h2>
                <div style="position:relative">
                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-9 p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search employee here" v-model="search">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#444  " width="20px" height="20px" viewBox="0 0 16 16"
                    style="position:absolute; top:10px; right:10px">
                    <path d="M12.027 9.92L16 13.95 14 16l-4.075-3.976A6.465 6.465 0 0 1 6.5 13C2.91 13 0 10.083 0 6.5 0 2.91 2.917 0 6.5 0 10.09 0 13 2.917 13 6.5a6.463 6.463 0 0 1-.973 3.42zM1.997 6.452c0 2.48 2.014 4.5 4.5 4.5 2.48 0 4.5-2.015 4.5-4.5 0-2.48-2.015-4.5-4.5-4.5-2.48 0-4.5 2.014-4.5 4.5z" fill-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class=" overflow-hidden shadow-sm sm:rounded-lg" :class="themeMode">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <!-- <th class="py-3 px-6 text-left">Id</th> -->
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-center">Position</th>
                                <th class="py-3 px-6 text-center">Phone</th>
                                <th class="py-3 px-6 text-center">Email</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center" v-if="$page.props.auth.permissions.includes('manage_users')">Actions</th>
                            </tr>
                        </thead>
                        <tbody class=" text-sm  " >
                            <tr v-if="employees.data.length === 0">
                                <td colspan="7" class="text-center text-lg   py-6">No employee record found</td>
                            </tr>
                            <tr  class="border-b border-gray-200 hover:bg-gray-100" v-for="emp in employees.data" :key="emp.id">
                                <!-- <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">

                                        <p class="font-medium">{{ emp.id }}</p>
                                    </div>
                                </td> -->
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <p class="font-medium">{{ emp.user.firstName }} {{ emp.user.middleName }}  {{ emp.user.lastName }} {{ emp.user.suffix }}</p>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex items-center justify-center">
                                        <p class="font-medium">{{ emp.position.name}}</p>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex items-center justify-center">
                                        <p class="font-medium">+63{{ emp.user.phone}}</p>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex items-center justify-center">
                                        <p class="font-medium">{{ emp.user.email}}</p>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex items-center justify-center mb-2">
                                        <span v-if="emp.user.status == 1" class="remarks-cell py-1 px-3 rounded-full text-xs bg-green-200 text-green-600">Active</span>
                                        <span v-else class="text-md font-semibold remarks-cell py-1 px-3 rounded-full text-xs bg-red-200 text-red-600">Inactive</span>
                                    </div>
                                </td>
                                <!-- <td class="py-3 px-3 text-center">
                                    <span class="remarks-cell py-1 px-3 rounded-full text-xs"
                                        :class="{
                                            'bg-green-200 text-green-600': emp.user.status == 1,
                                            'bg-red-200 text-red-600': emp.user.status == 0,
                                        }"
                                    > {{ emp.user.status === 0 ? 'Inactive' : 'Active' }}</span>
                                </td> -->

                                <td class="py-3 px-6 text-center" v-if="$page.props.auth.permissions.includes('manage_users')">
                                    <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                            <Link :href="'/employees/' + emp.id">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </Link>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:blue-purple-500 hover:scale-110">
                                            <button class="w-4 mr-2 transform hover:blue-purple-500 hover:scale-110" @click="updateEmployee(emp.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                            <a href="#" @click="remove(emp)" class="btn" title="Delete Position">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                            Delete Employee
                        </h3>
                        <p class="text-gray-500">
                            Are you sure you want like to delete this Employee?
                        </p>

                        <div class="mt-6 flex justify-center gap-x-4">
                            <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                            <DangerButton @click="deletePos()">Delete</DangerButton>
                        </div>
                    </div>
                </Modal>
                <!-- <Pagination v-if="employees.data.length >0" :links="employees.links" class="mt-6 flex justify-center"/> -->


            </div>
        </div>

    </SideBarLayout>

</template>

<script setup>
import SideBarLayout from '@/Layouts/SideBarLayout.vue';
import { Head, Link, router,useForm } from '@inertiajs/vue3';
import { watch, ref, computed } from 'vue';
import moment from'moment'
// import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {inject} from 'vue'
const themeMode = inject('themeMode')

const props = defineProps({
    employees: Object,
    user:Object,
    filters:Object

})
let search = ref(props.filters.search);
    watch(search, (value) => {
        router.get(
            "/employees",
            { search: value },
            {
                preserveState: true,
                replace: true,
            }
        );
    });

function updateEmployee(empId) {
    router.visit('/employees/edit/' + empId);
}

let showConfirm = ref(false)
let selectedEmployeeForDelete = null
let deleteForm = useForm({});
function closeModal(){
    showConfirm.value = false;
}

function remove(emp) {
    selectedEmployeeForDelete = emp
    showConfirm.value = true;
}

function deletePos(){
    deleteForm.delete('/employees/' + selectedEmployeeForDelete.id)
    showConfirm.value = false;
}
// function deleteEmployee(empId) {
//   if (confirm('Are you sure you want to remove selected Employee?')) {
//     try {
//       Inertia.delete(`/employees/${empId}`)
//       alert('Employee removed successfully!')
//       window.location.reload()
//     } catch (error) {
//       alert('Error removing employee')
//     }
//   }
// }

</script>
