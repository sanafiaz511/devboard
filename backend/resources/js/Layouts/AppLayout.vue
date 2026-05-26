<script setup>
import { Link } from '@inertiajs/vue3'
import { useActivityStore } from '../stores/activityStore'
import { onMounted, ref } from 'vue'
import axios from 'axios'

const darkMode = ref(false)
const activityStore = useActivityStore()

onMounted(() => {
  darkMode.value = window.user?.dark_mode || false
  applyTheme()
})

function toggleTheme() {
  darkMode.value = !darkMode.value
  applyTheme()

  axios.post('/user/theme', {
    dark_mode: darkMode.value
  }).catch((error) => {
    console.error('Theme toggle error:', error.response?.data || error.message)
    darkMode.value = !darkMode.value
    applyTheme()
  })
}

function applyTheme() {
  if (darkMode.value) {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }
}

</script>
<template>
    <div class="flex h-screen bg-gray-100 dark:bg-gray-950">

    <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white dark:bg-gray-800 hidden md:flex flex-col">
        <div class="p-5 text-xl font-bold border-b border-gray-700 dark:border-gray-600">
            DevBoard
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="/" class="block px-3 py-2 rounded hover:bg-gray-700 dark:hover:bg-gray-600">
            Dashboard
            </a>

            <a href="/github" class="block px-3 py-2 rounded hover:bg-gray-700 dark:hover:bg-gray-600">
            GitHub
            </a>

            <a href="/kanban" class="block px-3 py-2 rounded hover:bg-gray-700 dark:hover:bg-gray-600">
            Tasks (Kanban)
            </a>

            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-700 dark:hover:bg-gray-600">
            Settings
            </a>
        </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">

        <!-- Topbar -->
        <header class="h-14 bg-white dark:bg-gray-900 shadow flex items-center justify-between px-4">

            <h1 class="font-semibold text-gray-700 dark:text-gray-300">
            Dashboard
            </h1>

            <div class="flex items-center gap-3">

                <button
                    @click="toggleTheme"
                    class="px-3 py-1 text-sm bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded"
                    >
                    Toggle Theme
                </button>

                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 dark:hover:bg-red-700 text-white rounded"
                >
                    Logout
                </Link>

            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            <slot />
        </main>

        </div>
        <div class="w-64 bg-white dark:bg-gray-900 border-l dark:border-gray-700 p-3 overflow-y-auto">
            <h3 class="font-bold mb-3 text-gray-900 dark:text-white">Activity</h3>

            <div class="w-64 bg-white dark:bg-gray-900 border-l dark:border-gray-700 p-3">
                <div v-for="item in activityStore.activities" :key="item.id" class="text-gray-900 dark:text-gray-300">
                    {{ item.message }}
                </div>
            </div>
        </div>
    </div>

</template>
