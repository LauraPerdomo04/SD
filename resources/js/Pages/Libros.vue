<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Biblioteca</a>
                <!-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                    @click="vaciarModal(i)">
                    <strong>+</strong> Ingresar Libro</button>
            </div>
        </nav>
        <div>
            <h1 class="text-center mt-4"> Biblioteca</h1>

            <div class="container">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="">Título</label>
                            <Select2 v-model="filters.titulo" :options="titP" :settings="{placeholder: 'Seleccione'}" />
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="">Autor</label>
                            <Select2 v-model="filters.autor" :options="autP" :settings="{placeholder: 'Seleccione'}" />
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="">Año</label>
                            <Select2 v-model="filters.anio" :options="anioP" :settings="{placeholder: 'Seleccione'}" />
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="">Calificación</label>
                            <Select2 v-model="filters.calificacion" :options="calP" :settings="{placeholder: 'Seleccione'}" />
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center align-items-center mb-3">
                    <button @click="listar()" class="btn btn-warning" >Buscar</button>
                </div>
            </div>
        </div>
        <div class="row p-5">
            <div class="col-3" v-for="(i, index) in libros" v-bind:key="index">

                <div class="card m-3">
                    <img src="http://www.comunidadbaratz.com/wp-content/uploads/Instrucciones-a-tener-en-cuenta-sobre-como-se-abre-un-libro-nuevo.jpg"
                        class="card-img-top" alt="...">

                    <ul class="list-group list-group-flush ">
                        <li class="list-group-item"><strong>Titulo: </strong>{{ i.nombre }}</li>
                        <li class="list-group-item"><strong>Autor:</strong> {{ i.autor }}</li>
                        <li class="list-group-item"><strong>Año Publicación:</strong> {{ i.anio }}</li>
                        <li class="list-group-item"><strong>Sinopsis:</strong> {{ i.sinopsis }}</li>
                        <li class="list-group-item"><strong>Calificación: </strong>{{ i.calificacion }}/10</li>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                            @click="llenarModal(i)">Editar</button>
                        <button class="btn btn-danger" @click="eliminar(i)">Eliminar</button>
                    </ul>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Libro</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="container">
                            <div class="form-group row p-2">
                                <label for="colFormLabelSm"
                                    class="col-sm-2 col-form-label col-form-label-sm">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.nombre" class="form-control form-control-sm" id="colFormLabelSm"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row p-2">
                                <label for="colFormLabelSm"
                                    class="col-sm-2 col-form-label col-form-label-sm">Autor</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.autor" class="form-control form-control-sm" id="colFormLabelSm"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row p-2">
                                <label for="colFormLabelSm"
                                    class="col-sm-2 col-form-label col-form-label-sm">Año de publicidad</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.anio" class="form-control form-control-sm" id="colFormLabelSm"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row p-2">
                                <label for="colFormLabelSm"
                                    class="col-sm-2 col-form-label col-form-label-sm">Sinopsis</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.sinopsis" class="form-control form-control-sm" id="colFormLabelSm"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row p-2">
                                <label for="colFormLabelSm"
                                    class="col-sm-2 col-form-label col-form-label-sm">Calificación</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.calificacion" class="form-control form-control-sm" id="colFormLabelSm"
                                        placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="store()" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import Select2 from "vue3-select2-component";
export default {
    props: {
        libros_props: Array,
        titP: Array,
        autP: Array,
        anioP: Array,
        calP: Array
    },
    components: {
        Select2
    },
    data() {
        return {
            libros: this.libros_props,
            form: { id: '',titulo: '', autor: '', anio: '', sinopsis: '', calificacion: '' },
            filters: { titulo: '', autor: '', anio: '', calificacion: '' }
        }
    },
    created() {
        this.listar();
    },
    methods: {
        listar() {
            axios
                .post(route("libros.get"), this.filters)
                .then((res) => {
                    this.libros = res.data;
                });

        },
        eliminar(i) {
            axios
                .post(route("libros.destroy"), { id: i.id })
                .then((res) => {
                    Swal.fire('Éxito', res.data.msg, 'success');
                    this.listar();
                });
        },
        llenarModal(i) {
            this.form = {
                nombre: i.nombre,
                autor: i.autor,
                anio: i.anio,
                sinopsis: i.sinopsis,
                calificacion: i.calificacion,
                id: i.id
            };
        },

        vaciarModal() {
            this.form = {
                nombre: '',
                autor: '',
                anio: '',
                sinopsis: '',
                calificacion: '',
                id: ''
            };

        },
        store(){
            axios.post(route("libros.update"), this.form).then((res) => {
                if (res.data.status == 200) {
                    Swal.fire('Éxito', res.data.msg, 'success');
                }
                this.listar();
            });
        }

    }
}
</script>