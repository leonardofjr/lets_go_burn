<template>
        <div id="mapid"></div>
</template>

<script>
    export default {
        data() {
            return {
                mymap: undefined,
                lat: undefined,
                lng: undefined,
                name: undefined,
                user_id: undefined,
                online_users: undefined,
                _token: this._token = $('meta[name="csrf-token"').attr('content')

            }
        },
        mounted() {

            this.getAllOnlineUsers();
            this.getUserData();
        },
    methods: {
            getAllOnlineUsers() {
                axios
                .get('http://localhost:8000/online_users')
                .then(response => {
                    return response;
                })
                .then(response => {
                    this.online_users = response.data;
                })
            },
            getUserData() {
                axios
                .get('http://localhost:8000/user')
                .then((response) => {
                    this.name = response.data.name;
                    this.user_id = response.data.id;
                    this.getCurrentUserLocation();

                })
            },

            getCurrentUserLocation() {
                if (navigator.geolocation) {
                    // Utilizing HTML Geolocation API to locate user's position
                    return navigator.geolocation.getCurrentPosition(this.updateUserPosition);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            },

            updateUserPosition(position) {
                let data = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude

                }
                const headers = {
                    'X-CSRF-TOKEN': this._token
                }
                console.log(this._token);
                axios
                .post(this.web_url + 'user_geopoint/' + this.user_id, data, {
                    headers: headers,
                })
                .then(response => {
                    this.getStoredPosition();

                });
            
            },

            getStoredPosition() {
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
            createMap() {
                this.mymap = L.map('mapid').setView([this.lat, this.lng], 13);
               // this.mymap.locate({setView: true, maxZoom: 16});
    
                const attribution = '&copy; <a href="https:///openstreetmap.org/copyright">OpenStreetMap</a> contributors';
                const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

                let tiles = L.tileLayer(tileUrl, {attribution});
                tiles.addTo(this.mymap)


            },
            createUserMarker() {
      
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

                this.online_users.forEach((item) => {
                     L.marker([ item.geopoint.lat,  item.geopoint.lng], {icon: greenIcon}).addTo(this.mymap).bindPopup('<span class="font-weight-bold">' + this.name + '</span>' + '<br>Come Chill');
                })



            }
        }
    
    }
</script>
