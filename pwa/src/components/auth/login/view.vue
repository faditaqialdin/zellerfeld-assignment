<template>
  <form class="form" @submit.prevent="login">
    <input v-model="user.email" class="input" placeholder="Email"/>
    <input v-model="user.password" class="input" placeholder="Password" type="password"/>
    <button v-show="!loading" class="button">Login</button>
    <p v-show="loading" class="loading">Loading...</p>
    <p v-show="error" class="error">{{ error }}</p>
  </form>
</template>

<script setup>
import {storeToRefs} from 'pinia'
import store from '@/components/auth/login/store.ts';

const {loading, error, user} = storeToRefs(store())

const login = async () => {
  await store().login();
}
</script>
