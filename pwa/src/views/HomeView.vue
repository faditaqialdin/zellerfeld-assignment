<template>
  <Suspense>
    <div>
      <Navbar/>
      <Create/>
      <List :key="$route.fullPath"/>
    </div>

    <template #fallback>Loading...</template>
  </Suspense>
</template>

<script lang="ts" setup>
import Navbar from '@/components/navbar/view.vue'
import Create from '@/components/user/post/create/view.vue'
import List from '@/components/post/list/view.vue'
</script>
