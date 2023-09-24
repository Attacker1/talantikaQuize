import {ref, reactive} from 'vue'
import { defineStore } from 'pinia'
import http from "@/helpers/http";
import router from "@/router";

export const useQuizeStore = defineStore('quize', () => {
  const quize = ref([]);

  const currentQuestion = ref({})
  const queue = ref(1)
  const result = ref({})
  const answer = ref([])
  const isFrozen = ref(false)

  const reset = () => {
    quize.value = []
    currentQuestion.value = {}
    currentQuestion.value = {}
    queue.value = 1
    result.value = []
    answer.value = []
    isFrozen.value = false
  }


  return { quize, currentQuestion, result, queue, answer,isFrozen, reset }
})