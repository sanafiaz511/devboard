<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import draggable from 'vuedraggable'
import axios from 'axios'
import { useActivityStore } from '@/stores/activityStore'

const activityStore = useActivityStore()
const props = defineProps({
  board: Object
})

const boardState = ref(JSON.parse(JSON.stringify(props.board)))
const loading = ref(true)

onMounted(async () => {
  const res = await axios.get('/activities')
  activityStore.setActivities(res.data)

   try {
    const res = await axios.get('/board')
    boardState.value = res.data
  } finally {
    loading.value = false
  }
})

function applyTaskMoved(event) {
  const task = event.task
  if (!task) {
    return
  }

  const sourceColumn = boardState.value.columns.find((column) =>
    column.tasks.some((t) => t.id === task.id),
  )
  const targetColumn = boardState.value.columns.find(
    (column) => column.id === task.board_column_id,
  )

  if (!targetColumn) {
    return
  }

  if (sourceColumn) {
    const taskIndex = sourceColumn.tasks.findIndex((t) => t.id === task.id)
    if (taskIndex !== -1) {
      sourceColumn.tasks.splice(taskIndex, 1)
    }
  }

  targetColumn.tasks.splice(Number(task.position), 0, task)

  targetColumn.tasks = targetColumn.tasks
    .sort((a, b) => a.position - b.position)
    .map((t, index) => ({ ...t, position: index }))
}

onMounted(() => {
  if (!window.Echo) {
    console.warn('Echo is not initialized')
    return
  }

  window.Echo.channel('kanban').listen('.task.moved', (event) => {
    console.log('Realtime update:', event)
    applyTaskMoved(event)
  })

    window.Echo.channel('activity')
    .listen('.activity.created', (event) => {
    activityStore.addActivity(event.activity)
    })
})

onBeforeUnmount(() => {
  if (window.Echo) {
    window.Echo.leave('kanban')
  }
})

function onDrag(column) {
  column.tasks.forEach((task, index) => {
    axios.post('/kanban/tasks/move', {
      task_id: task.id,
      board_column_id: column.id,
      position: index,
    })
  })
}
</script>

<template>
  <AppLayout>

    <!-- LOADING STATE -->
    <div v-if="loading" class="p-6 animate-pulse text-gray-500">
      Loading board...
    </div>

    <!-- MAIN BOARD -->
    <div v-else>

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

          <h2 class="font-semibold mb-3">
            {{ column.name }}
          </h2>

          <draggable
            v-model="column.tasks"
            group="tasks"
            item-key="id"
            class="space-y-2 min-h-[100px]"
            @change="onDrag(column)"
          >
            <template #item="{ element }">
              <div class="bg-white p-3 rounded shadow cursor-move hover:shadow-md transition">
                {{ element.title }}
              </div>
            </template>
          </draggable>

          <div v-if="column.tasks.length === 0" class="text-gray-400 text-sm mt-2">
            No tasks yet
          </div>

        </div>

      </div>

    </div>

  </AppLayout>
</template>
