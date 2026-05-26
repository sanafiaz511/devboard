<script setup>
import AppLayout from '../Layouts/AppLayout.vue'

import {
  GitFork,
  GitPullRequest,
  CheckCircle,
  Kanban,
  Github,
  User
} from 'lucide-vue-next'

const props = defineProps({
  stats: Object
})

console.log(props.stats)
</script>

<template>
  <AppLayout>
    <div class="space-y-10">

      <!-- HERO -->
      <div class="rounded-xl p-10 bg-white dark:bg-gray-900 border-l-4 border-blue-500 shadow-sm">

        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">
          Welcome to DevBoard
        </h1>

        <p class="mt-2 text-gray-600 dark:text-gray-400">
          Manage tasks, repositories, and workflows in one place
        </p>

      </div>

      <!-- STATS -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="p-6 rounded-xl bg-white dark:bg-gray-900 border hover:border-blue-400 transition">
          <div class="flex justify-between">
            <div>
              <p class="text-xs text-gray-500">Repositories</p>
              <p class="text-3xl font-semibold mt-2">{{ stats?.repos }}</p>
            </div>
            <GitFork class="w-5 h-5 text-blue-500" />
          </div>
        </div>

        <div class="p-6 rounded-xl bg-white dark:bg-gray-900 border hover:border-purple-400 transition">
          <div class="flex justify-between">
            <div>
              <p class="text-xs text-gray-500">Pull Requests</p>
              <p class="text-3xl font-semibold mt-2">{{ stats?.prs }}</p>
            </div>
            <GitPullRequest class="w-5 h-5 text-purple-500" />
          </div>
        </div>

        <div class="p-6 rounded-xl bg-white dark:bg-gray-900 border hover:border-green-400 transition">
          <div class="flex justify-between">
            <div>
              <p class="text-xs text-gray-500">Tasks</p>
              <p class="text-3xl font-semibold mt-2">{{ stats?.tasks }}</p>
            </div>
            <CheckCircle class="w-5 h-5 text-green-500" />
          </div>
        </div>

      </div>

      <!-- QUICK LINKS -->
      <div class="bg-white dark:bg-gray-900 border rounded-xl p-6">

        <h2 class="text-lg font-semibold mb-4">Quick Actions</h2>

        <div class="grid md:grid-cols-3 gap-4">

          <a href="/kanban"
             class="p-4 border rounded hover:border-blue-400 hover:bg-blue-50/30 dark:hover:bg-gray-800 transition">

            <Kanban class="w-4 h-4 text-blue-500 mb-2" />
            <p class="font-medium">Kanban Board</p>
            <p class="text-sm text-gray-500">Manage tasks visually</p>
          </a>

          <a href="/github"
             class="p-4 border rounded hover:border-purple-400 hover:bg-purple-50/30 dark:hover:bg-gray-800 transition">

            <Github class="w-4 h-4 text-purple-500 mb-2" />
            <p class="font-medium">GitHub</p>
            <p class="text-sm text-gray-500">Repositories & PRs</p>
          </a>

          <a href="/profile"
             class="p-4 border rounded hover:border-green-400 hover:bg-green-50/30 dark:hover:bg-gray-800 transition">

            <User class="w-4 h-4 text-green-500 mb-2" />
            <p class="font-medium">Profile</p>
            <p class="text-sm text-gray-500">Account settings</p>
          </a>

        </div>

      </div>

    </div>
  </AppLayout>
</template>
