var mymap = L.map('mapid', { editable: true }).setView([-8.5330242817551, 115.21276982331896], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
    maxZoom: 18,
}).addTo(mymap);

// Ensure the polyline is initialized and added to the map
var polyline = L.polyline([], { color: 'red' }).addTo(mymap);
polyline.on('editable:vertex:click', function (event) {
    // Uncomment the line below if you want to cancel the click event
    // event.cancel();
});

polyline.on('editable:vertex:contextmenu', function (event) {
    if (polyline && polyline.editor) {
        var latlngs = event.layer.getLatLngs();
        var index = latlngs.findIndex(function (latlng) {
            return latlng.lat === event.latlng.lat && latlng.lng === event.latlng.lng;
        });
        latlngs.splice(index, 1);
        event.layer.setLatLngs(latlngs);
        polyline.editor.reset();
        console.log(polylineToJson(polyline.getLatLngs())); // Output string JSON
        console.log(polyline.encodePath());
    } else {
        console.error('Polyline or Editable not defined or initialized properly.');
    }
});

function polylineToJson(latLangs) {
    var jsonArray = latLangs.map(function (latlng) {
        return [latlng.lat, latlng.lng];
    });
    var jsonString = JSON.stringify(jsonArray);
    return jsonString;
}

mymap.on('click', function (e) {
    if (polyline && polyline.addLatLng && polyline.editor && polyline.editor.reset) {
        polyline.addLatLng(e.latlng);
        polyline.editor.reset();
        console.log(polylineToJson(polyline.getLatLngs())); // Output string JSON
        console.log(polyline.encodePath());
    } else {
        console.error('Polyline or Editable not defined or initialized properly.');
    }
});
