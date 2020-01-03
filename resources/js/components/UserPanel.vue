<template>
        <div>
            <hr>
            <h3>User Information</h3>
            <hr>
            <div class="form-group row">
                <label for="firstName" class="col-md-3 col-form-label">First Name</label>
                <div class="col-md-9">
                    <input id="firstName" type="text" class="form-control" v-model="this.$parent.firstName" name="firstName" required autocomplete="firstName" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="lastName" class="col-md-3 col-form-label">Last Name</label>
                <div class="col-md-9">
                    <input id="lastName" type="text" class="form-control" v-model="this.$parent.lastName" required autocomplete="lastName" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-3 col-form-label">Email</label>
                <div class="col-md-9">
                    <input id="email" type="tel" class="form-control" v-model="this.$parent.email" required autocomplete="email" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-md-3 col-form-label">Phone</label>
                <div class="col-md-9">
                    <input id="phone" type="tel" class="form-control" v-model="this.$parent.phone" required autocomplete="phone" autofocus>
                </div>
            </div>

        </div>
</template>

<script>
import { create } from 'domain';

    export default {
            data() { return {

            }
        },
        mounted() {
            
        },
        methods: {

           
        }
    }
</script>
