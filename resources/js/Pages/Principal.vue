<template>
    <div class="fondo d-flex justify-content-center align-items-center">
        <button @click="redirect()" class="btn botonsin ">
            <h3><strong>Proyecto Sistemas Distribuidos</strong></h3>
            <br>
            <h5>Laura Perdomo y Andres Robayo</h5>
        </button>
    </div>
</template>
<script>
export default{
    props:{

    },
    methods:{
        redirect() {
            window.location.href = route('libros.list')
        }
    }
}
</script>