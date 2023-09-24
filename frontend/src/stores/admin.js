import {ref, computed, reactive} from 'vue'
import { defineStore } from 'pinia'

export const useAdminStore = defineStore('adminStore', () => {
  const isAdmin = ref(false);

  const results = ref([]);

  return { isAdmin, results }
})
