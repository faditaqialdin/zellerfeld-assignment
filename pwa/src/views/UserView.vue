<template>
  <Suspense>
    <div>
      <Navbar/>
      <Info/>
      <Create/>
      <List :key="$route.fullPath"/>
    </div>

    <template #fallback>Loading...</template>
  </Suspense>
</template>

<script lang="ts" setup>
import Navbar from '@/components/navbar/view.vue'
import Info from "@/components/user/show/view.vue";
import Create from "@/components/user/post/create/view.vue";
import List from "@/components/user/post/list/view.vue";
</script>
