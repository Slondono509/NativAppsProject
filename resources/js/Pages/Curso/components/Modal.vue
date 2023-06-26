<template>
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 v-if="regitrarModal" class="modal-title fs-5" id="editModalLabel">Registrar curso</h1>
                    <h1 v-else class="modal-title fs-5" id="editModalLabel">Editar curso {{ nombre }}</h1>
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
                            <label for="horario" class="form-label">Horario</label>
                            <input type="text" class="form-control" id="horario" v-model="vHorario" required>
                            <span class="colorError">{{ eHorario }}</span>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                            <input type="text" class="form-control" id="fecha_inicio" v-model="vfechaInicio" required>
                            <span class="colorError">{{ efechaInicio }}</span>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_fin" class="form-label">Fecha fin</label>
                            <input type="text" class="form-control" id="fecha_fin" v-model="vfechaFin" required>
                            <span class="colorError">{{ efechaFin }}</span>
                        </div>
                    </form>
                    <div class="mt-5" v-if="!regitrarModal">
                        <h4>Estudiantes</h4>
                        <form class="row row-cols-lg-auto g-3 align-items-center">
                            <div class="col-12">
                                <select class="form-select" id="inlineFormSelectPref" v-model="selectedOption">
                                    <option>Seleccionar</option>
                                    <option v-for="element in estudiantes.data" :value="element.id"
                                        :disabled="estudiante_curso.some((e) => e[0].id === element.id)">{{ element.nombre
                                        }} -
                                        {{ element.apellido }} - {{ element.email }}</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" @click="insertarEstudianteCurso">Añadir
                                    estudiante</button>
                            </div>
                        </form>
                        <table class="table table-hover mt-4 text-center" v-if="estudiante_curso.length">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Edad</th>
                                    <th>Correo electronico</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(element, index) in estudiante_curso">
                                    <td>{{ (index + 1) }}</td>
                                    <td>{{ element[0].nombre }}</td>
                                    <td>{{ element[0].apellido }}</td>
                                    <td>{{ element[0].edad }}</td>
                                    <td>{{ element[0].email }}</td>
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
                        @click="insertarCurso">Registrar</button>
                    <button v-else type="button" class="btn btn-primary" @click="editarCurso">Editar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, watchEffect } from 'vue';
import axios from 'axios';

const selectedOption = ref('Seleccionar');
const emit = defineEmits(['editarNuevoCurso', 'reloadCurso'])
const props = defineProps({
    id: { type: Number, required: false },
    horario: { type: String, required: false },
    fecha_inicio: { type: Number, required: false },
    fecha_fin: { type: String, required: false },
    estudiante_curso: { type: Array, required: false },
    nombre: { type: String, required: false },
    estudiantes: { type: Array, required: false },
    regitrarModal: { type: Boolean, required: false }
});

const data = ref(props);
const vNombre = ref(props.nombre);
const vHorario = ref(props.horario);
const vfechaInicio = ref(props.fecha_inicio);
const vfechaFin = ref(props.fecha_fin);

const eNombre = ref(null);
const eHorario = ref(null);
const efechaInicio = ref(null);
const efechaFin = ref(null);


watchEffect(() => {
    vNombre.value = props.nombre;
    vHorario.value = props.horario;
    vfechaInicio.value = props.fecha_inicio;
    vfechaFin.value = props.fecha_fin;
});

const insertarEstudianteCurso = async () => {
    try {
        const { id, estudiante_curso, estudiantes } = data.value;
        const service = await axios.post(`/estudiante-curso`, { curso_id: id, estudiante_id: selectedOption.value });
        if (service.status === 200) {
            const estudiante = estudiantes.data.find((e) => e.id === selectedOption.value);
            const idRegistro = service.data.data[1];
            estudiante_curso.push({ id: idRegistro, 0: estudiante });
            selectedOption.value = 'Seleccionar'
            emit('reloadCurso');
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
                emit('reloadCurso');
            }
        }
    } catch (error) {
        throw error;
    }
}

const insertarCurso = async () => {
    try {
        const service = await axios.post(`/curso`, { nombre: vNombre.value, horario: vHorario.value, fecha_inicio: vfechaInicio.value, fecha_fin: vfechaFin.value });
        if (service.status === 200) {
            alert('Registro completo!');
            const truck_modal = document.querySelector('#modalEdit');
            const modal = bootstrap.Modal.getInstance(truck_modal);
            modal.hide();
            emit('editarNuevoCurso', service.data.data[1])
            emit('reloadCurso');
        }
    } catch (error) {
        if (error.response.status === 422) {
            const { nombre, horario, fecha_inicio, fecha_fin } = error.response.data.errors;
            eNombre.value = nombre?.shift();
            eHorario.value = horario?.shift();
            efechaInicio.value = fecha_inicio?.shift();
            efechaFin.value = fecha_fin?.shift();
        } else {
            throw error;
        }
    }
}


const editarCurso = async () => {
    try {
        const { id } = data.value;
        const service = await axios.put(`/curso/${id}`, { nombre: vNombre.value, horario: vHorario.value, fecha_inicio: vfechaInicio.value, fecha_fin: vfechaFin.value });
        if (service.status === 200) {
            alert('Edición completa!');
            emit('reloadCurso');
            const truck_modal = document.querySelector('#modalEdit');
            const modal = bootstrap.Modal.getInstance(truck_modal);
            modal.hide();
        }        
    } catch (error) {
        if (error.response.status === 422) {
            const { nombre, horario, fecha_inicio } = error.response.data.errors;
            eNombre.value = nombre?.shift();
            eHorario.value = horario?.shift();
            efechaInicio.value = fecha_inicio?.shift();
            efechaFin.value = fecha_fin?.shift();
        } else {
            throw error;
        }
    }
}


</script>
<style scoped>
.colorError {
    color: red;
}
</style>