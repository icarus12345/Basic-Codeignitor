       

        <div class="banner mask light">
            <div>
                <!-- <div class="blur"> -->
                    <div class="banner-bg cover" style="background-image:url(<?php echo base_url(''); ?>assets/creative/images/about.jpg)"></div>
                <!-- </div> -->
                <div class="banner-content">
                    <div>
                        <div class="breardcum">
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Trang Chủ</span>
                            <span data-wow-delay="0.5s" class="wow fadeInUp">Liên Hệ</span>
                        </div>
                    </div>
                    <div data-wow-delay="1s" class="wow fadeInUp">
                        <div class="title">Liên Hệ</div>
                    </div>
                    <div class="line">
                        <span class="before-line"></span>
                        <span class="after-line"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="map">
            <div id="map" style=""></div>
            <script type="text/javascript" src="<?php echo base_url() ?>assets/creative/js/map-style.js"></script>
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyB6TJrMx3v003kFpoOUSgugZSk8j1WWK_s"></script>
            <script type="text/javascript">
                // When the window has finished loading create our google map below
                google.maps.event.addDomListener(window, 'load', init);
                function init() {
                    var latlon = [10.792048, 106.679982];
                    var lat  = latlon[0], lon = latlon[1];

                    // Basic options for a simple Google Map
                    // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
                    
                    var mapOptions = {
                        // How zoomed in you want the map to start at (always required)
                        zoom: 17,

                        // The latitude and longitude to center the map (always required)
                        center: new google.maps.LatLng(lat, lon), // New York

                        // How you would like to style the map. 
                        // This is where you would paste any style found on Snazzy Maps.
                        styles: mapstyle,
                        scrollwheel: false,

                    };
                    
                    // Get the HTML DOM element that will contain your map 
                    // We are using a div with id="map" seen below in the <body>
                    var mapElement = document.getElementById('map');

                    // Create the Google Map using our element and options defined above
                    var map = new google.maps.Map(mapElement, mapOptions);

                    // Let's also add a marker while we're at it
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(lat, lon),
                        map: map,
                        icon: new google.maps.MarkerImage(
                            '<?php echo base_url() ?>assets/creative/images/pin_happy.png',
                            new google.maps.Size(30, 42),
                            new google.maps.Point(0, 0),
                            new google.maps.Point(15, 21),
                            new google.maps.Size(30, 42)
                        ),
                        title: 'ADELAIDE EYE & LASER'
                    });
                    var infowindow = new google.maps.InfoWindow();
                    var content_info ='\
                          <div style="width:360px;font-size:13px;">\
                              <img src="<?php echo base_url() ?>assets/creative/images/logo-black.png" style="float:left;margin-right:10px"/>\
                              <div><h4 style="margin:0;padding:4px 0;color:#ee4034;font-weight:100">CREATIVE DESIGN STUDIO</h4></div>\
                              <div>Phone : +61 8 8274 7000 - 1800 809 991<br/>Email: cds@gmail.com</div>\
                              <div>Address : <i>215 Greenhill Rd, Eastwood SA 5063, Australia</i></div>\
                          </div>';
                    infowindow.setPosition(new google.maps.LatLng(lat, lon));
                    infowindow.setContent(content_info);
                    infowindow.open(map,marker); 
                    google.maps.event.addListener(marker, 'click', (function(marker) {
                        
                        return function() {
                            infowindow.open(map, marker);
                        };
                    })(marker));
                }
                
                $(document).ready(function(){
                    
                });
            </script>
        </div>
        <div class="boxs contact-box">
            <div class="box-thumb">
                <div class="nailthumb" >
                    <div class="nailthumb-container cover wow fadeIn" style="background-image:url(<?php echo base_url() ?>assets/creative/images/map.jpg)" >
                    </div>
                    <div class="text-content">
                        <div class="title slideInUp wow" data-fz="big" >-- CREATIVE DESIGN --</div>
                        <div class="desc slideInUp wow" data-fz="medium">
                            <p><span class="fa fa-home"></span> Địa chỉ : Lorem Ipsum is simply dummy text</p>
                            <p><span class="fa fa-phone"></span> Hotline : Lorem Ipsum is simply dummy text</p>
                            <p><span class="fa fa-envelope"></span> Email : Lorem Ipsum is simply dummy text</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-text" >
                <div>
                    <div class="text-content">
                        <div class="title slideInUp wow" data-fz="big" >-- LIÊN HỆ VỚI CHÚNG TÔI --</div>
                        <div class="desc wow slideInUp text-justify" data-fz="medium" >Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                        <form name="contactForm" id="contactForm" target="integration_asynchronous">
                            <div>
                                <div class="row half">
                                    <div class="col-xs-6 half pull-bottom">
                                        <!-- <div class="input-group"> -->
                                            <input 
                                                name="contact_name" data-fz="medium"
                                                class="form-control dark validate[required,minSize[4],maxSize[255]]" 
                                                data-prompt-position="topLeft:0,20"
                                                placeholder="Họ và Tên">
                                            <!-- <label>Họ và tên</label> -->
                                        <!-- </div> -->
                                        <!-- <div class="space-line"></div> -->
                                    </div>
                                    <div class="col-xs-6 half pull-bottom">
                                        <!-- <div class="input-group"> -->
                                            <!-- <div>Số điện thoại</div> -->
                                            <input 
                                                name="contact_phone" data-fz="medium"
                                                class="form-control dark validate[required,minSize[7],maxSize[12]]" 
                                                data-prompt-position="topLeft:0,20"
                                                placeholder="Số Điện thoại">
                                        <!-- </div> -->
                                        <!-- <div class="space-line"></div> -->
                                    </div>
                                </div>
                                <div class="row half">
                                    <div class="col-xs-6 half pull-bottom">
                                        <!-- <div class="input-group"> -->
                                            <!-- <div>Email</div> -->
                                            <input 
                                                name="contact_email" value="" data-fz="medium"
                                                class="form-control dark validate[required,custom[email],maxSize[100]]" 
                                                data-prompt-position="topLeft:0,20"
                                                placeholder="Email">
                                        <!-- </div> -->
                                        <!-- <div class="space-line"></div> -->
                                    </div>
                                    <div class="col-xs-6 half pull-bottom">
                                        <!-- <div class="input-group"> -->
                                            <!-- <div>Địa chỉ</div> -->
                                            <input 
                                                name="contact_data" data-fz="medium"
                                                class="form-control dark validate[required,minSize[10],maxSize[255]]" 
                                                data-prompt-position="topLeft:0,20"
                                                placeholder="Địa chỉ">
                                        <!-- </div> -->
                                        <!-- <div class="space-line"></div> -->
                                    </div>
                                </div>
                                <div class="row half">
                                    <div class="col-xs-12 half">
                                        <!-- <div class="input-group"> -->
                                            <!-- <div>Nội dung</div> -->
                                            <textarea 
                                                name="contact_message" 
                                                rows="2" data-fz="medium"
                                                class="form-control dark validate[required,minSize[10],maxSize[4000]]"
                                                data-prompt-position="topLeft:0,20"
                                                placeholder="Nội dung"></textarea>
                                        <!-- </div> -->
                                        <!-- <div class="space-line"></div> -->
                                    </div>
                                </div>
                            
                                <input type="hidden" name="contact_type" value="Contact us">
                                <div style="height:50px"></div>
                            </div>
                        </form>


                    </div>
                    <div class="contact-submit">GỬI THÔNG TIN</div>
                </div>
            </div>
        </div>



