const searchElement = document.querySelector('[data-city-search]')
const searchBox = new google.maps.places.SearchBox(searchElement)
searchBox.addListener('places_changed', () => {

  const place = searchBox.getPlaces()[0]
  if (place == null) {
      return "please enter valid place!";
  }

  const latitude = place.geometry.location.lat()
  const longitude = place.geometry.location.lng()

  const proxy= "https://cors-anywhere.herokuapp.com/";
  const api = `${proxy}https://api.darksky.net/forecast/444e72390dedff6ef44c8fb8d6c848db/${latitude},${longitude}`;
  
  fetch(api)
    .then(response=>{
      return response.json();
    })
    .then(data=>{
    console.log(data)
    setWeatherData(data, place)
    })
   
})

const icon = new Skycons({ color: '#800' })
const locationElement = document.querySelector('[data-location]')
const statusElement = document.querySelector('[data-status]')
const temperatureElement = document.querySelector('[data-temperature]')
const precipitationElement = document.querySelector('[data-precipitation]')
const windElement = document.querySelector('[data-wind]')
const humidityElement=document.querySelector('[data-humidity]')
const uvElement=document.querySelector('[data-uv]')
icon.set('icon', 'clear-day')

function setWeatherData(data, place) {

  icon.set('icon', data.currently.icon)
  locationElement.textContent = place.formatted_address
  statusElement.textContent = data.currently.summary
  temperatureElement.textContent = data.currently.temperature
  precipitationElement.textContent = `${data.currently.precipProbability * 100}%`
  windElement.textContent = data.currently.windSpeed
  humidityElement.textContent=data.currently.humidity
  uvElement.textContent=data.currently.uvIndex

   
}
 


