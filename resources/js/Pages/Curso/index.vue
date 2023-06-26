<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="order-card-header">
                            <h3>Cursos</h3>
                            <button type="button" class="btn btn-primary" @click="registarCurso()">Registrar</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Horario</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Estudiantes asociados</th>
                                    <th colspan="2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(element, index) in cursos.data">
                                    <td>{{ (index + 1) }}</td>
                                    <td>{{ element.nombre }}</td>
                                    <td>{{ element.horario }}</td>
                                    <td>{{ element.fecha_inicio }}</td>
                                    <td>{{ element.fecha_fin }}</td>
                                    <td>{{ element.estudiante_curso.length }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" @click="editarCurso(element)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-secondary"
                                            @click="eliminarCurso(element.id)">
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
        <modal v-if="renderComponent" v-bind="dataEdit" :estudiantes="estudiantes" :regitrarModal="regitrarModal"
            @editarNuevoCurso="(i) => editarCurso(i)" @reloadCurso="reloadCurso()" />
    </div>
</template>  
<script setup>
import { ref, nextTick } from 'vue';
import axios from 'axios';
import Modal from './components/Modal.vue';

const { cursos, estudiantes  } = defineProps(['cursos','estudiantes']);
const renderComponent = ref(true);
const dataEdit = ref({ estudiante_curso: [] });
const regitrarModal = ref(true);

const forceRerender = async () => {
    renderComponent.value = false;
    await nextTick();
    renderComponent.value = true;
};

const reloadCurso = async () => {
    try {
        const service = await axios.get(`/curso-reload`);
        if (service.status === 200) {
            cursos.data.splice(0, cursos.data.length);
            cursos.data = service.data.data
        }
    } catch (error) {
        throw error;
    }
}

const eliminarCurso = async (id) => {
    try {
        if (confirm('Esta seguro?')) {
            const service = await axios.delete(`/curso/${id}`);
            if (service.status === 200) {
                await reloadCurso();
            }
        }
    } catch (error) {
        throw error;
    }
}

const editarCurso = async (data) => {
    dataEdit.value = null;
    dataEdit.value = data;
    regitrarModal.value = false;
    await forceRerender();
    const myModal = new bootstrap.Modal(document.getElementById('modalEdit'));
    myModal.show();
}

const registarCurso = async () => {
    dataEdit.value = null;    
    dataEdit.value = { id: null, nombre: null, horario: null, fecha_inicio: null, fecha_fin: null, estudiante_curso: [] };
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