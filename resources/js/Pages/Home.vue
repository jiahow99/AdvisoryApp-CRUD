<template>
    <GuestLayout>
        <div className="flex flex-col gap-3">
            <h1 className="text-center text-lg font-semibold">Login :</h1>
            <!-- User login -->
            <LoginBtn href="/login">
                User
            </LoginBtn>
    
            <!-- Admin login -->
            <LoginBtn href="/admin/login">
                Admin
            </LoginBtn>

        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import LoginBtn from '@/Components/LoginBtn.vue';

</script>