<script setup>
defineProps({
  repos: Array,
  prs: Array,
  error: String
})
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">GitHub Dashboard</h1>

    <p v-if="error" class="text-red-500">{{ error }}</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-semibold mb-2">Repositories</h2>
        <ul>
          <li v-for="repo in repos" :key="repo.id">
            {{ repo.name }}
          </li>
        </ul>
      </div>

      <div class="p-4 bg-white rounded shadow">
        <h2 class="font-semibold mb-2">Pull Requests</h2>
        <ul>
          <li v-for="pr in prs" :key="pr.id">
            {{ pr.title }}
          </li>
        </ul>
      </div>

    </div>
  </div>
</template>
