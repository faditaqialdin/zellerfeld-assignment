<template>
  <div class="navbar">
    <div>{{ user.name }}</div>
    <div class="navbar-links">
      <router-link to="/">Home</router-link>
      <router-link :to="`/users/`+user.id">My Profile</router-link>
      <a href="#" @click.prevent="store().logout">Logout</a>
    </div>
  </div>
</template>
<script lang="ts" setup>
import storage from "@/app/storage.js";
import store from '@/components/navbar/store.ts';

const user = storage.getProfile();
</script>