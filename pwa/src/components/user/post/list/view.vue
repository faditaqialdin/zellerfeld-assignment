<template>
  <div>
    <div v-for="post in posts" :key="post.id" class="post-container">
      <div v-html="post.content"></div>
      <div class="post-meta">{{ post.created_at }}</div>
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
import store from '@/components/user/post/list/store.ts';
import {useRoute} from 'vue-router';

const route = useRoute();

const {loading, error, posts, lastPageReached} = storeToRefs(store())

const reload = async () => {
  await store().reset();
  await store().loadMore(Number(route.params.user_id));
};

onMounted(reload);
</script>
