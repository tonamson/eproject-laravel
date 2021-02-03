@extends('main._layouts.master')

<?php
    // {{ }} <--- cac ky tu dac biet se duoc thay the
    // {!! !!} <--- cac ky tu dac biet se khong thay the
    // {{-- --}} <--- comment code trong blade
    /**
     * section('scripts') <--- coi o? master.blade.php <--- no' la @yield('scripts')
     * section co' mo? la phai co' dong'
     * neu ma soan code php thi nen de? tren dau` de? no' load tuan tu chinh xac hon giong nhu code php nam tren section('scripts') vay ok roi
     * */
?>

@section('css')
   
@endsection

@section('js')    

@endsection

@section('content')
    <div class="card">
        <h1 class="pt-3 pl-3 pr-3">Chấm công GPS</h1>
        <form method="POST" action="/check-in-gps">
            @csrf
            <div class="row p-3">
                @if (\Session::has('success'))
                    <div class="col-12">
                        <div class="alert alert-success">
                            {!! \Session::get('success') !!}
                        </div>
                    </div>
                @endif

                @if (\Session::has('error'))
                    <div class="col-12">
                        <div class="alert alert-danger">
                            {!! \Session::get('error') !!}
                        </div>
                    </div>
                @endif
    
                <div class="col-12 col-md-6">
                    
                    <div class="form-group">
                        <label class="font-weight-semibold" style="font-size: 0.9rem">Ngày chấm công:</label>
                        <div class="form-control-plaintext" style="font-size: 0.9rem">
                            <?php echo date('d/m/Y') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" style="font-size: 0.9rem">Tên nhân viên:</label>
                        <div class="form-control-plaintext" style="font-size: 0.9rem">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" style="font-size: 0.9rem">Mã nhân viên:</label>
                        <div class="form-control-plaintext" style="font-size: 0.9rem">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" style="font-size: 0.9rem">Phòng ban:</label>
                        <div class="form-control-plaintext" style="font-size: 0.9rem">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" style="font-size: 0.9rem">Văn phòng:</label>
                        <div class="form-control-plaintext" style="font-size: 0.9rem">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" style="font-size: 0.9rem">Vị trí GPS nhân viên: </label>
                        <input id="latitude" name="latitude" value="" readonly/> 
                        <input id="longitude" name="longitude" value="" readonly/>
                        <input type="hidden" id="latitude1" name="latitude1" value="" readonly/> 
                        <input type="hidden" id="longitude1" name="longitude1" value="" readonly/>
                    </div>
        
                    <div class="warning">
                        <span id="fail-message" class="warning-msg"></span>
                    </div>
        
                </div>
        
                <div class="col-12 col-md-6">
                    <div class="title-open-gps">
                        <p><a target="_blank" href="https://drive.google.com/open?id=0Bw9Gp6m1QiZjYWRybTBjY1JILVk" style="color: #046A38">* Hướng dẫn bật GPS trên thiết bị Android</a></p>
                        <p><a target="_blank" href="https://drive.google.com/open?id=0Bw9Gp6m1QiZjZEowc2tsOGNkOVk" style="color: #046A38">* Hướng dẫn bật GPS trên thiết bị IOS</a></p>
                        <p><a target="_blank" href="https://drive.google.com/open?id=1yMXMksNrdXEsye3hlVvqBJsGyM1SX1UR" style="color: #046A38">* Hướng dẫn chấm công GPS</a></p>
                        <p><span style="color: red; font-size: 1rem;">* Ghi chú: Ưu tiên sử dụng trình duyệt Chrome đối với chức năng chấm công GPS</span></p>
                        <p><span style="color: red; font-size: 1rem;">* Ưu tiên sử dụng 3G/4G thay Wifi đối với chức năng chấm công GPS</span></p>
                    </div>
                </div>

                <div class="col-12 col-md-12">
                    <button type="submit" class="btn btn-primary mt-2 w-auto h-auto">Chấm công</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            getLocation();
            setInterval(function(){getLocation();},100000);
        });

        function getLocation() {
            x =  document.getElementById("fail-message");
            if (navigator.geolocation) {
          
                navigator.geolocation.getCurrentPosition(function(position,showError) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                    window.latitude = position.coords.latitude;
                    window.longitude = position.coords.longitude;
                
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + position.coords.latitude + '%2C' + position.coords.longitude + '&language=en';
                    console.log(GEOCODING);
                    $.getJSON(GEOCODING).done(function(location) {
 
                    })
                });
            } else { 
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {            
            window.latitude = position.coords.latitude;
            window.longitude = position.coords.longitude;
            
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('latitude1').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            document.getElementById('longitude1').value = position.coords.longitude;
        }

        function showError(error) {
            x =  document.getElementById("fail-message");
            switch (error.code) {
                case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation."
                    break;
                case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
        }
    </script>
@endsection