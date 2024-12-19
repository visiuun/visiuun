// Automatically detect the user's language
const userLanguage = navigator.language || navigator.userLanguage;

// Object containing translations for different languages
const translations = {
  en: {
    greeting: "Hi, I am Vis.",
    welcome: "Welcome To My Website.",
    explore: "Explore Now",
    products: "My Products",
    nekobox: "Free File Hosting And Sharing Platform.",
    tryItOut: "Try it out",
    neko: "A Very Basic Chatbot That Almost Never Works.",
    tryV1: "Try V1",
    tryV2: "Try V2",
    apis: "Documentation And Information On My API Endpoints",
    documentation: "Documentation",
    rps: "A Rock Paper Scissors Dice Game.",
    play: "Play",
    clock: "A Pink Or Black Animated Clock.",
    pinkClock: "Pink Clock",
    blackClock: "Black Clock",
    keyboard: "A Challenging Game To Test Your Reaction Speed And Accuracy.",
    fetish: "A Work In Progress Wiki About Most Of The Existing Fetishes (For Information Purposes).",
    openWiki: "Open The Wiki"
  },
  it: {
    greeting: "Ciao, sono Vis.",
    welcome: "Benvenuto nel mio sito web.",
    explore: "Esplora Ora",
    products: "I Miei Prodotti",
    nekobox: "Piattaforma Gratuita per l'Hosting e la Condivisione di File.",
    tryItOut: "Provalo",
    neko: "Un Chatbot Molto Semplice Che Quasi Mai Funziona.",
    tryV1: "Prova V1",
    tryV2: "Prova V2",
    apis: "Documentazione e informazioni sui miei Endpoint API",
    documentation: "Documentazione",
    rps: "Un Gioco di Carta, Forbice, Sasso.",
    play: "Gioca",
    clock: "Un Orologio Animato Rosa o Nero.",
    pinkClock: "Orologio Rosa",
    blackClock: "Orologio Nero",
    keyboard: "Un Gioco Stimolante per Testare la Tua Velocità e Precisione.",
    fetish: "Un Wiki in Sviluppo su Molti dei Fetish Esistenti (A Scopo Informativo).",
    openWiki: "Apri il Wiki"
  },
  // Other languages omitted for brevity...
};

// Function to get language code from the browser's language (e.g., "en", "it")
const getLanguageCode = (lang) => lang.slice(0, 2).toLowerCase();

// Function to translate page content based on user language
function translatePage(language) {
  const translation = translations[language] || translations.en; // Default to English if no translation is found

  // Translate Hero Section
  const heroTexts = document.querySelectorAll(".fancy-wipe .animated-text, .fancy-wipe .wipe-in, .fancy-wipe .blur-in");
  const heroSpanTexts = document.querySelectorAll(".fancy-wipe .animated-text + span, .fancy-wipe .wipe-in + span, .fancy-wipe .blur-in + span");
  heroTexts.forEach((el) => (el.textContent = translation.greeting));
  heroSpanTexts.forEach((el) => (el.textContent = translation.welcome));

  // Translate Call to Action Button
  document.querySelector(".cta").textContent = translation.explore;

  // Translate Products Section
  document.querySelector("#products h2").textContent = translation.products;

  // Translate Product Descriptions
  const productDescriptions = document.querySelectorAll(".product p");
  if (productDescriptions.length >= 7) {
    productDescriptions[0].textContent = translation.nekobox;
    productDescriptions[1].textContent = translation.neko;
    productDescriptions[2].textContent = translation.apis;
    productDescriptions[3].textContent = translation.rps;
    productDescriptions[4].textContent = translation.clock;
    productDescriptions[5].textContent = translation.keyboard;
    productDescriptions[6].textContent = translation.fetish;
  }

  // Translate Buttons in Product Section
  const buttons = document.querySelectorAll(".product .button");
  if (buttons.length >= 9) {
    buttons[0].textContent = translation.tryItOut;
    buttons[1].textContent = translation.tryV1;
    buttons[2].textContent = translation.tryV2;
    buttons[3].textContent = translation.documentation;
    buttons[4].textContent = translation.play;
    buttons[5].textContent = translation.pinkClock;
    buttons[6].textContent = translation.blackClock;
    buttons[7].textContent = translation.play;
    buttons[8].textContent = translation.openWiki;
  }
}

// Initialize translation on page load
document.addEventListener("DOMContentLoaded", () => {
  const userLangCode = getLanguageCode(userLanguage);
  translatePage(userLangCode);
});