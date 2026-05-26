<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import draggable from 'vuedraggable'
import axios from 'axios'
import { useActivityStore } from '@/stores/activityStore'

import {
  Kanban,
  Circle,
  CheckCircle2,
  Clock3,
  Activity,
  ArrowRight,
  Users,
  Sparkles
} from 'lucide-vue-next'

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
    const boardRes = await axios.get('/board')
    boardState.value = boardRes.data
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

  window.Echo.channel('kanban')
    .listen('.task.moved', (event) => {
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

function getColumnIcon(name) {
  const lower = name.toLowerCase()

  if (lower.includes('todo')) return Circle
  if (lower.includes('progress')) return Clock3
  if (lower.includes('done')) return CheckCircle2

  return Kanban
}

function getColumnColor(name) {
  const lower = name.toLowerCase()

  if (lower.includes('todo')) {
    return {
      bg: 'bg-blue-500/10',
      text: 'text-blue-500',
      border: 'border-blue-500/20'
    }
  }

  if (lower.includes('progress')) {
    return {
      bg: 'bg-amber-500/10',
      text: 'text-amber-500',
      border: 'border-amber-500/20'
    }
  }

  if (lower.includes('done')) {
    return {
      bg: 'bg-emerald-500/10',
      text: 'text-emerald-500',
      border: 'border-emerald-500/20'
    }
  }

  return {
    bg: 'bg-purple-500/10',
    text: 'text-purple-500',
    border: 'border-purple-500/20'
  }
}
</script>

<template>
  <AppLayout>

    <!-- LOADING -->
    <div
      v-if="loading"
      class="min-h-[70vh] flex items-center justify-center">

      <div class="text-center">

        <div
          class="w-14 h-14 rounded-2xl border-4 border-blue-500/20 border-t-blue-500 animate-spin mx-auto">
        </div>

        <p class="mt-5 text-gray-500 dark:text-gray-400">
          Loading workspace...
        </p>

      </div>

    </div>

    <!-- BOARD -->
    <div
      v-else
      class="min-h-screen bg-gray-50 dark:bg-[#0B1120] p-6 space-y-8">

      <!-- HERO -->
      <div
        class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-[#2563EB] via-[#4F46E5] to-[#7C3AED] p-8 shadow-2xl">

        <div
          class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_35%)]">
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

          <div>

            <div
              class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-white backdrop-blur">

              <Sparkles class="w-4 h-4" />
              Realtime Collaboration Board

            </div>

            <h1 class="mt-5 text-4xl font-bold tracking-tight text-white">
              {{ boardState.name }}
            </h1>

            <p class="mt-3 max-w-2xl text-blue-100 text-sm md:text-base">
              Organize tasks, track progress and collaborate with your team in realtime.
            </p>

          </div>

        </div>

      </div>

      <!-- BOARD COLUMNS -->
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">

        <div
          v-for="column in boardState.columns"
          :key="column.id"
          class="min-w-0">

          <div
            class="rounded-3xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#111827] shadow-sm overflow-hidden">

            <!-- COLUMN HEADER -->
            <div
              class="p-5 border-b border-gray-200 dark:border-white/10">

              <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">

                  <div
                    :class="[
                      'w-11 h-11 rounded-2xl flex items-center justify-center border',
                      getColumnColor(column.name).bg,
                      getColumnColor(column.name).border
                    ]">

                    <component
                      :is="getColumnIcon(column.name)"
                      :class="[
                        'w-5 h-5',
                        getColumnColor(column.name).text
                      ]"
                    />

                  </div>

                  <div>

                    <h2
                      class="font-semibold text-gray-900 dark:text-white">

                      {{ column.name }}

                    </h2>

                    <p
                      class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">

                      {{ column.tasks.length }} tasks

                    </p>

                  </div>

                </div>

                <div
                  class="rounded-full bg-gray-100 dark:bg-white/5 px-3 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">

                  {{ column.tasks.length }}

                </div>

              </div>

            </div>

            <!-- TASKS -->
            <div class="p-4">

              <draggable
                v-model="column.tasks"
                group="tasks"
                item-key="id"
                class="space-y-4 min-h-[500px]"
                @change="onDrag(column)"
              >

                <template #item="{ element }">

                  <div
                    class="group rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/[0.03] p-5 hover:border-blue-500/30 hover:shadow-xl transition-all duration-300 cursor-move">

                    <div class="flex items-start justify-between gap-3">

                      <div class="flex-1">

                        <div class="flex items-center gap-2">

                          <div
                            class="w-2 h-2 rounded-full bg-blue-500">
                          </div>

                          <h3
                            class="font-semibold text-gray-900 dark:text-white">

                            {{ element.title }}

                          </h3>

                        </div>

                        <p
                          v-if="element.description"
                          class="mt-3 text-sm leading-6 text-gray-500 dark:text-gray-400">

                          {{ element.description }}

                        </p>

                      </div>

                      <ArrowRight
                        class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition" />

                    </div>

                    <!-- FOOTER -->
                    <div
                      class="mt-5 flex items-center justify-between">

                      <div
                        class="inline-flex items-center gap-2 rounded-full bg-gray-100 dark:bg-white/5 px-3 py-1 text-xs text-gray-600 dark:text-gray-300">

                        <Activity class="w-3 h-3" />
                        Task #{{ element.id }}

                      </div>

                    </div>

                  </div>

                </template>

              </draggable>

              <!-- EMPTY -->
              <div
                v-if="column.tasks.length === 0"
                class="flex flex-col items-center justify-center py-20 text-center">

                <div
                  class="w-16 h-16 rounded-3xl bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-4">

                  <Kanban class="w-7 h-7 text-gray-400" />

                </div>

                <h3
                  class="text-sm font-medium text-gray-700 dark:text-gray-300">

                  No tasks yet

                </h3>

                <p
                  class="text-xs text-gray-500 dark:text-gray-400 mt-1">

                  Drag tasks here to organize workflow

                </p>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </AppLayout>
</template>
