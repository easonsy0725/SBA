const fetchWeatherData = async () => {
  try {
      const response = await fetch('https://api.openweathermap.org/data/2.5/weather?q=Tokyo&appid=9c6c88bdf27df268e8e0bb5787a30e70&units=metric');
      const data = await response.json();

      return {
          description: data.weather[0].description,
          temperature: data.main.temp,
          wind: data.wind.speed,
          humidity: data.main.humidity
      };
  } catch (error) {
      console.error('Error fetching weather data:', error);
      return null;
  }
};

// Update the weather display
const updateWeatherDisplay = async () => {
  const weatherData = await fetchWeatherData();

  if (weatherData) {
      document.getElementById("weather-description").textContent = weatherData.description;
      document.getElementById("weather-temperature").textContent = `${weatherData.temperature}°C`;
      document.getElementById("weather-wind").textContent = `${weatherData.wind} km/h`;
      document.getElementById("weather-humidity").textContent = `${weatherData.humidity}%`;
  } else {
      // Handle error case
      document.getElementById("weather-description").textContent = "Unable to fetch weather data";
      document.getElementById("weather-temperature").textContent = "--";
      document.getElementById("weather-wind").textContent = "--";
      document.getElementById("weather-humidity").textContent = "--";
  }
};

// Call the updateWeatherDisplay function when the page loads
window.addEventListener('load', updateWeatherDisplay);