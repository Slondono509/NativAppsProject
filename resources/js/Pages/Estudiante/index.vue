<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="order-card-header">
                            <h3>Estudiantes</h3>
                            <button type="button" class="btn btn-primary" @click="registarEstudiante()">Registrar</button>
                        </div>
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
                                    <td>{{ (index + 1) }}</td>
                                    <td>{{ element.nombre }}</td>
                                    <td>{{ element.apellido }}</td>
                                    <td>{{ element.edad }}</td>
                                    <td>{{ element.email }}</td>
                                    <td>{{ element.estudiante_curso.length }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" @click="editarEstudiante(element)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-secondary"
                                            @click="eliminarEstudiante(element.id)">
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
        <modal v-if="renderComponent" v-bind="dataEdit" :cursos="cursos" :regitrarModal="regitrarModal"
            @editarNuevoEstudiante="(i) => editarEstudiante(i)" @reloadEstudiante="reloadEstudiante()" />
    </div>
</template>  
<script setup>
import { ref, nextTick } from 'vue';
import axios from 'axios';
import Modal from './components/Modal.vue';

const { estudiantes, cursos } = defineProps(['estudiantes', 'cursos']);
const renderComponent = ref(true);
const dataEdit = ref({ estudiante_curso: [] });
const regitrarModal = ref(true);

const forceRerender = async () => {
    renderComponent.value = false;
    await nextTick();
    renderComponent.value = true;
};

const reloadEstudiante = async () => {
    try {
        const service = await axios.get(`/estudiante-reload`);
        if (service.status === 200) {
            estudiantes.data.splice(0, estudiantes.data.length);
            estudiantes.data = service.data.data
        }
    } catch (error) {
        throw error;
    }
}

const eliminarEstudiante = async (id) => {

    try {
        if (confirm('Esta seguro?')) {
            const service = await axios.delete(`/estudiante/${id}`);
            if (service.status === 200) {
                await reloadEstudiante();
            }
        }
    } catch (error) {
        throw error;
    }
}

const editarEstudiante = async (data) => {
    dataEdit.value = null;
    dataEdit.value = data;
    regitrarModal.value = false;
    await forceRerender();
    const myModal = new bootstrap.Modal(document.getElementById('modalEdit'));
    myModal.show();
}

const registarEstudiante = async () => {
    dataEdit.value = null;
    dataEdit.value = { id: null, apellido: null, edad: null, email: null, estudiante_curso: [] };
    regitrarModal.value = true;
    await forceRerender();
    const myModal = new bootstrap.Modal(document.getElementById('modalEdit'));
    myModal.show();
}

</script>
<style scoped>
.order-card-header {
    display: flex;
    justify-content: space-between;
}
</style>