<template>
    <tr className="bg-gray-800 border-b hover:bg-gray-600">
        <!-- Checkbox -->
        <td className="w-4 p-4">
            <div className="flex items-center">
                <input
                id="checkbox-table-1"
                type="checkbox"
                className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                />
                <label htmlFor="checkbox-table-1" className="sr-only">
                checkbox
                </label>
            </div>
        </td>
        <!-- Form -->
        <th
            scope="row"
            className="px-6 py-4 font-medium text-white whitespace-nowrap"
        >
            {{ listing.name }}
        </th>
        <td className="px-6 py-4">{{ listing.longitude }}</td>
        <td className="px-6 py-4">{{ listing.latitude }}</td>
        <td className="px-6 py-4">{{ listing.user.name }}</td>
        <td className="px-6 py-4 flex gap-5">
            <button
                as="button"
                className="font-medium text-blue-600 hover:underline"
                @click="emit('editClicked', listing)"
            >
                Edit
            </button>
            <button @click="deleteListing" className="font-medium text-red-400 hover:underline">
                Delete
            </button>                
        </td>
    </tr>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { toast } from "vue3-toastify";

const props = defineProps({
    listing: Object
})

// Handle delete success
const handleDeleteSuccess = () => toast.success("Deleted listing", {"hideProgressBar": true, "theme": 'colored'})

// Handle delete error
const handleDeleteError = (error) => {
    toast.error("Failed to delete listing", {"hideProgressBar": true, "theme": 'colored'});
    console.log(error);
}

// Delete listing
const deleteListing = () => {
    // Loading
    const loading = toast.loading("Deleting listing");

    router.delete(route('listing.destroy', props.listing.id), {
        onSuccess: handleDeleteSuccess,
        onError : handleDeleteError,
        onFinish: () => toast.remove(loading)
    });
}

const emit = defineEmits(['editClicked'])
</script>
