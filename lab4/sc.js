const WEATHER_KEY = "2738bcc73639fddc762f871fc4a9088e"; 

async function getWeather(city) {
  const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${WEATHER_KEY}&units=metric`;
  try {
    const response = await fetch(url);
    const data = await response.json();
    if (data.cod !== 200) {
      document.getElementById("city-name").textContent = "City not found.";
      return;
    }

    document.getElementById("city-name").textContent = "City: " + data.name;
    document.getElementById("temperature").textContent = "Temperature: " + data.main.temp + " °C";
    document.getElementById("description").textContent = "Description: " + data.weather[0].description;
    document.getElementById("icon").src = `https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`;

    // Change background based on weather
    const condition = data.weather[0].main.toLowerCase();
    if (condition.includes("rain")) document.body.style.background = "linear-gradient(135deg, #667db6, #0082c8, #0082c8, #667db6)";
    else if (condition.includes("cloud")) document.body.style.background = "linear-gradient(135deg, #bdc3c7, #2c3e50)";
    else if (condition.includes("clear")) document.body.style.background = "linear-gradient(135deg, #2980b9, #6dd5fa, #ffffff)";
    else document.body.style.background = "linear-gradient(135deg, #4facfe, #00f2fe)";
  } catch (error) {
    console.error("Weather API error:", error);
  }
}

async function getWordOfTheDay() {
  try {
    const response = await fetch("https://random-word-api.herokuapp.com/word");
    const [word] = await response.json();
    document.getElementById("word").textContent = word;

    const defResponse = await fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${word}`);
    const defData = await defResponse.json();
    if (defData && defData[0] && defData[0].meanings) {
      const meaning = defData[0].meanings[0];
      document.getElementById("partOfSpeech").textContent = "Part of Speech: " + meaning.partOfSpeech;
      document.getElementById("definition").textContent = "Definition: " + meaning.definitions[0].definition;
    } else {
      document.getElementById("definition").textContent = "No definition found.";
    }
  } catch (error) {
    console.error("Word API error:", error);
  }
}

document.getElementById("searchBtn").addEventListener("click", () => {
  const city = document.getElementById("city").value;
  if (city) getWeather(city);
});

document.getElementById("newWordBtn").addEventListener("click", getWordOfTheDay);

// Initial call
getWordOfTheDay();
