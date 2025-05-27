<template>
  <div>
    <div v-for="post in posts" :key="post.id" class="post-container">
      <router-link :to="`/users/${post.user.id}`">{{ post.user.name }}</router-link>
      :
      <div v-html="post.content"></div>
      <div class="post-meta">Created At: {{ post.created_at }}</div>
    </div>
    <div class="post-container">
      <button v-show="posts.length && !loading && !lastPageReached" class="button" @click="loadMore">Load more</button>
      <p v-show="loading" class="loading">Loading...</p>
      <p v-show="error" class="error">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import {onMounted} from 'vue';
import {storeToRefs} from 'pinia'
import store from '@/components/post/list/store.ts';

const {loading, error, posts, lastPageReached} = storeToRefs(store())

const loadMore = async () => {
  await store().loadMore();
};
const reload = async () => {
  await store().reset();
  await store().loadMore();
};

onMounted(reload);
</script>
