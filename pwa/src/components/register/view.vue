<template>
  <div class="form">
    <input v-model="user.name" class="input" placeholder="Name"/>
    <input v-model="user.email" class="input" placeholder="Email"/>
    <input v-model="user.password" class="input" placeholder="Password" type="password"/>
    <div class="post-meta">{{ user.created_at }}</div>
    <button v-show="!loading" class="button" @click="register">Register</button>
    <p v-show="loading" class="loading">Loading...</p>
    <p v-show="error" class="error">{{ error }}</p>
    <p v-show="success" class="success">{{ success }}</p>
  </div>
</template>

<script setup>
import {storeToRefs} from 'pinia'
import store from '@/components/register/store.ts';

const {loading, error, success, user} = storeToRefs(store())

const register = async () => {
  await store().register();
};
</script>
