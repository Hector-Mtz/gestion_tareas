<script setup>
import DialogModal from '@/Components/DialogModal.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from 'axios';
import SpinProgress from '@/Components/SpinProgress.vue';
//props
const props = defineProps({
       show: {
           type: Boolean,
           default: false,
       },
   });
   
const page = usePage();
//Modal close
const emit = defineEmits(["close"])
const close = () => 
{
  emit('close');
}
//form reactive
const formNewTask = useForm({
      title: '',
      desc:'',
      owner:page.props.auth.user.id,
   });

//save form
const saveTask = () => 
{
   showSpin.value = true
   formNewTask.post(route('saveTask'),
       {
        onSuccess : () => 
            {
               formNewTask.reset();
               showSpin.value = false
               close();
            },
         onError : () => 
         {
            showSpin.value = false
         },
        preserveScroll:true,
        preserveState:true
      });
}

let showSpin=ref(false);
</script>
<template>
    <DialogModal  :show="show" @close="close()">
        <template #title>
           <div class="flex flex-row justify-between">
              <div class="bg-[#5562a3] p-2 px-6 rounded-br-lg">
                <h1 class="text-white">Nueva tarea</h1>
              </div>
              <span class="p-2" @click="close()">
                 Cerrar
              </span>
           </div>
         </template>
         <template #content>
            <div class="px-6 py-4">
               <div>
                  <h4 class="text-xl">Titulo</h4>
                  <input v-model="formNewTask.title" class="w-full border-gray-300 shadow-sm rounded-xl dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                  <p class="text-red-500">
                     {{ formNewTask.errors.title }} 
                  </p>
               </div>
               <div>
                  <h4 class="text-xl">Descripción</h4>
                  <textarea v-model="formNewTask.desc" class="w-full border-gray-300 shadow-sm rounded-xl dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                  <p class="text-red-500">
                     {{ formNewTask.errors.desc }} 
                  </p>
               </div>
            </div>
         </template>
         <template #footer>
            <button @click="saveTask" class="bg-[#5562a3] p-2 px-6 rounded-br-lg rounded-tl-lg text-white font-bold text-xl flex flex-row gap-x-4 items-center">
                <p>Guardar</p>
                <SpinProgress :inprogress="showSpin" />
            </button>
         </template>
    </DialogModal>
</template>