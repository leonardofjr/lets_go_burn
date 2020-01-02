@extends('layouts.app')
@section('content')
        @if (Route::has('login'))
            @auth
                <header>
                    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                        <div class="container">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                {{ config('app.name', 'NEIGHBOURHOOD STUDIO') }}
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>
            
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <!-- Left Side Of Navbar -->
                                <ul class="navbar-nav mr-auto">
            
                                </ul>
            
                                <!-- Right Side Of Navbar -->
                                <ul class="navbar-nav ml-auto">
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                {{ Auth::user()->fname }} <span class="caret"></span>
                                            </a>
            
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a href="{{ url('/user_panel') }}" class="nav-link">Settings</a>
                                            </div>
            
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
            
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </header>

                <main>
                    <div id="homeMap"></div>
                </main>

                <script>
                    function createMap() {
                        this.mymap = L.map('homeMap').setView([1, 1], 13);
                    // this.mymap.locate({setView: true, maxZoom: 16});
            
                        const attribution = '&copy; <a href="https:///openstreetmap.org/copyright">OpenStreetMap</a> contributors';
                        const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

                        let tiles = L.tileLayer(tileUrl, {attribution});
                        tiles.addTo(this.mymap)
                    }
                    createMap();
                </script>
            @else
                <div class="flex-center position-ref full-height">
                    <div class="content">
                        <div class="title m-b-md">
                            NEIGHBOURHOOD STUDIO
                        </div>
                        <div class="links">
                                <a href="{{ route('login') }}">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Register</a>
                                @endif
                        </div>
                    </div>
                </div>
            @endauth
        @endif
@endsection