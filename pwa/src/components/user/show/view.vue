<template>
  <div class="form">
    <input v-if="canEdit" v-model="user.name" class="input" placeholder="Name"/>
    <p v-else>{{ user.name }}</p>

    <input v-if="canEdit" v-model="user.email" class="input" placeholder="Email"/>
    <p v-else>{{ user.email }}</p>

    <input v-if="canEdit" v-model="user.password" class="input" placeholder="Password" type="password"/>
    <p v-else>{{ user.password }}</p>

    <div class="post-meta">Created At: {{ user.created_at }}</div>

    <button v-if="canEdit" v-show="!loading" class="button" @click="updateInfo">Update</button>
    <p v-show="loading" class="loading">Loading...</p>
    <p v-show="error" class="error">{{ error }}</p>
    <p v-show="success" class="success">{{ success }}</p>
  </div>
</template>

<script setup>
import {onMounted} from 'vue';
import {storeToRefs} from 'pinia'
import store from '@/components/user/show/store.ts';
import {useRoute} from 'vue-router';

const route = useRoute();

const {loading, error, success, canEdit, user} = storeToRefs(store())

const updateInfo = async () => {
  await store().updateInfo(Number(route.params.user_id));
};

const reload = async () => {
  await store().reset();
  await store().loadInfo(Number(route.params.user_id));
};

onMounted(reload);
</script>
