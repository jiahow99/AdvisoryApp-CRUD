<template>
    <div v-if="modalOpen" className="fixed top-0 left-0 w-screen h-screen bg-black/80 backdrop-blur-sm flex
        justify-center items-center"
    >
        <div className="bg-slate-300 rounded-xl p-5 w-5/12">
            <!-- Close button -->
            <div className="flex justify-end">
                <XMarkIcon @click="closeModal" class="w-7 h-7 cursor-pointer" />
            </div>

            <!-- Form -->
            <form @submit.prevent="handleSubmit">
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" v-model="form.name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div> 
                <!-- Latitude -->
                <div class="mb-6">
                    <label for="latitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Latitude</label>
                    <input type="decimal" v-model="form.latitude" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div> 
                <!-- Longitude -->
                <div class="mb-6">
                    <label for="longitude" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Longitude</label>
                    <input type="decimal" v-model="form.longitude" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                </div> 
                <!-- User -->
                <div class="mb-6">
                    <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User</label>
                    <select v-model="form.userId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option v-for="user in users" :key="user.id" :value="user.id">
                            {{ user.name }}
                        </option>
                    </select>
                </div> 
                <!-- Submit -->
                <button 
                    type="submit" 
                    :class="{
                        'bg-gray-400 ' : form.processing,
                        'bg-gray-600 ' : !form.processing
                    }"
                    class="text-white hover:bg-blue-800 flex gap-3
                    focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg 
                    text-sm w-full sm:w-auto px-5 py-2.5 text-center"
                    :disabled="form.processing"
                >
                    Submit
                    <ArrowPathIcon v-if="form.processing" class="h-6 w-6 animate-spin" />
                </button>
            </form>

        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ArrowPathIcon } from '@heroicons/vue/24/solid'
import { XMarkIcon } from '@heroicons/vue/24/solid'
import {ref} from 'vue';
import { toast } from 'vue3-toastify';

const props = defineProps({
    users: Array
})

// Ref
const modalOpen = ref(false);
const selectedListing = ref(null);

const form = useForm({
    name: '',
    latitude: '',
    longitude: '',
    userId: null
})

// Submit form
const handleSubmit = () => {
    // Loading
    const loading = toast.loading('Updating listing');

    form.put(route('listing.update', selectedListing.value.id), {
        onSuccess: () => {
            closeModal();
            toast.success("Update successfully", {"hideProgressBar": true, "theme": 'colored'});
        },  // success
        onError: (error) => {
            console.log(error);
            toast.error("Fail to update", {"hideProgressBar": true, "theme": 'colored'});
        },  // fail
        onFinish: () => toast.remove(loading)
    });

    
}

// Open modal
const openModal = (listing) => {
    modalOpen.value = true;
    selectedListing.value = listing;
    // Set values
    form.name = listing.name;
    form.latitude = listing.latitude;
    form.longitude = listing.longitude;
    form.userId = listing.user.id;
}

// Close modal
const closeModal = () => {
    form.reset();
    selectedListing.value = null;   
    modalOpen.value = false;   
}

defineExpose({openModal});

</script>