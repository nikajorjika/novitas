var localizeData = {
  mapSetupData:[{
    'mapCoors':[41, 41],
    'mapCenterCoords': [41, 41],
    'mapZoom': 14,
    'canvasID': 'map',
    'iconBase': '',
    'mapStyles': [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]
}
]};
// MAP MAKER
function makeMap(mapCoords, mapZoom, canvasID, iconBase, mapCenterCoords, mapStyles) {
  var mapCanvas = document.getElementById(canvasID);
  var mapOptions = {
    center: new google.maps.LatLng(parseFloat(mapCenterCoords[0]), parseFloat(mapCenterCoords[1])),
    zoom: parseInt(mapZoom),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    styles: mapStyles
  }
  var map = new google.maps.Map(mapCanvas, mapOptions);

  for(var i = 0; i < mapCoords.length; i++) {
    var currentCoords = mapCoords[i];
    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(parseFloat(currentCoords[0]), parseFloat(currentCoords[1])),
      map: map
    });
  }
}

// THIS FUNCTION WILL BE RUN AFTER GOOGLE MAP SCRIPTS HAVE BEEN LOADED
function initialize() {
  if(typeof localizeData != "undefined" && typeof localizeData.mapSetupData != "undefined") {
    var mapCoords = localizeData.mapSetupData['mapCoords'];
    var mapCenterCoords = localizeData.mapSetupData['mapCenterCoords'];
    var mapZoom = localizeData.mapSetupData['mapZoom'];
    var canvasID = localizeData.mapSetupData['canvasID'];
    var iconBase = localizeData.mapSetupData['iconBase'];
    var mapStyles = localizeData.mapSetupData['mapStyles'];

    makeMap(mapCoords, mapZoom, canvasID, iconBase, mapCenterCoords, mapStyles);
  }
}

// THIS WILL LOAD GOOGLE MAP SCRIPTS AND RUN INITIALIZE FUNCTION UPON LOAD
function loadMapScript(callback) {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&' +
  'callback='+ callback;
  document.body.appendChild(script);
}
loadMapScript();
