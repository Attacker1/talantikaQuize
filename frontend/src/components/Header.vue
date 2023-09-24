<template>
  <div class="pt-16">
    <div class="flex flex-row items-center justify-between overflow-hidden sm:rounded-md max-w-sm mx-auto text-left">
      <img class="w-20 h-20 rounded" src="@/assets/adminProfile.png" v-if="isAdmin">
      <IconProfile v-else/>
      <button @click.prevent="logout" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
        Выйти из аккаунта
      </button>
    </div>
  </div>
</template>
<script setup>
import IconProfile from "@/components/icons/IconProfile.vue";
import router from "@/router";
import {useAdminStore} from "@/stores/admin";
import {toRefs} from "vue";

const adminStore = useAdminStore();

const { isAdmin } = toRefs(adminStore);

const logout = () => {
  localStorage.removeItem('token')
  router.push({
    name: 'login'
  })
}
</script>