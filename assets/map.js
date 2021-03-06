import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

export default class Map {

    static init () {
        let map = document.querySelector('#map')
        if (map === null) {
            return;
        }

        let icon = L.icon({
            iconUrl: '/images/marker-icon.png',
        })
        let center = [map.dataset.lat, map.dataset.lng]
        map = L.map('map').setView(center, 15)
        let token = 'pk.eyJ1IjoiZ3JhZmlrYXJ0IiwiYSI6ImNqaHoxancyOTBxNXkzcW10MHI3NXZrNjkifQ.yWqQe1qK_RtMA2Z4qABvmg'
        L.tileLayer(`https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=${token}`, {
            tileSize: 512,
            maxZoom: 18,
            zoomOffset: -1,
            minZoom: 6,
            id: 'mapbox/streets-v11',
            attribution: '© <a href="https://www.mapbox.com/feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map)
        L.marker(center, {icon: icon}).addTo(map)
    }

}
