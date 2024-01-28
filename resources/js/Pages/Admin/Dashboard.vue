<template>
    <Head title="Listing" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Listing</h2>
        </template>

        
        <div className="w-10/12 mx-auto py-5 relative overflow-x-auto shadow-md sm:rounded-lg">
            <!-- Create listing btn -->
            <CreateListingBtn @click="openCreateModal" />

            <!-- Table -->
            <table className="w-full text-left text-gray-400 rounded-xl mt-3">
                <thead className="uppercase bg-gray-700 text-gray-400">
                    <tr>
                    <th scope="col" className="p-4">
                        <div className="flex items-center">
                        <input
                            id="checkbox-all"
                            type="checkbox"
                            className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                        />
                        <label htmlFor="checkbox-all" className="sr-only">
                            checkbox
                        </label>
                        </div>
                    </th>
                    <TableHeader title="Name" />
                    <TableHeader title="Latitude" />
                    <TableHeader title="Longitude" />
                    <TableHeader title="User" />
                    <TableHeader title="Action" />
                    </tr>
                </thead>
                <tbody>
                    <ListingData 
                        v-for="listing in listings" 
                        :key="listing.id" 
                        :listing="listing"  
                        v-on:edit-clicked="editClicked"
                    />
                </tbody>
            </table>
        </div>

        <!-- Create modal -->
        <CreateListingModal ref="createModal" :users="users" />
        <!-- Edit modal -->
        <UpdateListingModal ref="updateModal" :users="users" />
    </AuthenticatedLayout>
    
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ListingData from '@/Components/Listing/ListingData.vue';
import TableHeader from '@/Components/Listing/TableHeader.vue';
import CreateListingModal from '@/Components/Listing/CreateListingModal.vue';
import UpdateListingModal from '@/Components/Listing/UpdateListingModal.vue';
import CreateListingBtn from '@/Components/Listing/CreateListingBtn.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from 'vue';

const props = defineProps({
    users: Array,
    listings: Object
})

// Ref
const modalOpen = ref(false);
const createModal = ref(null);
const updateModal = ref(null);

// Open create modal
const openCreateModal = () => {
    createModal.value.openModal();
}

// Open edit modal
const editClicked = (listing) => {
    updateModal.value.openModal(listing);
}

</script>