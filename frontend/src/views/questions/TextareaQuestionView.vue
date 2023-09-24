<template>
  <QuestionView>
    <textarea id="message" rows="4" v-model="answer" class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-black focus:outline-none" placeholder="Напишите свои мысли здесь"></textarea>
  </QuestionView>
</template>
<script setup>
import QuestionView from "@/views/questions/QuestionView.vue";
import {useQuizeStore} from "@/stores/quize";
import {toRefs} from "vue";
const quize = useQuizeStore();

const { answer } = toRefs(quize);
</script>