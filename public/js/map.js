// titik lokasi
var locations = [
  ["LOCATION_1", -6.493814412066375, 108.39643000125932],
  ["LOCATION_2", -6.494692345053258, 108.40012506789785],
  ["LOCATION_3", -6.492517462806679, 108.39528533387676],
  ["LOCATION_4", -6.4910010255891955, 108.39906072805088],
  ["LOCATION_5", -6.489724022285198, 108.39669106575009],
  ["LOCATION_6", -6.499718959848791, 108.40850964309277],
  ["LOCATION_7", -6.499639010781775, 108.40967372181181],
];

// titik pusat lokasi
var map = L.map("map").setView([-6.492711812043444, 108.39794359585109], 15);
mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "&copy; " + mapLink + " Contributors",
  maxZoom: 18,
}).addTo(map);

for (var i = 0; i < locations.length; i++) {
  marker = new L.marker([locations[i][1], locations[i][2]])
    .bindPopup(locations[i][0])
    .addTo(map);
}
