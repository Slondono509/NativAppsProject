<template>
    <div class="modal fade" id="modalTopCurso" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Top cursos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Total estudiantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(element, index) in topCurdoData">
                                <td>{{ (index + 1) }}</td>
                                <td>{{ element.nombre }}</td>
                                <td>{{ element.total_estudiantes }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>

const props = defineProps({
    topCurdoData: { type: Array, required: false },
});

console.log(props);

</script>