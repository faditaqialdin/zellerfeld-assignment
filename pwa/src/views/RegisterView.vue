<template>
  <Suspense>
    <RegisterView/>

    <template #fallback>Loading...</template>
  </Suspense>
</template>

<script lang="ts" setup>
import RegisterView from '@/components/register/view.vue'
</script>
