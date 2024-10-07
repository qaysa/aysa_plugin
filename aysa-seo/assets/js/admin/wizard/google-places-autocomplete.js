function initialize() {
    let options = {
        types: ['(cities)'],
        fields: ['name', 'id']
    };

    let input = document.getElementById('targeted_city');
    let autocomplete = new google.maps.places.Autocomplete(input, options);

    autocomplete.addListener('place_changed', function () {
        let place = autocomplete.getPlace();
        if (place && place.name) {
            input.value = place.name;
        }
    });
}

google.maps.event.addDomListener(window, 'load', initialize);