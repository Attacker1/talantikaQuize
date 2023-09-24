<template>
  <Header/>
  <div class="pt-10">
    <h1 class="text-3xl font-semibold mb-4">Вы прошли тест! Ваш результат:</h1>
    <div>
      <div class="overflow-hidden shadow sm:rounded-md max-w-2xl mx-auto text-left">
        <div class="bg-white px-4 py-5 sm:p-6">
          <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                  <table class="min-w-full text-center text-sm font-light">
                    <thead class="border-b font-medium dark:border-neutral-500">
                    <tr>
                      <th scope="col" class="px-6 py-4">Вопрос</th>
                      <th scope="col" class="px-6 py-4">Ваш ответ</th>
                      <th scope="col" class="px-6 py-4">Статус</th>
                      <th scope="col" class="px-6 py-4">Приз</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr v-for="result in result.results"
                        class="border-b border-primary-200 bg-primary-100 text-neutral-800">
                        <td class="px-6 py-4 font-medium">
                          {{result.question}}
                        </td>
                        <td class="px-6 py-4">{{result.answer instanceof Array ? result.answer.join(', ') : result.answer}}</td>
                        <td class="px-6 py-4" v-if="result.isCorrect"><IconRight/></td>
                        <td class="px-6 py-4" v-else><IconWrong/></td>
                        <td class="px-6 py-4">{{result.isPrize ? 'Да' : 'Нет'}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
          <button
            @click="reset"
            class="inline-flex justify-center rounded-md border border-transparent bg-black py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none">
            Сыграть заново</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import {useQuizeStore} from "@/stores/quize";
import http from "@/helpers/http";
import {storeToRefs} from "pinia";
import router from "@/router";
import {onMounted, reactive} from "vue";
import IconRight from "@/components/icons/IconRight.vue";
import IconWrong from "@/components/icons/IconWrong.vue";
import Header from "@/components/Header.vue";
const quize = useQuizeStore();

const { result } = storeToRefs(quize);


const reset = () => {
  http().post('/api/quize/reset')
    .then((response) => {
      quize.reset()
      router.push({
        name: 'quize'
      })
    })
    .catch((error) => {
      console.error(error)
    });
}

onMounted(async () => {
  await http().get('/api/results')
    .then((response) => {
      if(response.data !== '') {
        quize.$patch({
          result: response.data
        })
      } else {
        router.push({
          name: 'quize'
        })
      }
    })
})
</script>