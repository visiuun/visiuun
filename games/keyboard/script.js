const keys = [..."ABCDEFGHIJKLMNOPQRSTUVWXYZ"];
const timestamps = [];
let cpmElement = document.getElementById("cpm"); // The element to display CPM
let totalChars = 0; // To count the total number of characters typed
let startTime = Date.now(); // To track the time elapsed for CPM calculation

timestamps.unshift(getTimestamp());

function getRandomNumber(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function getRandomKey() {
  return keys[getRandomNumber(0, keys.length - 1)];
}

function targetRandomKey() {
  const key = document.getElementById(getRandomKey());
  key.classList.add("selected");
  let start = Date.now();
}

function getTimestamp() {
  return Math.floor(Date.now() / 1000);
}

// Update CPM every second (1000 milliseconds)
setInterval(function() {
  let elapsedTime = (Date.now() - startTime) / 1000; // Time elapsed in seconds
  let cpm = (totalChars / elapsedTime) * 60; // CPM calculation
  cpmElement.textContent = `Characters per Minute: ${Math.round(cpm)}`;
}, 1000);

document.addEventListener("keyup", event => {
  const keyPressed = String.fromCharCode(event.keyCode);
  const keyElement = document.getElementById(keyPressed);
  const highlightedKey = document.querySelector(".selected");

  keyElement.classList.add("hit");
  keyElement.addEventListener('animationend', () => {
    keyElement.classList.remove("hit");
  });

  if (keyPressed === highlightedKey.innerHTML) {
    totalChars++; // Increment the character count
    timestamps.unshift(getTimestamp());
    highlightedKey.classList.remove("selected");
    targetRandomKey(); // Get a new random key
  }
});

targetRandomKey();