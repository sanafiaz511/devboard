import { defineStore } from 'pinia'

export const useActivityStore = defineStore('activity', {
  state: () => ({
    activities: []
  }),

  actions: {
    setActivities(data) {
      this.activities = data
    },
    addActivity(activity) {
      this.activities.unshift(activity)
    }
  }
})
