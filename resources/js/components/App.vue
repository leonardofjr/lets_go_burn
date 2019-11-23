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
                                <li><router-link to="/profile" exact>Profile</router-link></li>
                                <li><router-link to="/" exact>Tokers</router-link></li>

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
        data() {
            return {
                mymap: undefined,
                lat: undefined,
                lng: undefined,
            }
        },
        mounted() {
            


            this.mymap = L.map('mapid').setView([51.505, -0.09], 13);
            this.mymap.locate({setView: true, maxZoom: 16});

            const attribution = '&copy; <a href="https:///openstreetmap.org/copyright">OpenStreetMap</a> contributors';
            const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

            var tiles = L.tileLayer(tileUrl, {attribution});
            tiles.addTo(this.mymap)



        
        this.getUserLocation();


        },

        methods: {
            getUserLocation: function() {
                if (navigator.geolocation) {
                    // Utilizing HTML Geolocation API to locate user's position
                    return navigator.geolocation.getCurrentPosition(this.storePosition);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            },

            storePosition: function(position) {
                this.lat = position.coords.latitude;
                this.lng = position.coords.longitude;

                axios
                .post(this.web_url + 'user/1', {lat: position.coords.latitude, lng: position.coords.longitude} )
                .then((response => {
                    if (response.status === 200) {
                      this.createUserMarker()
                    }

                }));
            
            },

            createUserMarker: function() {

                var LeafIcon = L.Icon.extend({
                options: { 
                        shadowUrl: 'leaf-shadow.png',
                        iconSize:     [38, 95], // size of the icon
                        shadowSize:   [50, 64], // size of the shadow
                        iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
                        shadowAnchor: [4, 62],  // the same for the shadow
                        popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                    }
                });

                var greenIcon = new LeafIcon({iconUrl: 'leaf-green.png'}),
                redIcon = new LeafIcon({iconUrl: 'leaf-red.png'}),
                orangeIcon = new LeafIcon({iconUrl: 'leaf-orange.png'});

                L.marker([ this.lat,  this.lng], {icon: greenIcon}).addTo(this.mymap).bindPopup('Come Chill');


            }
        }
    }
</script>
