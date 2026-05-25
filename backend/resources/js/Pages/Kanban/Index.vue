<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
  board: Object
})
</script>

<template>
  <AppLayout>

    <div class="mb-6">
      <h1 class="text-2xl font-bold">
        {{ board.name }}
      </h1>
    </div>

    <div class="flex gap-4 overflow-x-auto">

      <div
        v-for="column in board.columns"
        :key="column.id"
        class="bg-gray-100 rounded p-3 w-72 flex-shrink-0"
      >
        <!-- Column Header -->
        <h2 class="font-semibold mb-3">
          {{ column.name }}
        </h2>

        <!-- Tasks -->
        <div class="space-y-2">

          <div
            v-for="task in column.tasks"
            :key="task.id"
            class="bg-white p-3 rounded shadow cursor-pointer"
          >
            {{ task.title }}
          </div>

        </div>

      </div>

    </div>

  </AppLayout>
</template>
