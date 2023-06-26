<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Estudiantes</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Edad</th>
                                    <th>Correo electronico</th>
                                    <th>Cursos asociados</th>
                                    <th colspan="2">Acciones</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(element, index) in estudiantes.data">
                                    <td>{{ (index+1) }}</td>
                                    <td>{{ element.nombre }}</td>
                                    <td>{{ element.apellido }}</td>
                                    <td>{{ element.edad }}</td>
                                    <td>{{ element.email }}</td>
                                    <td>{{ element.estudiante_curso.length }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" @click="editarEstudiante(element)" 
                                            data-bs-toggle="modal" data-bs-target="#modalEdit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-secondary" @click="eliminarEstudiante(element.id)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <modal-edit v-bind="dataEdit" :cursos="cursos"/>
    </div>
</template>  
<script setup>
import { ref } from 'vue';
import axios from 'axios';
import ModalEdit from './components/ModalEdit.vue'

const { estudiantes, cursos }  = defineProps(['estudiantes','cursos']);
const dataEdit = ref({estudiante_curso:[]});

const eliminarEstudiante = async ( id ) => {    
    try {       
        const service = await axios.delete(`/estudiante/${id}`);        
    } catch (error) {
        console.log(error);
    }
}

const editarEstudiante = (data) => { 
    dataEdit.value = null;
    dataEdit.value = data;
}

</script>