import Places from 'places.js'

export default class Search {

    address(address, city = null, postal = null, lat, lng) {
        let place = Places({
            container: address
        })

        place.on('change', e => {
            if(city !== null && postal !== null) {
                city.value = e.suggestion.city
                postal.value = e.suggestion.postcode
            }
            lat.value = e.suggestion.latlng.lat
            lng.value = e.suggestion.latlng.lng
        })
    }
}