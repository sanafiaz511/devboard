<script setup>
    import { Bar } from 'vue-chartjs'
    import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
    } from 'chart.js'

    ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

    const props = defineProps({
    repos: Array,
    prs: Array,
    analytics: Object,
    error: String
    })

    const chartData = {
    labels: Object.keys(props.analytics?.languages || {}),
    datasets: [
        {
        label: 'Repositories by Language',
        data: Object.values(props.analytics?.languages || {})
        }
    ]
    }
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">GitHub Analytics</h1>

    <p v-if="error" class="text-red-500">{{ error }}</p>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

      <div class="p-4 bg-white shadow rounded">
        Total Repositories: {{ analytics.total_repos }}
      </div>

    </div>

    <!-- Chart -->
    <div class="bg-white p-4 rounded shadow mb-6">
      <Bar :data="chartData" />
    </div>

    <!-- Lists -->
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
