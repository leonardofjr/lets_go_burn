<template>
        <div></div>
</template>

<script>

    export default {
        mounted() {
                axios
                .get(this.web_url + 'user/1' )
                .then(response => (
                    console.log(response.data)
                ))
        }
    }
</script>
