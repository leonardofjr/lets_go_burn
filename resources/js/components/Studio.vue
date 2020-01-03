<template>
        <div>
            <hr>
            <h3>Studio Information</h3>
            <hr>
            <div class="form-group row">
                <label for="studioName" class="col-md-3 col-form-label">Studio Name</label>
                <div class="col-md-9">
                    <input id="studioName" type="text" class="form-control" v-model="this.$parent.studioName" name="studioName" required autocomplete="studioName" autofocus>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="phone" class="col-md-3 col-form-label">Phone</label>
                <div class="col-md-9">
                    <input id="phone" type="tel" class="form-control" v-model="this.$parent.phone" required autocomplete="phone" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="streetAddress" class="col-md-3 col-form-label">Street Address</label>
                <div class="col-md-9">
                    <input id="streetAddress" type="text" class="form-control" v-model="this.$parent.streetAddress" name="streetAddress" required autocomplete="streetAddress" autofocus>
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
    export default {
        data() {
            return {
                lat: '',
                lon: '',
                promise: undefined,
                _token: this._token = $('meta[name="csrf-token"').attr('content')

            }
        },
        mounted() {

        },
    methods: {
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
            },
            getCurrentUserLocation() {
                if (navigator.geolocation) {
                    // Utilizing HTML Geolocation API to locate user's position
                    return navigator.geolocation.getCurrentPosition(this.updateUserPosition);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            },


    
        }
    
    }
</script>
