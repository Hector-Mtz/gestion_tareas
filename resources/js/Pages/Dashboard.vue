<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
//Partials
import ModalNewTarea from './Partials/ModalNewTask.vue';
import Select from '@/Components/Select.vue';
import { ref,onUpdated, onMounted  } from 'vue';
import ModalEditTask from './Partials/ModalEditTask.vue';
//libs
import axios from 'axios';
import { usePage ,router } from '@inertiajs/vue3';
//Props
var props = defineProps({
    status:Object,
});
const page = usePage();
//Modals functions
let modalTask =  ref(false);
const openModalTask = () => 
{
    modalTask.value=true;
}
const closeModalTask = () => 
{
    modalTask.value = false;
}

let tasks = ref([]);
//get tasks
onUpdated(() => 
{
   axios.get(route('getTasks',{user:page.props.auth.user.id})).then(
    response=>
    {
      tasks.value = response.data
    })
    .catch(err => 
    {
        console.log(err)
    }
    )
})

onMounted(() => 
{
   axios.get(route('getTasks',{user:page.props.auth.user.id})).then(
    response=>
    {
        tasks.value = response.data
    })
    .catch(err => 
    {
        console.log(err)
    }
    )
})

//delete task
const deleteTask = (id) => 
{
 router.post(route('deleteTasks'),{task:id}, 
  {
    preserveScroll:true,
    preserveState:true,
    replace:true,
  });
}

//edit tasks
let modalEditTask = ref(false)
let actualTask = ref(null);
const openModalEditTask = (task) => 
{
    actualTask.value = task
    modalEditTask.value = true
}

const closeModalEditTask = () => 
{
    actualTask.value = null
    modalEditTask.value = false
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header >
            <div class="flex flex-row items-start justify-between align-center justify-items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Tareas
                </h2>
                <button class="flex flex-row px-2 py-2 bg-green-600 rounded-lg" @click="openModalTask">
                    <p class="mx-2 text-white">
                        Crear nueva tarea
                    </p>
                    <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none">
                        <path fill="white" fill-rule="evenodd" d="M9 17a1 1 0 102 0v-6h6a1 1 0 100-2h-6V3a1 1 0 10-2 0v6H3a1 1 0 000 2h6v6z"/>
                    </svg>
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-2 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th>
                                    
                                </th>
                                <th>Titulo</th>
                                <th>Descripción</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr  v-for="task in tasks" :key="task.id" :class="[(task.status_name == 'Completada') ? 'bg-green-200' : '']">
                                <td>
                                    <div class="flex flex-row gap-2">
                                        <button @click="deleteTask(task.id)" class="bg-red-500 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="33" viewBox="0 0 32 35">
                                              <defs>
                                                <clipPath id="clip-Icono-eliminar">
                                                  <rect width="32" height="35"/>
                                                </clipPath>
                                              </defs>
                                              <g id="Icono-eliminar" clip-path="url(#clip-Icono-eliminar)">
                                                <rect width="32" height="35" fill="rgba(255,255,255,0)"/>
                                                <g id="eliminar" transform="translate(7.003 6.001)">
                                                  <path id="Trazado_318" data-name="Trazado 318" d="M222.939,154.7a.541.541,0,0,0-.541.541v10.221a.541.541,0,0,0,1.082,0V155.244A.541.541,0,0,0,222.939,154.7Zm0,0" transform="translate(-210.374 -146.338)" fill="#fff"/>
                                                  <path id="Trazado_319" data-name="Trazado 319" d="M104.939,154.7a.541.541,0,0,0-.541.541v10.221a.541.541,0,0,0,1.082,0V155.244A.541.541,0,0,0,104.939,154.7Zm0,0" transform="translate(-98.756 -146.338)" fill="#fff"/>
                                                  <path id="Trazado_320" data-name="Trazado 320" d="M1.533,6.873V20.2a2.984,2.984,0,0,0,.793,2.058,2.663,2.663,0,0,0,1.932.835H14.49a2.663,2.663,0,0,0,1.932-.835,2.984,2.984,0,0,0,.793-2.058V6.873a2.066,2.066,0,0,0-.53-4.063H13.917V2.135A2.124,2.124,0,0,0,11.775,0h-4.8A2.124,2.124,0,0,0,4.832,2.135v.676H2.063a2.066,2.066,0,0,0-.53,4.063ZM14.49,22.009H4.258A1.713,1.713,0,0,1,2.614,20.2V6.921h13.52V20.2A1.713,1.713,0,0,1,14.49,22.009ZM5.913,2.135A1.042,1.042,0,0,1,6.973,1.08h4.8a1.042,1.042,0,0,1,1.06,1.055v.676H5.913ZM2.063,3.893H16.686a.973.973,0,1,1,0,1.947H2.063a.973.973,0,1,1,0-1.947Zm0,0" transform="translate(0 0)" fill="#fff"/>
                                                  <path id="Trazado_321" data-name="Trazado 321" d="M163.939,154.7a.541.541,0,0,0-.541.541v10.221a.541.541,0,0,0,1.082,0V155.244A.541.541,0,0,0,163.939,154.7Zm0,0" transform="translate(-154.565 -146.338)" fill="#fff"/>
                                                </g>
                                              </g>
                                            </svg>
                                        </button>
                                        <button @click="openModalEditTask(task)" class="bg-blue-500 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="35" height="33" viewBox="0 0 35 33">
                                               <defs>
                                                 <clipPath id="clip-Icono-editar">
                                                   <rect width="35" height="33"/>
                                                 </clipPath>
                                               </defs>
                                               <g id="Icono-editar" clip-path="url(#clip-Icono-editar)">
                                                 <rect width="35" height="33" fill="rgba(255,255,255,0)"/>
                                                 <g id="Grupo_513" data-name="Grupo 513" transform="translate(-7736.179 -2823)">
                                                   <g id="editar" transform="translate(7743.179 2828.996)">
                                                     <g id="Grupo_459" data-name="Grupo 459" transform="translate(0 1.55)">
                                                       <g id="Grupo_458" data-name="Grupo 458">
                                                         <path id="Trazado_286" data-name="Trazado 286" d="M17.778,43.412a.773.773,0,0,0-.773.773v7.729a.773.773,0,0,1-.773.773H2.319a.773.773,0,0,1-.773-.773V36.456a.773.773,0,0,1,.773-.773h9.275a.773.773,0,1,0,0-1.546H2.319A2.319,2.319,0,0,0,0,36.456V51.915a2.319,2.319,0,0,0,2.319,2.319H16.232a2.319,2.319,0,0,0,2.319-2.319V44.185A.773.773,0,0,0,17.778,43.412Z" transform="translate(0 -34.137)" fill="#fff"/>
                                                       </g>
                                                     </g>
                                                     <g id="Grupo_461" data-name="Grupo 461" transform="translate(4.638 0.004)">
                                                       <g id="Grupo_460" data-name="Grupo 460">
                                                         <path id="Trazado_287" data-name="Trazado 287" d="M118.547.87a2.959,2.959,0,0,0-4.185,0l-10.181,10.18a.781.781,0,0,0-.186.3l-1.546,4.638a.773.773,0,0,0,.733,1.017.785.785,0,0,0,.244-.039l4.638-1.546a.773.773,0,0,0,.3-.187L118.547,5.055A2.959,2.959,0,0,0,118.547.87Zm-1.093,3.092L107.405,14.011l-3,1,1-3L115.455,1.967a1.412,1.412,0,1,1,2,2Z" transform="translate(-102.409 -0.004)" fill="#fff"/>
                                                       </g>
                                                     </g>
                                                   </g>
                                                 </g>
                                               </g>
                                             </svg>
            
                                        </button>
                                    </div>
                                </td>
                                <td class="py-4 text-center">
                                    <p>{{ task.title }}</p>
                                </td>
                                <td class="py-4 text-center">
                                    {{ task.description }}
                                </td>
                                <td class="py-4 text-center">
                                    {{ task.status_name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <ModalNewTarea :show="modalTask" @close="closeModalTask" />
        <ModalEditTask :show="modalEditTask" :actualTask="actualTask" @close="closeModalEditTask" :status="status" />
    </AppLayout>
</template>
