<template>
    <table id="my-table">
        <slot></slot>
    </table>
</template>
<script>
export default {
    name: 'DataType',
    mounted() {
        this.$nextTick(() => {
            $(document).ready(function() {
                $('#my-table').DataTable( {
                    serverSide: true,
                    ajax: {
                        url: "?ajax=true",
                        dataSrc: 'data.data'
                    },
                    columns: [
                        { data: 'id' }
                    ]
                } );
            } );
        })
    }
}
</script>
