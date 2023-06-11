$(document).ready(function() {
    var map = L.map('map').setView([51.505, -0.09], 13); // Set initial map view

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Handle form submission
    $('#route-form').submit(function(e) {
        e.preventDefault();
        var start = $('#start').val();
        var end = $('#end').val();

        // Perform an AJAX request to get the route from the server
        $.ajax({
            url: 'route.php',
            type: 'POST',
            data: {
                start: start,
                end: end
            },
            success: function(response) {
                // Parse the response and display the route on the map
                var route = JSON.parse(response);
                var routeCoordinates = route.coordinates;

                // Remove any previously added route
                map.eachLayer(function(layer) {
                    if (layer instanceof L.Polyline) {
                        map.removeLayer(layer);
                    }
                });

                // Draw the route on the map
                var polyline = L.polyline(routeCoordinates).addTo(map);
                map.fitBounds(polyline.getBounds());

                // Display turn-by-turn directions and distance information
                var directions = route.directions;
                var distance = route.distance;

                $('#directions').html(directions);
                $('#distance').html('Distance: ' + distance);

                // Save route data in the database
                $.ajax({
                    url: 'save_route.php',
                    type: 'POST',
                    data: {
                        start: start,
                        end: end,
                        route: response
                    },
                    success: function() {
                        console.log('Route data saved in the database.');
                    },
                    error: function() {
                        console.log('Error occurred while saving route data in the database.');
                    }
                });
            },
            error: function() {
                alert('Error occurred while fetching the route. Please try again.');
            }
        });
    });
});
