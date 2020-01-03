<template>
            <div class="row">
                    <aside class="col-12 col-lg-3">
                        <nav class=" navbar-dark ">
                            <div class="nav-header">
                                <div class="brand">
                                    Navigation
                                </div>

                                <div class="hamburger-button  d-xs-block d-lg-none">
                                       <button class="navbar-toggler toggle"  data-target="#nav-items" data-collapsed="off" type="button">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>
                                </div>
                            </div>
                            <ul id="nav-items" class="nav-items">
                                    <!-- use router-link component for navigation. -->
                                    <!-- specify the link by passing the `to` prop. -->
                                    <!-- `<router-link>` will be rendered as an `<a>` tag by default -->
                                <li><router-link to="/" exact>Profile</router-link></li>
                                <li v-if="role == 'admin'"><router-link to="/users" exact>Users</router-link></li>
                                <li><router-link to="/studio" exact>Studio</router-link></li>

                            </ul>
                        </nav>
                    </aside>
                <main class="col-12 col-lg-9">
                    <router-view></router-view>
                </main>
            </div>
</template>

<script>

    export default {
            data() { return {
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
                studioName: '',
                streetAddress: '',
                role: '',

            }
        },
        mounted() {
            this.getUserData();
        },

          methods: {
            getUserData() {
                let url = 'http://localhost:8000/user';
                let authUser = {};
                axios
                .get(url)
                .then(response => {
                    this.firstName = response.data.fname;
                    this.lname = response.data.lname;
                    this.phone = response.data.phone;
                    this.email = response.data.email;
                    this.role = response.data.roles[0].name;
                    authUser.role = response.data.roles[0].name;
                    authUser.authenticated = response.data.authenticated;
                    window.localStorage.setItem('nsUser', JSON.stringify(authUser));

                })
            },
          }


     
    }
</script>
