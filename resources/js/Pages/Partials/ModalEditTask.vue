<script setup>
import DialogModal from '@/Components/DialogModal.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, watch,onUpdated } from 'vue';
import axios from 'axios';
import SpinProgress from '@/Components/SpinProgress.vue';
import Select from '@/Components/Select.vue';
//props
const props = defineProps({
       show: {
           type: Boolean,
           default: false,
       },
       actualTask:Object,
       status:Object
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
      id: -1,
      title: '',
      desc:'',
      owner:page.props.auth.user.id,
      status:-1
   });

//set info
onUpdated(() => 
{
   if(props.actualTask !== null)
   {
      formNewTask.id = props.actualTask.id
      formNewTask.title = props.actualTask.title
      formNewTask.desc = props.actualTask.description
      formNewTask.status = props.actualTask.status_id
   }
})

//save form
const saveTask = () => 
{
   showSpin.value = true
   formNewTask.post(route('saveEditTask'),
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
               <div class="my-4">
                  <h4 class="text-xl">Descripción</h4>
                  <textarea v-model="formNewTask.desc" class="w-full border-gray-300 shadow-sm rounded-xl dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"/>
                  <p class="text-red-500">
                     {{ formNewTask.errors.desc }} 
                  </p>
               </div>
               <div>
                  <h4 class="text-xl">Status</h4>
                  <Select v-model="formNewTask.status">
                     <option v-for="statue in status" :key="statue.id" :value="statue.id">
                        {{ statue.name }}
                     </option>
                  </Select>
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