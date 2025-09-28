@extends('layouts.admin.app')

@section('title', \App\Models\BusinessSetting::where(['key'=>'business_name'])->first()->value ?? translate('messages.dashboard'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="d-flex flex-wrap gap-2 justify-content-between py-2">
            <div class="d-flex align-items-center flex-grow-1">
                <img src="{{ asset('/public/assets/admin/img/new-img/users.svg') }}" alt="img">
                <div class="w-0 flex-grow pl-3">
                    <h1 class="page-header-title mb-1">{{ translate('Dispatch Overview') }}</h1>
                    <p class="page-header-text text-dark m-0">
                        {{ translate('Monitor your') }} <span class="font-semibold">{{ translate('Dispatch Management') }}</span> {{ translate('statistics by zone') }}
                    </p>
                </div>
            </div>
            <div class="alert bg--10 font-bold fs-14" role="alert">
                {{ translate('This_section_only_contains_Order_Data') }}
            </div>
        </div>
    </div>

    <div class="row g-1">
        {{-- Deliveryman Statistics --}}
        <div class="col-lg-8">
            <div class="row gap__10 __customer-statistics-card-wrap-2">
                <div class="col-sm-6">
                    <div class="__customer-statistics-card h-100">
                        <div class="title">
                            <img src="{{asset('public/assets/admin/img/new-img/deliveryman/active.svg')}}" alt="new-img">
                            <h4>{{$active_deliveryman}}</h4>
                        </div>
                        <h4 class="subtitle text-capitalize mt-2">{{translate('messages.active_delivery_man')}}</h4>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="__customer-statistics-card h-100 d-flex gap-3" style="--clr:#FF5A54">
                        <div>
                            <img width="48" height="48" src="{{asset('public/assets/admin/img/new-img/deliveryman/newly.svg')}}" alt="new-img">
                        </div>
                        <div class="d-flex justify-content-around gap-3 flex-grow-1">
                            <div>
                                <h4 class="title">{{ $inactive_deliveryman }}</h4>
                                <h4 class="subtitle text-capitalize">{{translate('messages.in_Active')}}</h4>
                            </div>
                            <div>
                                <h4 class="title">{{ $suspend_deliveryman }}</h4>
                                <h4 class="subtitle text-capitalize">{{ translate('suspended')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="__customer-statistics-card h-100">
                        <div class="title">
                            <img src="{{asset('public/assets/admin/img/new-img/deliveryman/active.svg')}}" alt="new-img">
                            <h4>{{ $unavailable_deliveryman }}</h4>
                        </div>
                        <h4 class="subtitle text-capitalize mt-2">{{ translate('Fully Booked Delivery Man')}}</h4>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="__customer-statistics-card h-100" style="--clr:#FF5A54">
                        <div class="title">
                            <img src="{{asset('public/assets/admin/img/new-img/deliveryman/in-active.svg')}}" alt="new-img">
                            <h4>{{$available_deliveryman}}</h4>
                        </div>
                        <h4 class="subtitle text-capitalize mt-2">{{translate('Available to assign more order')}}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Info Cards --}}
        <div class="col-lg-4">
            <div class="shadow--order-card">
                <div class="col-12 p-0">
                    <a class="order--card h-100" href="#">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                <img src="{{asset('public/assets/admin/img/dashboard/food/unassigned.svg')}}" class="oder--card-icon" alt="unassigned">
                                <span>{{translate('messages.unassigned_orders')}}</span>
                            </h6>
                            <span class="card-title text-00A3FF">
                                {{$data['searching_for_dm']}}
                            </span>
                        </div>
                    </a>
                </div>
                <div class="col-12 p-0">
                    <a class="order--card h-100" href="#">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                <img src="{{asset('public/assets/admin/img/dashboard/food/accepted.svg')}}" class="oder--card-icon" alt="accepted">
                                <span>{{translate('Accepted by Delivery Man')}}</span>
                            </h6>
                            <span class="card-title text-success">
                                {{$data['accepted_by_dm']}}
                            </span>
                        </div>
                    </a>
                </div>
                <div class="col-12 p-0">
                    <a class="order--card h-100" href="#">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                <img src="{{asset('public/assets/admin/img/dashboard/food/out-for.svg')}}" class="oder--card-icon" alt="out-for">
                                <span>{{translate('Out for Delivery')}}</span>
                            </h6>
                            <span class="card-title text-success">
                                {{$data['picked_up']}}
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Map --}}
        <div class="col-lg-12">
            <div class="__map-wrapper-2 mt-3">
                <div class="map-warper map-wrapper-2 rounded">
                    <div id="map-canvas" class="rounded" style="width:100%; height:500px;"></div>
                </div>
                {{-- Deliveryman Lat/Lng info panel --}}
                <div id="deliveryman-info" class="p-3 mt-2 bg-light rounded" style="min-height: 50px; font-size: 14px; display:none;">
                    <strong id="dm-name"></strong><br>
                    Latitude: <span id="dm-lat"></span><br>
                    Longitude: <span id="dm-lng"></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}&callback=initialize&libraries=drawing,places&v=3.49"></script>

<script>
    let map;
    let dmMarkers = {};

    function initialize() {
        map = new google.maps.Map(document.getElementById("map-canvas"), {
            zoom: 13,
            center: { lat: 23.757989, lng: 90.360587 },
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        updateDeliveryManMarkers();
        setInterval(updateDeliveryManMarkers, 500);
    }

    function animateMarker(marker, newPosition) {
        const steps = 20;
        const delay = 50;
        const oldPosition = marker.getPosition();
        const deltaLat = (newPosition.lat() - oldPosition.lat()) / steps;
        const deltaLng = (newPosition.lng() - oldPosition.lng()) / steps;
        let step = 0;

        const interval = setInterval(() => {
            const pos = marker.getPosition();
            const lat = pos.lat() + deltaLat;
            const lng = pos.lng() + deltaLng;
            marker.setPosition(new google.maps.LatLng(lat, lng));
            step++;
            if (step >= steps) {
                clearInterval(interval);
                marker.setPosition(newPosition);
            }
        }, delay);
    }

    function updateDeliveryManMarkers() {
        $.get('{{ route('admin.dispatch.deliveryman_list') }}', function(response) {
            if (Array.isArray(response) && response.length > 0) {
                let bounds = new google.maps.LatLngBounds();
                const infowindow = new google.maps.InfoWindow();

                response.forEach(dm => {
                    if (dm.lat && dm.lng) {
                        const newPosition = new google.maps.LatLng(parseFloat(dm.lat), parseFloat(dm.lng));
                        bounds.extend(newPosition);

                        if (dmMarkers[dm.id]) {
                            animateMarker(dmMarkers[dm.id], newPosition);
                        } else {
                            const marker = new google.maps.Marker({
                                position: newPosition,
                                map: map,
                                title: dm.name,
                                icon: "{{ asset('public/assets/admin/img/delivery_boy_active.png') }}"
                            });

                            dmMarkers[dm.id] = marker;

                            google.maps.event.addListener(marker, 'click', function() {
                                infowindow.setContent(`
                                    <div style='float:left'>
                                        <img style='max-height:40px;width:auto;' src='${dm.image_link}'>
                                    </div>
                                    <div style='float:right; padding: 10px;'>
                                        <b>${dm.name}</b><br/>
                                        Assigned Order: ${dm.assigned_order_count}
                                    </div>
                                `);
                                infowindow.open(map, marker);

                                // Update Lat/Lng info below the map
                                document.getElementById('dm-name').innerText = dm.name;
                                document.getElementById('dm-lat').innerText = parseFloat(dm.lat).toFixed(6);
                                document.getElementById('dm-lng').innerText = parseFloat(dm.lng).toFixed(6);
                                document.getElementById('deliveryman-info').style.display = 'block';
                            });
                        }
                    }
                });

                if (!bounds.isEmpty()) {
                    map.fitBounds(bounds);
                }
            }
        });
    }
</script>
@endpush
