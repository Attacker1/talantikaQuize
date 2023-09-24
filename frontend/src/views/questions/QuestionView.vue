<template>
  <div class="pt-10">
    <h1 class="text-3xl font-semibold mb-4">{{currentQuestion.title}}</h1>
    <div>
      <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
        <div class="bg-white px-4 py-5 sm:p-6">
          <slot></slot>
        </div>
        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
          <button
            @click="next"
            class="inline-flex justify-center rounded-md border border-transparent bg-black py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none"
            :class="isFrozen ? 'cursor-not-allowed' : ''">
            Отправить</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import {useRouter} from "vue-router";
import {useQuizeStore} from "@/stores/quize";
import {computed, onMounted, onUnmounted, ref, toRefs} from "vue";
import {storeToRefs} from "pinia";
import http from "@/helpers/http";
const quizeStore = useQuizeStore();
const { answer, currentQuestion, quize, isFrozen } = storeToRefs(quizeStore);
const timer = {
  isTimer: false
}
const intervalRef = ref(null)

const router = useRouter();

const next = () => {
  let isAnswerCorrent = false;
  if(Object.keys(answer.value).length !== 0 || typeof answer.value === "number" || timer.isTimer) {
    if (currentQuestion.value.rightAnswer !== null && currentQuestion.value.wrongAnswers !== null) {
      switch (currentQuestion.value.questionType) {
        case 'text':
        case 'textarea':
          isAnswerCorrent = answer.value.replace(/[^\w\s]/gi, '').trim().toUpperCase() === currentQuestion.value.rightAnswer.toUpperCase();
          break;
        case 'number':
          isAnswerCorrent = answer.value.toString() === currentQuestion.value.rightAnswer;
          break;
        case 'radio':
          isAnswerCorrent = answer.value === currentQuestion.value.rightAnswer[0];
          break;
        case 'checkbox':
          isAnswerCorrent = answer.value.sort().join(',') === currentQuestion.value.rightAnswer.sort().join(',');
          break;
      }
    } else {
      isAnswerCorrent = true;
    }
    let nextQuestion = isAnswerCorrent ? currentQuestion.value.right_order : (currentQuestion.value.wrong_order);
    if(timer.isTimer) {
      nextQuestion = currentQuestion.value.timer_up_order
    }
    let isDone = currentQuestion.value.id === quize.value[quize.value.length - 1].id;
    let isPrize = false;
    if(currentQuestion.value.isPrize && isAnswerCorrent) {
      isPrize = true
    }
    let questionResult = {
      question_id: currentQuestion.value.id,
      isCorrect: isAnswerCorrent,
      question: currentQuestion.value.title,
      answer: answer.value,
      isPrize: isPrize,
      isDone: isDone,
      doneIn: isDone ? (new Date()) : null
    }
    http().post('/api/quize/next', questionResult)
      .then((response) => {
        if(isDone) {
          router.push({
            name: 'result'
          })
        } else {
          updateQuestion(nextQuestion);
        }
      })
      .catch((error) => {
        console.error(error)
      });
  } else {
    // здесь алерт
  }
}

const updateQuestion = (nextQuestion) => {
  quizeStore.$patch({
    queue: nextQuestion,
    currentQuestion: quizeStore.quize.find(x => x.id === Number(nextQuestion)),
    answer: []
  })
}

onMounted(() => {
  if(currentQuestion.value.timer !== null) {
    intervalRef.value = setTimeout(() => {
      timer.isTimer = true;
      next()
    }, Number(currentQuestion.value.timer) * 1000)
  }
})

onUnmounted(() => {
  clearInterval(intervalRef.value)
  intervalRef.value = null
  timer.isTimer = false;
})

</script>