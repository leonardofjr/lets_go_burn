<template>
        <div id="mapid"></div>
</template>

<script>
    export default {
        data() {
            return {
                mymap: undefined,
                lat: 1,
                lng: 1,
                name: undefined,
                user_id: undefined
            }
        },
        mounted() {
                this.getOnlineUsers();
            this.getUserData();
            this.getUserLocation();
        },
    methods: {
            getOnlineUsers: function() {
                axios
                .get('http://localhost:8000/online_users')
                .then(response => {
                    console.log(response);
                })
            },
            getUserData: function() {
                axios
                .get('http://localhost:8000/user')
                .then((response) => {
                    this.name = response.data.name;
                    this.user_id = response.data.id;
                })
            },

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
                .post(this.web_url + 'user_geopoint', {lat: this.lat , lng: this.lng})
                .then(response => {
                                this.getStoredPosition();

                });
            
            },

            getStoredPosition: function() {
                axios
                .get(this.web_url + 'user_geopoint/' + this.user_id)
                .then(response => {
                    if (response.status === 200) {
                            this.createMap();
                            this.createUserMarker();
                        } 
                 
                })
                .catch(error => {
         
                })
            },
            createMap: function() {
                this.mymap = L.map('mapid').setView([this.lat, this.lng], 13);
               // this.mymap.locate({setView: true, maxZoom: 16});
    
                const attribution = '&copy; <a href="https:///openstreetmap.org/copyright">OpenStreetMap</a> contributors';
                const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

                var tiles = L.tileLayer(tileUrl, {attribution});
                tiles.addTo(this.mymap)


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

                L.marker([ this.lat,  this.lng], {icon: greenIcon}).addTo(this.mymap).bindPopup('<span class="font-weight-bold">' + this.name + '</span>' + '<br>Come Chill');


            }
        }
    
    }
</script>
