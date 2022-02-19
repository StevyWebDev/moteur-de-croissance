/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import Search from './class/Search'
import Map from './map'
import star from './class/Star'

window.onload = () => {
    star()
}
Map.init()
let SearchAdress = new Search
let inputAdressFormNewCompany = document.querySelector('#company_adress')
if(inputAdressFormNewCompany !== null) {
    SearchAdress.address(inputAdressFormNewCompany, document.querySelector('#company_city'), document.querySelector('#company_number_postal'), document.querySelector('#company_lat'), document.querySelector('#company_lng'))
}

let inputAdressFormSearch = document.querySelector('#address')
if(inputAdressFormSearch !== null) {
    SearchAdress.address(inputAdressFormSearch, null, null, document.querySelector('#lat'), document.querySelector('#lng'))
}

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';



