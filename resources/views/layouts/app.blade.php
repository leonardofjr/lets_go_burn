<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }


            .content {
                text-align: center;
            }

            .title {
                font-size: 48px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    <!-- Scripts -->
     <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Leaflet  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>
  
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    @yield('content')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>


<script type="text/javascript">

    /*** Constants ***/
    const rootUrl = 'http://localhost:8000/';
    
    /*** Fetching Data from backend ***/

    let user = fetch(rootUrl + 'user')
    .then(response => {

        return response.json();
    })

    let users = fetch(rootUrl + 'producers')
    .then(response => {
        return response.json();
    })

    /*** Initialization Function ***/
    let lat, lon;
    this.lat = 43.653225;
    this.lon = -79.383186;
    function init() {
        getCurrentUserPosition();
        createMap();
        createProducerMarkers();
        createPaneElements();
    }



    /*** Getting current user position ***/
    


    function getCurrentUserPosition() {
        navigator.geolocation.getCurrentPosition(storePosition);
    }

    function storePosition(position) {
        console.log(position);

        if (position) {                   
            this.lat = position.coords.latitude
             this.lon = position.coords.longitude
        
        } 
    }


    /*** Map Creation ***/

    function createMap(userPosition) {
        user.then(data => {

            if(!data.studio) {
                this.mymap = L.map('homeMap').setView([this.lat, this.lon], 13);
            } else {
                this.mymap = L.map('homeMap').setView([data.studio.lat, data.studio.lon], 13);
            }
          // this.mymap.locate({setView: true, maxZoom: 16});

            const attribution = '&copy; <a href="https:///openstreetmap.org/copyright">OpenStreetMap</a> contributors';
            const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

            let tiles = L.tileLayer(tileUrl, {attribution});
            tiles.addTo(this.mymap)
        })
    }

    /*** Creation of Markers on map ***/

    function createProducerMarkers() {
        users.then(data => {
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

            let marker = new LeafIcon({iconUrl: 'marker.png'})

  
            data.forEach((item) => {
                L.marker([ item.studio.lat,  item.studio.lon], {icon: marker}).addTo(this.mymap).bindPopup('<span class="font-weight-bold">' + item.studio.name + '</span>'  + '<br>' + item.studio.address + '<br>' + item.studio.phone);
            })
        });
    }

    
    /*** Pane Creation ***/

    function createPaneElements() {
        users.then(data => {
            console.log(data);
            let pane = $('.section_result_content');
            data.forEach((item) => {
                sectionResultContent = '<div class"section_result_details_container>'
                                           + '<b>' + item.studio.name + '</b><br>'
                                           + '<span>' + item.studio.address + '</span><br>'
                                           + '<span>' + item.studio.phone + '</span><br>'
                                        '</div>';

                pane.append(sectionResultContent)
            });
            
        });
    }

    /*** Initializing Function ***/

    init();

    

</script>
</body>


</html>
