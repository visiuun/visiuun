// Fetch current location using the Geolocation API
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function (position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;

    // Use Geoapify API to get the city name from latitude and longitude
    getCityName(latitude, longitude);
    
    // Fetch weather data using Open-Meteo API with current location
    fetchWeatherData(latitude, longitude);
  }, function (error) {
    alert("Unable to retrieve your location.");
  });
} else {
  alert("Geolocation is not supported by your browser.");
}

// Function to fetch city name using Geoapify API
function getCityName(latitude, longitude) {
  const geoapifyUrl = `https://api.geoapify.com/v1/geocode/reverse?lat=${latitude}&lon=${longitude}&apiKey=ccd99fab9f914453b67a62967e4a7430`;

  fetch(geoapifyUrl)
    .then(response => response.json())
    .then(data => {
      const city = data.features[0]?.properties.city || 'Unknown location';
      document.querySelector(".location").textContent = city; // Display city name
    })
    .catch(error => {
      console.error("Error fetching city name:", error);
    });
}

// Function to fetch weather data from Open-Meteo API
function fetchWeatherData(latitude, longitude) {
  const apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,relative_humidity_2m,apparent_temperature,is_day,precipitation,rain,showers,snowfall,weather_code,cloud_cover,pressure_msl,surface_pressure,wind_speed_10m,wind_direction_10m,wind_gusts_10m&hourly=temperature_2m&daily=weather_code,temperature_2m_max,temperature_2m_min,sunrise,sunset,daylight_duration,sunshine_duration,uv_index_max,uv_index_clear_sky_max,precipitation_sum,rain_sum,showers_sum,snowfall_sum,precipitation_hours,precipitation_probability_max,wind_speed_10m_max,wind_direction_10m_dominant,shortwave_radiation_sum,et0_fao_evapotranspiration`;

  fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      const currentWeather = data.current;
      const currentTemperature = currentWeather.temperature_2m;
      const currentHumidity = currentWeather.relative_humidity_2m;
	  const currentPrecProb = currentWeather.precipitation;
      const currentWindSpeed = currentWeather.wind_speed_10m;
      const currentWeatherDesc = getWeatherDescription(currentWeather.weather_code);
      const isDay = currentWeather.is_day; // Determines if it's day or night

      // Update the weather data in your HTML
      document.querySelector(".weather-temp").textContent = `${currentTemperature}°C`;
      document.querySelector(".weather-desc").textContent = currentWeatherDesc;
      document.querySelector(".humidity .value").textContent = `${currentHumidity} %`;
      document.querySelector(".wind .value").textContent = `${currentWindSpeed} km/h`;
	   document.querySelector(".precipitation .value").textContent = `${currentPrecProb} %`;

      // Update the weather icon based on day or night
      const mainIcon = document.querySelector(".weather-icon");
      mainIcon.setAttribute("data-feather", isDay ? "sun" : "moon"); // Switch between sun and moon

      // Update the forecast for the week
      updateWeekForecast(data.daily, isDay);
    })
    .catch(error => {
      console.error("Error fetching weather data:", error);
    });
}

// Function to update the weekly forecast
function updateWeekForecast(dailyData, isDay) {
  const weekList = document.querySelector('.week-list');
  const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  const currentDayIndex = new Date().getDay(); // Get current day index (0 = Sun, 1 = Mon, ..., 6 = Sat)

  // Loop through the daily data and update the forecast for each day
  dailyData.weather_code.forEach((weatherCode, index) => {
    const dayElement = weekList.children[index];
    const dayName = daysOfWeek[(currentDayIndex + index) % 7]; // Adjust the day order based on the current day
    const dayTempMax = `${dailyData.temperature_2m_max[index]}°C`;
    const dayTempMin = `${dailyData.temperature_2m_min[index]}°C`;

    // Get the correct icon based on weather code and day/night
    const dayIcon = getWeatherIcon(weatherCode, isDay);

    // Update the list items
    if (dayElement) {
      dayElement.querySelector('.day-name').textContent = dayName;
      dayElement.querySelector('.day-temp').textContent = dayTempMax;
      dayElement.querySelector('.day-icon').setAttribute('data-feather', dayIcon); // Set icon
    }
  });

  feather.replace(); // Re-render icons
}

// Helper function to map weather codes to descriptions and icons
function getWeatherDescription(code) {
  const weatherCodes = {
    0: "Clear sky",
    1: "Mainly clear",
    2: "Partly cloudy",
    3: "Cloudy",
    4: "Overcast",
    5: "Fog",
    6: "Drizzle",
    7: "Rain",
    8: "Heavy rain",
    9: "Showers",
    10: "Snowfall",
    11: "Heavy snowfall",
    12: "Thunderstorm"
  };
  return weatherCodes[code] || "Unknown weather";
}

// Helper function to map weather codes to icons, adjusting for day/night
function getWeatherIcon(code, isDay) {
  const icons = {
    0: isDay ? "sun" : "moon",          // Clear sky
    1: isDay ? "cloud-sun" : "cloud-moon", // Mainly clear
    2: isDay ? "cloud-sun" : "cloud-moon", // Partly cloudy
    3: "cloud",                        // Cloudy
    4: "cloud",                        // Overcast
    5: "cloud",                        // Fog
    6: "cloud-drizzle",                // Drizzle
    7: "cloud-rain",                   // Rain
    8: "cloud-rain",                   // Heavy rain
    9: "cloud-rain",                   // Showers
    10: "cloud-snow",                  // Snowfall
    11: "cloud-snow",                  // Heavy snowfall
    12: "cloud-lightning"              // Thunderstorm
  };
  return icons[code] || "cloud"; // Default icon if weather code is unknown
}

// Function to determine whether it's day or night
function isDaytime() {
    const hours = new Date().getHours();
    return hours >= 6 && hours < 18; // Daytime is from 6 AM to 6 PM
}

// Function to determine the gradient based on weather conditions and time of day
function updateGradient(weatherCondition) {
    const weatherSide = document.querySelector('.weather-side');
    
    // Remove any previous condition classes
    weatherSide.classList.remove('snow', 'rain', 'clear-night', 'clear-day', 'others');
    
    if (weatherCondition === 'snow') {
        weatherSide.classList.add('snow');
    } else if (weatherCondition === 'rain') {
        weatherSide.classList.add('rain');
    } else if (weatherCondition === 'clear') {
        if (isDaytime()) {
            weatherSide.classList.add('clear-day'); // Orange gradient for day
        } else {
            weatherSide.classList.add('clear-night'); // Normal gradient for night
        }
    } else {
        weatherSide.classList.add('others');
    }
}

// Example of how to get weather data and call the update function
fetch('apiurl')
  .then(response => response.json())
  .then(data => {
      const weatherCondition = data.current.weather[0].main.toLowerCase(); // snow, rain, clear, etc.
      updateGradient(weatherCondition);
  });

// Function to format the current date
function updateDate() {
    const now = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = now.toLocaleDateString('en-US', options);
    
    // Get the day and date
    const dayName = formattedDate.split(',')[0]; // Day of the week
    const day = formattedDate.split(',')[1].trim(); // Full date (Month Day, Year)

    // Update the elements on the page
    document.querySelector('.date-dayname').textContent = dayName;
    document.querySelector('.date-day').textContent = day;
}

// Call the function to update the date when the page loads
window.onload = updateDate;