<template>
        <div></div>
</template>

<script>
import axios from 'axios';

    export default {
        mounted() {
                axios
                .get(this.web_url + 'users')
                .then(response => (
                    console.log(response.data)
                ))
        }
    }
</script>
