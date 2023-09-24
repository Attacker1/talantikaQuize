<template>
  <div class="question">
    <Header/>
    <CheckboxQuestionView v-if="currentQuestion.questionType === 'checkbox'" />
    <RadioQuestionView v-if="currentQuestion.questionType === 'radio'" />
    <TextQuestionView v-if="['text', 'number'].includes(currentQuestion.questionType)" />
    <TextareaQuestionView v-if="currentQuestion.questionType === 'textarea'" />
  </div>
</template>
<script setup>
import {useRouter} from "vue-router";
import CheckboxQuestionView from "@/views/questions/CheckboxQuestionView.vue";
import RadioQuestionView from "@/views/questions/RadioQuestionView.vue";
import {useQuizeStore} from "@/stores/quize";
import {onMounted} from "vue";
import http from "@/helpers/http";
import TextareaQuestionView from "@/views/questions/TextareaQuestionView.vue";
import TextQuestionView from "@/views/questions/TextQuestionView.vue";
import {storeToRefs} from "pinia";
import Header from "@/components/Header.vue";

const quizeStore = useQuizeStore();

const { currentQuestion, queue, quize } = storeToRefs(quizeStore);

const router = useRouter();

const updateCurrent = () => {
  http().get('/api/results')
    .then((response) => {
      if(response.data !== '') {
        if(response.data.isDone === 1) {
          router.push({
            name: 'result'
          })
        } else {
          let lastResult = response.data.results[response.data.results.length - 1];
          let lastQuestion = quize.value.find(x => x.id === lastResult.question_id);
          let now = quize.value.find(x => x.id === Number(lastResult.isCorrect ? lastQuestion.right_order : lastQuestion.wrong_order));
          quizeStore.$patch({
            queue: now.id,
            currentQuestion: now,
            answer: []
          })
        }
      } else {
        quizeStore.$patch({
          currentQuestion: quize.value[0]
        })
      }
    })
}

onMounted(async () => {
   await http().get('/api/quize')
    .then((response) => {
      quizeStore.$patch({
        quize: response.data
      })
    });

    updateCurrent()
})
</script>