import {ref, reactive} from 'vue'
import { defineStore } from 'pinia'
import http from "@/helpers/http";
import router from "@/router";

export const useQuizeStore = defineStore('quize', () => {
  const quize = ref([]);

  const currentQuestion = ref({})
  const order = ref(1)
  const queue = ref(1)
  const result = ref({})
  const answer = ref([])
  const frozen = reactive({
    isFrozen: false,
    frozenTo: null
  })

  const reset = () => {
    quize.value = []
    currentQuestion.value = {}
    currentQuestion.value = {}
    queue.value = 1
    result.value = []
    answer.value = []
    frozen.isFrozen = false
    frozen.frozenTo = null
  }


  return { quize, currentQuestion, order, result, queue, answer, frozen, reset }
})
