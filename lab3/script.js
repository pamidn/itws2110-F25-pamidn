const API_KEY = "2738bcc73639fddc762f871fc4a9088e"; // Replace with your OpenWeatherMap key
const city = "Troy";

async function getWeather() {
  try {
    const response = await fetch(
      `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${API_KEY}&units=imperial`
    );
    const data = await response.json();

    const temp = data.main.temp;
    const condition = data.weather[0].description;
    const humidity = data.main.humidity;
    const wind = data.wind.speed;

    document.getElementById("temp").textContent = `Temperature: ${temp.toFixed(1)} °F`;
    document.getElementById("condition").textContent = `Condition: ${condition}`;
    document.getElementById("humidity").textContent = `Humidity: ${humidity}%`;
    document.getElementById("wind").textContent = `Wind Speed: ${wind} mph`;
    document.getElementById("emoji").textContent = getWeatherEmoji(data.weather[0].main);
    document.getElementById("updated").textContent = `Last updated: ${new Date().toLocaleTimeString()}`;

    setBackgroundGradient(temp);
  } catch (error) {
    document.getElementById("temp").textContent = "Failed to load weather data.";
    console.error("Weather fetch error:", error);
  }
}

function getWeatherEmoji(condition) {
  condition = condition.toLowerCase();
  if (condition.includes("cloud")) return "☁️";
  if (condition.includes("rain")) return "🌧️";
  if (condition.includes("snow")) return "❄️";
  if (condition.includes("thunder")) return "⛈️";
  if (condition.includes("clear")) return "☀️";
  if (condition.includes("mist") || condition.includes("fog")) return "🌫️";
  return "🌍";
}

function setBackgroundGradient(temp) {
  let gradient;
  if (temp < 50) {
    gradient = "linear-gradient(135deg, #4a90e2, #50c9ce)";
  } else if (temp >= 50 && temp <= 75) {
    gradient = "linear-gradient(135deg, #56ab2f, #a8e063)";
  } else {
    gradient = "linear-gradient(135deg, #ff9966, #ff5e62)";
  }
  document.body.style.background = gradient;
}

async function getDogImage() {
  try {
    const response = await fetch("https://dog.ceo/api/breeds/image/random");
    const data = await response.json();
    document.getElementById("dog-image").src = data.message;
  } catch (error) {
    console.error("Dog API error:", error);
  }
}

document.getElementById("dog-btn").addEventListener("click", getDogImage);

getWeather();
getDogImage();
