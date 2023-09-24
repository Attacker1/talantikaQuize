<template>
  <QuestionView>
    <div class="flex items-center mb-4" v-for="(question, index) in answers">
      <input :id="'default-radio-' + index" type="radio" v-model="answer" :value="question" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
      <label :for="'default-radio-' + index" class="ml-2 text-sm font-medium">{{question}}</label>
    </div>
  </QuestionView>
</template>
<script setup>
import QuestionView from "@/views/questions/QuestionView.vue";
import {useQuizeStore} from "@/stores/quize";
import {computed, toRefs} from "vue";
const quize = useQuizeStore();

const { answer } = toRefs(quize);
const answers = computed(() => quize.currentQuestion.rightAnswer.concat(quize.currentQuestion.wrongAnswers).sort(() => Math.random() - 0.5));
</script>