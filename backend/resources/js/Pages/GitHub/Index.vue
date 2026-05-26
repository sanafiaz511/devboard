<script setup>
import { computed } from 'vue'
import { Bar } from 'vue-chartjs'
import AppLayout from '@/Layouts/AppLayout.vue'

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js'

import {
  GitFork,
  GitPullRequest,
  CheckCircle,
  Kanban,
  Github,
  User,
  Activity,
  ArrowUpRight
} from 'lucide-vue-next'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
)

const props = defineProps({
  repos: Array,
  prs: Array,
  analytics: Object,
  error: String
})

const chartData = computed(() => ({
  labels: Object.keys(props.analytics?.languages || {}),
  datasets: [
    {
      label: 'Repositories',
      data: Object.values(props.analytics?.languages || {}),
      borderRadius: 10,
      backgroundColor: [
        '#3B82F6',
        '#8B5CF6',
        '#14B8A6',
        '#F97316',
        '#EC4899',
        '#22C55E'
      ]
    }
  ]
}))

const totalForks = computed(() =>
  props.repos?.reduce((sum, repo) => sum + repo.forks_count, 0) || 0
)
</script>

<template>
  <AppLayout>

    <div class="min-h-screen bg-gray-50 dark:bg-[#0B1120] p-6 space-y-8">

      <!-- HERO -->
      <div
        class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-[#2563EB] via-[#4F46E5] to-[#7C3AED] p-8 shadow-2xl">

        <div
          class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent_30%)]">
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

          <div>

            <div
              class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-white backdrop-blur">

              <Activity class="w-4 h-4" />
              GitHub Developer Insights

            </div>

            <h1 class="mt-5 text-4xl font-bold tracking-tight text-white">
              GitHub Analytics
            </h1>

            <p class="mt-3 max-w-2xl text-blue-100 text-sm md:text-base">
              Track repositories, pull requests, forks, language usage and GitHub activity in a modern analytics dashboard.
            </p>

          </div>

        </div>

      </div>

      <!-- ERROR -->
      <div
        v-if="error"
        class="rounded-2xl border border-red-300 dark:border-red-500/20 bg-red-50 dark:bg-red-500/10 p-4">

        <p class="text-sm text-red-600 dark:text-red-300">
          {{ error }}
        </p>

      </div>

      <!-- ANALYTICS -->
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- REPOS -->
        <div
          class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#111827] p-6 shadow-sm">

          <div
            class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl">
          </div>

          <div class="relative z-10">

            <div class="flex items-center justify-between">

              <div
                class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center">

                <Github class="w-6 h-6 text-blue-600 dark:text-blue-300" />

              </div>

              <span
                class="text-xs font-medium px-2 py-1 rounded-full bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-300">

                Active
              </span>

            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-6">
              Total Repositories
            </p>

            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mt-2">
              {{ analytics?.total_repos || 0 }}
            </h2>

            <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
              <Kanban class="w-4 h-4" />
              Synced from GitHub API
            </div>

          </div>

        </div>

        <!-- PRS -->
        <div
          class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#111827] p-6 shadow-sm">

          <div
            class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl">
          </div>

          <div class="relative z-10">

            <div class="flex items-center justify-between">

              <div
                class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-500/20 flex items-center justify-center">

                <GitPullRequest class="w-6 h-6 text-purple-600 dark:text-purple-300" />

              </div>

              <span
                class="text-xs font-medium px-2 py-1 rounded-full bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-300">

                Contributions
              </span>

            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-6">
              Pull Requests
            </p>

            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mt-2">
              {{ prs?.length || 0 }}
            </h2>

            <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
              <CheckCircle class="w-4 h-4" />
              Repository contribution metrics
            </div>

          </div>

        </div>

        <!-- FORKS -->
        <div
          class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#111827] p-6 shadow-sm">

          <div
            class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl">
          </div>

          <div class="relative z-10">

            <div class="flex items-center justify-between">

              <div
                class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center">

                <GitFork class="w-6 h-6 text-emerald-600 dark:text-emerald-300" />

              </div>

              <span
                class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-300">

                Open Source
              </span>

            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-6">
              Total Forks
            </p>

            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mt-2">
              {{ totalForks }}
            </h2>

            <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
              <GitFork class="w-4 h-4" />
              Repository duplication analytics
            </div>

          </div>

        </div>

        <!-- CONTRIBUTORS -->
        <div
          class="relative overflow-hidden rounded-3xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#111827] p-6 shadow-sm">

          <div
            class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl">
          </div>

          <div class="relative z-10">

            <div class="flex items-center justify-between">

              <div
                class="w-12 h-12 rounded-2xl bg-orange-100 dark:bg-orange-500/20 flex items-center justify-center">

                <User class="w-6 h-6 text-orange-600 dark:text-orange-300" />

              </div>

              <span
                class="text-xs font-medium px-2 py-1 rounded-full bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-300">

                Developers
              </span>

            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-6">
              Contributors
            </p>

            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mt-2">
              {{ repos?.length || 0 }}
            </h2>

            <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
              <User class="w-4 h-4" />
              GitHub connected accounts
            </div>

          </div>

        </div>

      </div>

      <!-- CHART -->
      <div
        class="rounded-3xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#111827] p-6 shadow-sm">

        <div class="flex items-center justify-between mb-8">

          <div>

            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
              Language Distribution
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
              Technologies used across repositories
            </p>

          </div>

        </div>

        <div
          v-if="Object.keys(analytics?.languages || {}).length"
          class="h-96">

          <Bar
            :data="chartData"
            :options="{
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: false
                }
              }
            }"
          />

        </div>

        <div
          v-else
          class="py-20 text-center text-gray-500 dark:text-gray-400">

          No language analytics available

        </div>

      </div>

      <!-- REPOSITORIES + PRS -->
      <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

        <!-- REPOSITORIES -->
        <div
          class="rounded-3xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#111827] p-6 shadow-sm">

          <div class="flex items-center justify-between mb-6">

            <div>

              <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Repositories
              </h2>

              <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ repos?.length || 0 }} repositories found
              </p>

            </div>

          </div>

          <div class="space-y-4 max-h-[700px] overflow-y-auto pr-2">

            <div
              v-if="!repos?.length"
              class="py-20 text-center text-gray-500 dark:text-gray-400">

              No repositories found

            </div>

            <a
              v-for="repo in repos"
              :key="repo.id"
              :href="repo.html_url"
              target="_blank"
              class="group block rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/[0.03] p-5 hover:border-blue-500/40 hover:shadow-lg transition-all duration-300">

              <div class="flex justify-between gap-4">

                <div class="flex-1">

                  <div class="flex items-center gap-2">

                    <h3
                      class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-500 transition">

                      {{ repo.name }}

                    </h3>

                    <ArrowUpRight
                      class="w-4 h-4 text-gray-400 group-hover:text-blue-500" />

                  </div>

                  <p
                    class="text-sm text-gray-500 dark:text-gray-400 mt-2 line-clamp-2">

                    {{ repo.description || 'No description available' }}

                  </p>

                  <div class="flex gap-6 mt-5 text-sm text-gray-500">

                    <div class="flex items-center gap-1">
                      <Github class="w-4 h-4" />
                      {{ repo.stargazers_count }}
                    </div>

                    <div class="flex items-center gap-1">
                      <GitFork class="w-4 h-4" />
                      {{ repo.forks_count }}
                    </div>

                  </div>

                </div>

                <span
                  v-if="repo.language"
                  class="h-fit rounded-full bg-blue-100 dark:bg-blue-500/20 px-3 py-1 text-xs font-medium text-blue-700 dark:text-blue-300">

                  {{ repo.language }}

                </span>

              </div>

            </a>

          </div>

        </div>

        <!-- PULL REQUESTS -->
        <div
          class="rounded-3xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#111827] p-6 shadow-sm">

          <div class="flex items-center justify-between mb-6">

            <div>

              <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                Pull Requests
              </h2>

              <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ prs?.length || 0 }} pull requests found
              </p>

            </div>

          </div>

          <div class="space-y-4 max-h-[700px] overflow-y-auto pr-2">

            <div
              v-if="!prs?.length"
              class="py-20 text-center text-gray-500 dark:text-gray-400">

              No pull requests found

            </div>

            <a
              v-for="pr in prs"
              :key="pr.id"
              :href="pr.html_url"
              target="_blank"
              class="group block rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/[0.03] p-5 hover:border-purple-500/40 hover:shadow-lg transition-all duration-300">

              <div class="flex justify-between gap-4">

                <div class="flex-1">

                  <div class="flex items-center gap-2">

                    <h3
                      class="font-semibold text-gray-900 dark:text-white group-hover:text-purple-500 transition">

                      {{ pr.title }}

                    </h3>

                    <ArrowUpRight
                      class="w-4 h-4 text-gray-400 group-hover:text-purple-500" />

                  </div>

                  <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    {{ pr.user?.login }}
                  </p>

                </div>

                <span
                  :class="[
                    'h-fit rounded-full px-3 py-1 text-xs font-medium',
                    pr.state === 'open'
                      ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300'
                      : 'bg-gray-100 text-gray-700 dark:bg-gray-700/40 dark:text-gray-300'
                  ]">

                  {{ pr.state }}

                </span>

              </div>

            </a>

          </div>

        </div>

      </div>

    </div>

  </AppLayout>
</template>
