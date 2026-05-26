<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import draggable from 'vuedraggable'
import axios from 'axios'

const props = defineProps({
  board: Object
})

const boardState = ref(props.board)

function onDrag(column) {
  column.tasks.forEach((task, index) => {
    axios.post('/kanban/tasks/move', {
      task_id: task.id,
      board_column_id: column.id,
      position: index
    })
  })
}
</script>

<template>
  <AppLayout>

    <div class="mb-6">
      <h1 class="text-2xl font-bold">
        {{ boardState.name }}
      </h1>
    </div>

    <!-- Columns -->
    <div class="flex gap-4 overflow-x-auto">

      <div
        v-for="column in boardState.columns"
        :key="column.id"
        class="bg-gray-100 rounded p-3 w-72 flex-shrink-0"
      >

        <!-- Column Title -->
        <h2 class="font-semibold mb-3">
          {{ column.name }}
        </h2>

        <!-- DRAGGABLE TASKS -->
        <draggable
            v-model="column.tasks"
            group="tasks"
            item-key="id"
            class="space-y-2 min-h-[100px]"
            @change="onDrag(column)"
            >

          <template #item="{ element }">
            <div
              class="bg-white p-3 rounded shadow cursor-move hover:shadow-md transition"
            >
              {{ element.title }}
            </div>
          </template>

        </draggable>

      </div>

    </div>

  </AppLayout>
</template>
