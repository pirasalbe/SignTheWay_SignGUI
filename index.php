<!DOCTYPE html>
<html>
   <head>
      <title>Cartello Stradale</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
      <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.css">
      <style>
         #map {
         height: 400px;
         width: 100%;
         }
      </style>
      <!-- Optional theme -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>   
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/i18n/defaults-*.min.js"></script>
      
      
      <script src="notify.js"></script>

   </head>
   <body>
      <div class="container">
         <h2>Crea o modifica cartello stradale</h2>
         <form class="form-horizontal" method='post' data-toggle="validator" id= "myForm" name="myForm">
           
           
           


            <div class="form-group">
               <label class="control-label col-sm-2" for="KeyLabel">Identificativo:</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" name="Key" id="Key" disabled value= <?php require("readFile.php"); ?> >
               </div>
            </div>
           
            
            <div class="form-group">
               <label class="control-label col-sm-2" for="CoordinateLabel">Coordinate:</label>
               <div class="col-sm-10">
                  <input type="text" class="form-control" name="Coordinate" id="Coordinate" required >
               </div>
            </div>
            
            
            
            <div class="form-group">
               <div class="col-sm-offset-2 ">
                  <div class="col-sm-10">
                     <input type='button' onclick="SetMapByText()" class="btn btn-primary" name='update' value='Aggiorna mappa'>
                     <input type='button' onclick="SetMapByPosition()" class="btn btn-primary" name='autoPosition' value='Ottieni Posizione'>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2"></label>
               <div class="col-sm-10">
                  <div class="panel panel-info">
                     <div class="panel-heading">Aumenta la precisione</div>
                     <div class="panel-body">Toccando la mappa sposterai il puntatore. Se vedi che il puntatore non è abbastanza preciso, tocca il punto preciso sulla mappa. In alternativa è possibile scrivere manualmente le coordinate.</div>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2" for="MapLabel"></label>
               <div class="col-sm-10">
                  <div id="map"></div>
               </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2" for="sex">Lato stradale:</label>
               <div class="col-sm-10">
                  <label class="radio-inline"><input type="radio" name="side" required="true" value= 'D'>Destra</label>
                  <label class="radio-inline"><input type="radio" name="side" required="true" value= 'S' >Sinistra</label>
               </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2" for="startDateLabel">Data di inizio:</label>
               <div class="col-sm-10">
                  <div class="input-group input-append date" id="StartDate">
                     <input type="text"  class="form-control" required="true" id = "startDate" name="startDate" />
                     <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2" for="endDateLabel">Data di fine (facoltativo):</label>
               <div class="col-sm-10">
                  <div class="input-group input-append date" id="EndDate">
                     <input type="text" class="form-control" id="endDate" name="endDate" />
                     <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2" for="com">Tipo di cartello:</label>
               <div class="col-sm-10">
                  <select class="selectpicker" required="true" name = "Type" data-live-search="true" data-width="auto">
                  <?php 
                     $File = array("signalDivieto", "signalIndicazione", "signalObblighi", "signalOrizzontale", "signalPericolo", "signalPrecedenza");
                     $Name = array("DIVIETI", "INDICAZIONI", "OBBLIGHI", "ORIZZONTALI", "PERICOLI", "PRECEDENZE");
                     $i=0;
                     while($i<6)
                     {
                         $SignalList = simplexml_load_file($File[$i].".xml") or die("Error: File can't open");
                         echo "<optgroup label=".$Name[$i].">";
                         foreach($SignalList->option as $SingleSignal)   {
                           echo "<option value=".$SingleSignal['value'].">".strtoupper($SingleSignal)."</option>";
                         }
                         echo "</optgroup>";
                         $i++;
                     }
                         
                     ?>
                  </select>
               </div>
            </div>

            <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
                  <input type='submit' class="btn btn-primary" name='invio' value='Conferma'>
               </div>
            </div>
         </form>
         <?php
            require ('Output.php');
            
            ?>
            
            
      

         <script type="text/javascript">
           // document.getElementById("Key").value= "La chiave";

              

            var map;
            var markers = [];
            var currentLatitude;
            var currentLongitude;
            // document.getElementById("startDate").value= "11/30/2016 12:00 AM";
            
            function initMap(lat=0, long=0) {
              
             var uluru = {lat: 45.5472729, lng: 11.5471119};
              map = new google.maps.Map(document.getElementById('map'), {
               zoom: 5,
               center: uluru
             });
             
              marker = new google.maps.Marker({
              // position: uluru,
            //   map: map
             });
             
            
             map.addListener('click', function(e) {
               
            
                  var latitude = e.latLng.lat();
            var longitude =  e.latLng.lng();
            
            document.getElementById("Coordinate").value= latitude + " "+longitude;
            
               placeMarkerAndPanTo(e.latLng, map);
            
             });
            }
                        
            function SetMapByPosition()
            {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    alert("Il tuo browser non è supportato, usane un'altro");
                    }
            }
            
            
              function showPosition(position) {
                  var output= position.coords.latitude + " " + position.coords.longitude;
                  
                  placeMarkerAndPanTo(null, map,position.coords.latitude,  position.coords.longitude)
                                var Coordinates = document.getElementById("Coordinate").value= output;
            
              }
            
            function SetMapByText()
            {
              var Coordinates = document.getElementById("Coordinate").value;
              Coordinates = Coordinates.replace(',','');
              document.getElementById("Coordinate").value= Coordinates;
              var splitted = Coordinates.split(" ");
              if (splitted.length!=2)
              {
                alert("Le coordinate non sono inserite correttamente\nInserisce la latitudine xx.xxx e la longitudine yy.yyy separati da uno spazio");
              }
              else
               placeMarkerAndPanTo(null, map, splitted[0], splitted[1]);
            }
            
            function placeMarkerAndPanTo(latLng, map, lat, lon) {
              if (latLng==null)
              {
                latLng = new google.maps.LatLng(lat, lon)
              }
             marker.setMap(null);
             
             marker = new google.maps.Marker({
            position: latLng,
            map: map
            
            });
            
            
            if (map.getZoom()==5)
            {
              map.setCenter(latLng);
            map.setZoom(18);
            }
            }
            
            
            function clearMarkers(map) {
             setMapOnAll(null);
            }
            
             $(document).ready(function() {
               SetMapByPosition();
                $('#startDate').datetimepicker({
            
                 })
                 
                $('#endDate').datetimepicker({
                  //  autoclose: true
                 })
            });
            
         </script>
         <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXZYq-f8Y5LlM2nT4x8QCnd6Rnsxl97dc&callback=initMap"></script>
      </div>
   </body>
</html>