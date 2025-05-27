<template>
  <Suspense>
    <LoginView/>

    <template #fallback>Loading...</template>
  </Suspense>
</template>

<script lang="ts" setup>
import LoginView from '@/components/auth/login/view.vue'
</script>
