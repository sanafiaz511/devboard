<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

      <div class="p-5 bg-white rounded shadow">
        GitHub Repos
      </div>

      <div class="p-5 bg-white rounded shadow">
        Open PRs
      </div>

      <div class="p-5 bg-white rounded shadow">
        Tasks
      </div>

    </div>
  </AppLayout>
</template>
