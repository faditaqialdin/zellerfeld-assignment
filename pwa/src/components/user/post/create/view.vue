<template>
  <div v-if="canPost" class="form">
    <textarea v-model="content" class="textarea" placeholder="What's on your mind?"></textarea>
    <button v-show="!loading" class="button" @click="createPost">Post</button>
    <p v-show="loading" class="loading">Loading...</p>
    <p v-show="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup>
import {storeToRefs} from 'pinia'
import store from '@/components/user/post/create/store.ts';
import {useRoute} from 'vue-router';
import {onMounted} from "vue";

const {loading, error, content, canPost} = storeToRefs(store())

const createPost = async () => {
  await store().createPost();
};
const loadUserId = async () => {
  const route = useRoute();
  await store().loadUserId(Number(route.params.user_id));
};

onMounted(loadUserId);
</script>
