<template>
        <div>
            <hr>
            <h3>User Information</h3>
            <hr>
            <div class="form-group row">
                <label for="firstName" class="col-md-3 col-form-label">First Name</label>
                <div class="col-md-9">
                    <input id="firstName" type="text" class="form-control" v-model="firstName" name="firstName" required autocomplete="firstName" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="lastName" class="col-md-3 col-form-label">Last Name</label>
                <div class="col-md-9">
                    <input id="lastName" type="text" class="form-control" v-model="lastName" required autocomplete="lastName" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-3 col-form-label">Email</label>
                <div class="col-md-9">
                    <input id="email" type="tel" class="form-control" v-model="email" required autocomplete="email" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-md-3 col-form-label">Phone</label>
                <div class="col-md-9">
                    <input id="phone" type="tel" class="form-control" v-model="phone" required autocomplete="phone" autofocus>
                </div>
            </div>
            <hr>
            <h3>Studio Information</h3>
            <hr>
            <div class="form-group row">
                <label for="studioName" class="col-md-3 col-form-label">Studio Name</label>
                <div class="col-md-9">
                    <input id="studioName" type="text" class="form-control" v-model="studioName" name="studioName" required autocomplete="studioName" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="streetAddress" class="col-md-3 col-form-label">Street Address</label>
                <div class="col-md-9">
                    <input id="streetAddress" type="text" class="form-control" v-model="streetAddress" name="streetAddress" required autocomplete="streetAddress" autofocus>
                    <button v-on:click="search">Search</button>
                </div>
            </div>
            <div id="mapContainer">

            </div>

            <hr>
            <h3>Studio Rates</h3>
            <hr>

        </div>
</template>

<script>
import { create } from 'domain';

    export default {
            data() { return {
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
                studioName: '',
                streetAddress: '',
                lat: '',
                lon: '',
                user: undefined,
                promise: undefined,
            }
        },
        mounted() {
            this.getUserData();
        },
        methods: {
            getUserData() {
                let url = 'http://localhost:8000/user';
                
                axios
                .get(url)
                .then(response => {
                    console.log(response);
                    this.firstName = response.data.fname;
                    this.lname = response.data.lname;
                    this.phone = response.data.phone;
                    this.email = response.data.email;
                })
            },

            search() {
                    let query = this.streetAddress;
                    let params = 'format=json&addressdetails=1&limit=1&polygon_svg=1';
                    const osmUrl = 'https://nominatim.openstreetmap.org/search/' + query + '?' + params;

                    this.promise = axios
                    .get(osmUrl)
                    .then(response => {
                        console.log('Success');
                        return  response.data[0];
                    });
                    this.destroyMapElement();
                    this.createMapElement();
                    this.renderMap();
       
            },

            renderMap() {     
                this.promise.then(data => {
                    this.mymap = L.map('mapid').setView([data.lat, data.lon], 13);
                    // this.mymap.locate({setView: true, maxZoom: 16});
        
                    const attribution = '&copy; <a href="https:///openstreetmap.org/copyright">OpenStreetMap</a> contributors';
                    const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

                    let tiles = L.tileLayer(tileUrl, {attribution});
                    tiles.addTo(this.mymap)
                    this.createUserMarker();
                });
            },
            createUserMarker() {
                    this.promise.then(data => {
                        
                    let LeafIcon = L.Icon.extend({
                    options: { 
                        //   shadowUrl: 'leaf-shadow.png',
                            iconSize:     [50, 50], // size of the icon
                            shadowSize:   [50, 64], // size of the shadow
                            iconAnchor:   [25, 25], // point of the icon which will correspond to marker's location
                            shadowAnchor: [4, 62],  // the same for the shadow
                            popupAnchor:  [-0, -25] // point from which the popup should open relative to the iconAnchor
                        }
                    });
                    let greenIcon = new LeafIcon({iconUrl: 'leaf-green.png'}),
                    redIcon = new LeafIcon({iconUrl: 'leaf-red.png'}),
                    orangeIcon = new LeafIcon({iconUrl: 'leaf-orange.png'});

                    L.marker([data.lat, data.lon], {icon: greenIcon}).addTo(this.mymap).bindPopup('<span class="font-weight-bold">' + this.name + '</span>' + '<br>Come Chill');

                })
            },

            createMapElement() {
                $('#mapContainer').append('<div id="mapid"></div>');
            },

            destroyMapElement() {
                $('#mapid').remove();
            }
        }
    }
</script>
