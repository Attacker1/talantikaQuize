<template>
  <div class="pt-16">
    <h1 class="text-3xl font-semibold mb-4">Введите ваше имя</h1>
    <form action="#" @submit.prevent="handleLogin">
      <div class="overflow-hidden shadow sm:rounded-md max-w-sm mx-auto text-left">
        <div class="bg-white px-4 py-5 sm:p-6">
          <div>
            <input type="text" name="name" id="name" v-model="credentials.name" placeholder="Введите свое имя"
                   class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-black focus:outline-none">
          </div>
        </div>
        <div class="bg-white px-4 py-5 sm:p-6" v-if="showPass">
          <div>
            <input type="password" v-model="credentials.password" name="password" id="password" placeholder="Введите пароль"
                   class="mt-1 block w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:border-black focus:outline-none">
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
          <button type="submit" @submit.prevent="handleLogin"
                  class="inline-flex justify-center rounded-md border border-transparent bg-black py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none">Continue</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import {onMounted, reactive, ref, watch} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";
import {useAdminStore} from "@/stores/admin";
import {storeToRefs} from "pinia";

const router = useRouter()
const showPass = ref(false);
const adminStore = useAdminStore();


const credentials = reactive({
  name: null,
  password: null
})

watch(
  () => credentials.name,
  (count, prevCount) => {
    if(count === 'admin') {
      showPass.value = true
    } else {
      showPass.value = false
    }
  }
)

onMounted(() => {
  if(localStorage.getItem('token')) {
    router.push({
      name: 'quize'
    })
  }
})
const handleLogin = () =>{
  axios.post('/api/login', {
    name: credentials.name.replaceAll(' ', ''),
    password: credentials.password
  })
    .then((response) => {
      localStorage.setItem('token', response.data.token);
      adminStore.$patch({
        isAdmin: response.data.isAdmin
      })
      router.push({
        name: response.data.isAdmin ? 'admin' : 'quize'
      })
    })
    .catch((error) => {
      console.error(error)
      alert(error.response.data.message)
    })
}
</script>