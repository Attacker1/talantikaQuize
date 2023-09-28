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
            :class="frozen.isFrozen ? 'cursor-not-allowed' : ''"
            :disabled="frozen.isFrozen">
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
import { useNotification } from "@kyvg/vue3-notification";

const { notify }  = useNotification()
const quizeStore = useQuizeStore();
const { answer, currentQuestion, quize, frozen } = storeToRefs(quizeStore);
const timer = {
  isTimer: false
}
const intervalRef = ref(null)
const intervalRefFroze = ref(null)

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

    let isDone = currentQuestion.value.id === quize.value[quize.value.length - 1].id;
    let isPrize = false;
    if(currentQuestion.value.isPrize && isAnswerCorrent) {
      isPrize = true
    }
    let frozenTime = currentQuestion.value.frozenTime;
    if(frozenTime !== null && !isAnswerCorrent) {
      quizeStore.$patch({
        frozen: {
          isFrozen: true,
          frozenTo: frozenTime
        }
      })
      notify({
        title: "Предупреждение",
        type: 'warn',
        text: 'Вы были заморожены, у вас осталось ' + Math.round(frozenTime) + ' секунд заморозки'
      });
    }
    let questionResult = {
      question_id: currentQuestion.value.id,
      isCorrect: isAnswerCorrent,
      question: currentQuestion.value.title,
      answer: answer.value,
      isPrize: isPrize,
      isDone: isDone,
      doneIn: isDone ? (new Date()) : null,
      freezeTo : frozenTime
    }
    postQuizeData(questionResult)
  } else {
    notify({
      title: "Предупреждение",
      type: 'error',
      text: "Вы не дали ответ!"
    });
  }
}

const updateQuestion = (nextQuestion) => {
  quizeStore.$patch({
    queue: nextQuestion,
    currentQuestion: quizeStore.quize.find(x => x.id === Number(nextQuestion)),
    answer: []
  })
}

const postQuizeData = (questionResult) => {
  let nextQuestion = questionResult.isCorrect ? currentQuestion.value.right_order : (currentQuestion.value.wrong_order);
  if(timer.isTimer) {
    nextQuestion = currentQuestion.value.timer_up_order
  }
  http().post('/api/quize/next', questionResult)
    .then((response) => {
      if(questionResult.isDone) {
        router.push({
          name: 'result'
        })
      } else {
        updateQuestion(nextQuestion);
        notify({
          title: questionResult.isCorrect ? 'Успешно!' : 'Неверно!',
          type: questionResult.isCorrect ? 'success' : 'warn',
          text: 'Ваш ответ ' + (questionResult.isCorrect ? 'правильный' : 'неверный')
        });
      }
    })
    .catch((error) => {
      console.error(error)
    });
}

onMounted(() => {
  if(currentQuestion.value.timer !== null) {
    intervalRef.value = setTimeout(() => {
      timer.isTimer = true;
      next()
    }, Number(currentQuestion.value.timer) * 1000)
  }

  if(frozen.value.isFrozen) {
    intervalRefFroze.value = setTimeout(() => {
      quizeStore.$patch({
        frozen: {
          isFrozen: false,
          frozenTo: null
        }
      })
      notify({
        title: 'Ура!',
        type: 'success',
        text: 'Заморозка закончилась! Можете продолжать викторину'
      });
    }, frozen.value.frozenTo * 1000)
  }
})

onUnmounted(() => {
  clearInterval(intervalRef.value)
  clearInterval(intervalRefFroze.value)
  intervalRef.value = null
  intervalRefFroze.value = null
  timer.isTimer = false;
})

</script>