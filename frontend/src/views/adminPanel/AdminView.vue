<template>
  <Header/>
  <div class="pt-10">
    <h1 class="text-3xl font-semibold mb-4">Список участников</h1>
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
                      <th scope="col" class="px-6 py-4">Имя игрока</th>
                      <th scope="col" class="px-6 py-4">кол-во ошибок</th>
                      <th scope="col" class="px-6 py-4">время</th>
                      <th scope="col" class="px-6 py-4">приз</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="result in results"
                        class="border-b border-primary-200 bg-primary-100 text-neutral-800">
                      <td class="px-6 py-4 font-medium">
                        {{result.user.name}}
                      </td>
                      <td class="px-6 py-4">{{mistakesCount(result)}}</td>
                      <td class="px-6 py-4">{{result.doneIn}}</td>
                      <td class="px-6 py-4" v-if="hasPrize(result)"><IconRight/></td>
                      <td class="px-6 py-4" v-else><IconWrong/></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import {onBeforeMount, onMounted} from "vue";
import http from "@/helpers/http";
import {useAdminStore} from "@/stores/admin";
import {storeToRefs} from "pinia";
import Header from "@/components/Header.vue";
import IconRight from "@/components/icons/IconRight.vue";
import IconWrong from "@/components/icons/IconWrong.vue";
import router from "@/router";
const adminStore = useAdminStore();
const { results, isAdmin } = storeToRefs(adminStore);

const mistakesCount = (result) => {
  let count = 0;
  result.results.forEach((element) => {
    if(element.isCorrect === false) {
      count++;
    }
  });
  return count;
}

const hasPrize = (result) => {
  let res = false;
  result.results.forEach((element) => {
    if(element.isPrize === true) {
      res = true
    }
  });
  return res;
}

onMounted(async () => {
  await http().get('/api/admin/userList')
    .then((response) => {
      console.log(response.data)
      adminStore.$patch({
        results: response.data
      })
    });
})
</script>