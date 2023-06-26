<template>
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar estudiante {{ nombre }} {{ apellido }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" :value="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" :value="apellido" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edad" :value="edad" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" :value="email" required>
                        </div>
                    </form>
                    <div class="mt-5">
                        <h4>Cursos</h4>
                        <form class="row row-cols-lg-auto g-3 align-items-center">
                            <div class="col-12">
                                <select class="form-select" id="inlineFormSelectPref" v-model="selectedOption">
                                    <option>Seleccionar</option>
                                    <option v-for="element in cursos.data" :value="element.id"
                                        :disabled="estudiante_curso.some((e) => e.id === element.id)">{{ element.nombre }} -
                                        {{ element.horario }}</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" @click="insertarEstudianteCurso">Añadir
                                    curso</button>
                            </div>
                        </form>
                        <table class="table table-hover mt-4" v-if="estudiante_curso.length">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Horario</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(element, index) in estudiante_curso">
                                    <td>{{ (index + 1) }}</td>
                                    <td>{{ element.nombre }}</td>
                                    <td>{{ element.horario }}</td>
                                    <td>{{ element.fecha_inicio }}</td>
                                    <td>{{ element.fecha_fin }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Editar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import axios from 'axios';

const selectedOption = ref('Seleccionar');
const props = defineProps({
    id: { type: Number, required: false },
    apellido: { type: String, required: false },
    edad: { type: Number, required: false },
    email: { type: String, required: false },
    estudiante_curso: { type: Array, required: false },
    nombre: { type: String, required: false },
    cursos: { type: Array, required: false },
});

const data = ref(props);

const insertarEstudianteCurso = async () => {
    try {
        const { id, estudiante_curso, cursos } = data.value;
        const service = await axios.post(`/estudiante-curso`, { estudiante_id: id, curso_id: selectedOption.value });
        if (service.status === 200) {
            const curso = cursos.data.find((e) => e.id === selectedOption.value);
            estudiante_curso.push(curso);            
            selectedOption.value = 'Seleccionar'
        }
    } catch (error) {
        console.log(error);
    }
}

const editarEstudiante = async () => {
    
}




</script>