<script setup>
import { Link } from '@inertiajs/vue3'
import { useActivityStore } from '../stores/activityStore'
import { onMounted, ref } from 'vue'
import axios from 'axios'

import {
  LayoutDashboard,
  GitBranch,
  CheckSquare,
  Settings,
  Bell
} from 'lucide-vue-next'

const darkMode = ref(false)
const sidebarOpen = ref(true)
const activityOpen = ref(false)
const userMenuOpen = ref(false)
const notifications = ref(3)

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
  }).catch(() => {
    darkMode.value = !darkMode.value
    applyTheme()
  })
}

function applyTheme() {
  document.documentElement.classList.toggle('dark', darkMode.value)
}
</script>

<template>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">

    <!-- SIDEBAR -->
    <aside
        :class="[
        'bg-white dark:bg-gray-900 border-r dark:border-gray-800 transition-all duration-300 flex flex-col',
        sidebarOpen ? 'w-64' : 'w-16'
        ]"
    >

        <!-- BRAND -->
        <div class="p-4 flex items-center justify-between border-b dark:border-gray-800">
        <span v-if="sidebarOpen" class="font-bold text-blue-600 dark:text-blue-400">
            DevBoard
        </span>

        <button
            @click="sidebarOpen = !sidebarOpen"
            class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded"
        >
            ☰
        </button>
        </div>

        <!-- NAV -->
        <nav class="p-3 space-y-2 text-sm">

        <Link href="/" class="flex items-center gap-2 p-2 rounded hover:bg-blue-50 dark:hover:bg-gray-800 transition">
            <LayoutDashboard class="w-4 h-4 text-blue-500" />
            <span v-if="sidebarOpen">Dashboard</span>
        </Link>

        <Link href="/github" class="flex items-center gap-2 p-2 rounded hover:bg-purple-50 dark:hover:bg-gray-800 transition">
            <GitBranch class="w-4 h-4 text-purple-500" />
            <span v-if="sidebarOpen">GitHub</span>
        </Link>

        <Link href="/kanban" class="flex items-center gap-2 p-2 rounded hover:bg-green-50 dark:hover:bg-gray-800 transition">
            <CheckSquare class="w-4 h-4 text-green-500" />
            <span v-if="sidebarOpen">Tasks</span>
        </Link>

        <Link href="/settings" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            <Settings class="w-4 h-4 text-gray-500" />
            <span v-if="sidebarOpen">Settings</span>
        </Link>

        </nav>
    </aside>

    <!-- MAIN -->
    <div class="flex flex-1 flex-col">

        <!-- TOPBAR -->
        <header class="h-14 bg-white dark:bg-gray-900 border-b dark:border-gray-800 flex items-center justify-between px-4">

        <h1 class="text-sm font-semibold">Dashboard</h1>

        <div class="flex items-center gap-2">
            <button
            @click="toggleTheme"
            class="px-3 py-1 text-xs rounded bg-gray-100 dark:bg-gray-800"
            >
            Theme
            </button>
        </div>

        <div class="flex items-center gap-3 relative">

            <!-- NOTIFICATIONS -->
            <button class="relative p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800">
            <Bell class="w-4 h-4" />
            <span v-if="notifications"
                class="absolute -top-1 -right-1 text-[10px] bg-red-500 text-white px-1 rounded-full">
                {{ notifications }}
            </span>
            </button>

            <!-- ACTIVITY -->
            <button
            @click="activityOpen = !activityOpen"
            class="text-xs px-2 py-1 rounded bg-gray-100 dark:bg-gray-800"
            >
            Activity
            </button>

            <!-- USER -->
            <div class="relative">
            <button
                @click="userMenuOpen = !userMenuOpen"
                class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-700"
            />

            <div
                v-if="userMenuOpen"
                class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-900 border dark:border-gray-800 rounded shadow-lg text-sm"
            >
                <a class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800">Profile</a>
                <a class="block px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-800">Settings</a>

                <Link
                href="/logout"
                method="post"
                as="button"
                class="w-full text-left px-3 py-2 hover:bg-red-500 hover:text-white"
                >
                Logout
                </Link>
            </div>
            </div>

        </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 p-6 overflow-y-auto">
        <slot />
        </main>

    </div>

    <!-- ACTIVITY PANEL -->
    <aside
        v-if="activityOpen"
        class="w-72 bg-white dark:bg-gray-900 border-l dark:border-gray-800 p-4 overflow-y-auto"
    >
        <div class="flex justify-between mb-3">
        <h3 class="font-semibold">Activity</h3>
        <button @click="activityOpen = false">✕</button>
        </div>

        <div class="space-y-2">
        <div
            v-for="item in activityStore.activities"
            :key="item.id"
            class="text-sm p-2 rounded bg-gray-50 dark:bg-gray-800"
        >
            {{ item.message }}
        </div>
        </div>
    </aside>

    </div>
</template>
