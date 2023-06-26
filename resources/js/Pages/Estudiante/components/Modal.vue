<template>
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 v-if="regitrarModal" class="modal-title fs-5" id="editModalLabel">Registrar estudiante</h1>
                    <h1 v-else class="modal-title fs-5" id="editModalLabel">Editar estudiante {{ nombre }} {{ apellido }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" v-model="vNombre" required>
                            <span class="colorError">{{ eNombre }}</span>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" v-model="vApellido" required>
                            <span class="colorError">{{ eApellido }}</span>
                        </div>
                        <div class="col-md-6">
                            <label for="edad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edad" v-model="vEdad" required>
                            <span class="colorError">{{ eEdad }}</span>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" v-model="vEmail" required
                                :disabled="!regitrarModal">
                            <span class="colorError">{{ eEmail }}</span>
                        </div>
                    </form>
                    <div class="mt-5" v-if="!regitrarModal">
                        <h4>Cursos</h4>
                        <form class="row row-cols-lg-auto g-3 align-items-center">
                            <div class="col-12">
                                <select class="form-select" id="inlineFormSelectPref" v-model="selectedOption">
                                    <option>Seleccionar</option>
                                    <option v-for="element in cursos.data" :value="element.id"
                                        :disabled="estudiante_curso.some((e) => e[0].id === element.id)">{{ element.nombre
                                        }} -
                                        {{ element.horario }}</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" @click="insertarEstudianteCurso">Añadir
                                    curso</button>
                            </div>
                        </form>
                        <table class="table table-hover mt-4 text-center" v-if="estudiante_curso.length">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Horario</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(element, index) in estudiante_curso">
                                    <td>{{ (index + 1) }}</td>
                                    <td>{{ element[0].nombre }}</td>
                                    <td>{{ element[0].horario }}</td>
                                    <td>{{ element[0].fecha_inicio }}</td>
                                    <td>{{ element[0].fecha_fin }}</td>
                                    <td>
                                        <button type="button" class="btn btn-secondary"
                                            @click="eliminarEstudianteCurso(element.id)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button v-if="regitrarModal" type="button" class="btn btn-primary"
                        @click="insertarEstudiante">Registrar</button>
                    <button v-else type="button" class="btn btn-primary" @click="editarEstudiante">Editar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, watchEffect } from 'vue';
import axios from 'axios';

const selectedOption = ref('Seleccionar');
const emit = defineEmits(['editarNuevoEstudiante', 'reloadEstudiante'])
const props = defineProps({
    id: { type: Number, required: false },
    apellido: { type: String, required: false },
    edad: { type: Number, required: false },
    email: { type: String, required: false },
    estudiante_curso: { type: Array, required: false },
    nombre: { type: String, required: false },
    cursos: { type: Array, required: false },
    regitrarModal: { type: Boolean, required: false }
});

const data = ref(props);
const vNombre = ref(props.nombre);
const vApellido = ref(props.apellido);
const vEdad = ref(props.edad);
const vEmail = ref(props.email);

const eNombre = ref(null);
const eApellido = ref(null);
const eEdad = ref(null);
const eEmail = ref(null);


watchEffect(() => {
    vNombre.value = props.nombre;
    vApellido.value = props.apellido;
    vEdad.value = props.edad;
    vEmail.value = props.email;
});

const insertarEstudianteCurso = async () => {
    try {
        const { id, estudiante_curso, cursos } = data.value;
        const service = await axios.post(`/estudiante-curso`, { estudiante_id: id, curso_id: selectedOption.value });
        if (service.status === 200) {
            const curso = cursos.data.find((e) => e.id === selectedOption.value);
            const idRegistro = service.data.data[1];
            estudiante_curso.push({ id: idRegistro, 0: curso });
            selectedOption.value = 'Seleccionar'
            emit('reloadEstudiante');
        }
    } catch (error) {
        throw error;
    }
}

const eliminarEstudianteCurso = async (id) => {
    try {
        const { estudiante_curso } = data.value;
        const service = await axios.delete(`/estudiante-curso/${id}`);
        if (service.status === 200) {
            const infoEliminar = estudiante_curso.find((e) => e.id === id);
            const index = estudiante_curso.indexOf(infoEliminar);
            if (index !== -1) {
                estudiante_curso.splice(index, 1);
                emit('reloadEstudiante');
            }
        }
    } catch (error) {
        throw error;
    }
}

const insertarEstudiante = async () => {
    try {
        const service = await axios.post(`/estudiante`, { nombre: vNombre.value, apellido: vApellido.value, edad: vEdad.value, email: vEmail.value });
        if (service.status === 200) {
            alert('Registro completo!');
            const truck_modal = document.querySelector('#modalEdit');
            const modal = bootstrap.Modal.getInstance(truck_modal);
            modal.hide();
            emit('editarNuevoEstudiante', service.data.data[1])
            emit('reloadEstudiante');
        }
    } catch (error) {        
        if (error.response.status === 422) {            
            const { nombre, apellido, edad, email } = error.response.data.errors;            
            eNombre.value = nombre?.shift();
            eApellido.value = apellido?.shift();
            eEdad.value = edad?.shift();
            eEmail.value = email?.shift();
        } else {
            throw error;
        }
    }
}


const editarEstudiante = async () => {
    try {
        const { id } = data.value;
        const service = await axios.put(`/estudiante/${id}`, { nombre: vNombre.value, apellido: vApellido.value, edad: vEdad.value, email: vEmail.value });
        if (service.status === 200) {
            alert('Edición completa!');
            emit('reloadEstudiante');
            const truck_modal = document.querySelector('#modalEdit');
            const modal = bootstrap.Modal.getInstance(truck_modal);
            modal.hide();
        }
        console.log(service);
    } catch (error) {
        if (error.response.status === 422) {            
            const { nombre, apellido, edad } = error.response.data.errors;            
            eNombre.value = nombre?.shift();
            eApellido.value = apellido?.shift();
            eEdad.value = edad?.shift();
        } else {
            throw error;
        }
    }
}


</script>
<style scoped>
.colorError {
    color: red;
}</style>