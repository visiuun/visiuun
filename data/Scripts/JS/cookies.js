(function() {
  // Check if cookie consent has been given
  function checkCookieConsent() {
    return document.cookie.split(';').some((item) => item.trim().startsWith('cookieConsent='));
  }

  // Set the cookie consent
  function setCookieConsent() {
    const d = new Date();
    d.setFullYear(d.getFullYear() + 1); // Cookie expires in 1 year
    document.cookie = `cookieConsent=true; expires=${d.toUTCString()}; path=/`;
  }

  // Detect the user's preferred color scheme
  function isDarkMode() {
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
  }

  // Create and style the cookie banner dynamically
  function createCookieBanner() {
    const banner = document.createElement('div');
    banner.id = 'cookie-banner';
    banner.style.position = 'fixed';
    banner.style.bottom = '20px'; // Position at the bottom with some space
    banner.style.left = '50%'; // Center horizontally
    banner.style.transform = 'translateX(-50%)'; // Center the banner with transform
    banner.style.padding = '10px 25px'; // Less tall (padding reduced)
    banner.style.textAlign = 'center';
    banner.style.fontSize = '15px';
    banner.style.zIndex = '1000';
    banner.style.display = 'block';
    banner.style.fontWeight = 'bold'; // Make the text bold
    banner.style.borderRadius = '50px'; // Rounded "pill" shape
    banner.style.fontFamily = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif'; // Set font family
    banner.style.whiteSpace = 'normal'; // Default: prevent text wrapping

    // Apply theme-based styles
    if (isDarkMode()) {
      banner.style.backgroundColor = '#333'; // Dark grey background
      banner.style.color = 'white';
    } else {
      banner.style.backgroundColor = '#f9f9f9'; // Light grey background
      banner.style.color = '#333';
    }

    // Add message text to the banner
    const message = document.createElement('p');
    message.innerHTML = 'We use cookies to enhance your experience on our website. By continuing to browse, you consent to our use of cookies.';
    message.style.marginRight = '15px'; // Add space to the right of the text

    // "Learn More" button
    const learnMoreButton = document.createElement('button');
    learnMoreButton.id = 'learn-more';
    learnMoreButton.innerHTML = 'Learn More';
    learnMoreButton.style.border = '2px dashed white'; // Dashed border
    learnMoreButton.style.padding = '10px 20px';
    learnMoreButton.style.cursor = 'pointer';
    learnMoreButton.style.fontSize = '14px';
    learnMoreButton.style.fontWeight = 'bold'; // Make the text bold
    learnMoreButton.style.marginRight = '5px'; // Reduced space between buttons
    learnMoreButton.style.marginLeft = '20px'; // Reduced space between buttons and text
    learnMoreButton.style.borderRadius = '25px'; // Rounded button
    learnMoreButton.style.boxShadow = '0px 5px 15px rgba(0, 0, 0, 0.1)'; // Button shadow
    learnMoreButton.style.fontFamily = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif'; // Set font family for button
    learnMoreButton.style.transition = 'background-color 0.3s ease, color 0.3s ease'; // Smooth button color change

    // Apply theme-based button styles
    if (isDarkMode()) {
      learnMoreButton.style.background = 'none';
      learnMoreButton.style.color = 'white';
      learnMoreButton.style.borderColor = 'white';
    } else {
      learnMoreButton.style.background = 'none';
      learnMoreButton.style.color = '#333';
      learnMoreButton.style.borderColor = '#333';
    }

    // Learn More button hover effect
    learnMoreButton.onmouseover = function() {
      if (isDarkMode()) {
        learnMoreButton.style.backgroundColor = 'white'; // White background on hover
        learnMoreButton.style.color = '#333'; // Dark text color on hover
      } else {
        learnMoreButton.style.backgroundColor = '#333'; // Dark background on hover
        learnMoreButton.style.color = 'white'; // Light text color on hover
      }
    };
    learnMoreButton.onmouseout = function() {
      if (isDarkMode()) {
        learnMoreButton.style.background = 'none';
        learnMoreButton.style.color = 'white';
      } else {
        learnMoreButton.style.background = 'none';
        learnMoreButton.style.color = '#333';
      }
    };

    // "Got it!" button
    const button = document.createElement('button');
    button.id = 'accept-cookie';
    button.innerHTML = 'Got it!';
    button.style.border = '2px solid';
    button.style.padding = '10px 20px';
    button.style.cursor = 'pointer';
    button.style.fontSize = '14px';
    button.style.fontWeight = 'bold'; // Make the text bold
    button.style.marginLeft = '5px'; // Reduced space between buttons
    button.style.borderRadius = '25px'; // Rounded button
    button.style.boxShadow = '0px 5px 15px rgba(0, 0, 0, 0.1)'; // Button shadow
    button.style.fontFamily = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif'; // Set font family for button
    button.style.transition = 'background-color 0.3s ease, color 0.3s ease'; // Smooth button color change

    // Apply theme-based button styles
    if (isDarkMode()) {
      button.style.background = 'none';
      button.style.color = 'white';
      button.style.borderColor = 'white';
    } else {
      button.style.background = 'none';
      button.style.color = '#333';
      button.style.borderColor = '#333';
    }

    // Button hover effect
    button.onmouseover = function() {
      if (isDarkMode()) {
        button.style.backgroundColor = 'white'; // White background on hover
        button.style.color = '#333'; // Dark text color on hover
      } else {
        button.style.backgroundColor = '#333'; // Dark background on hover
        button.style.color = 'white'; // Light text color on hover
      }
    };
    button.onmouseout = function() {
      if (isDarkMode()) {
        button.style.background = 'none';
        button.style.color = 'white';
      } else {
        button.style.background = 'none';
        button.style.color = '#333';
      }
    };

    // Set the URL for the "Learn More" button
    learnMoreButton.onclick = function() {
      window.location.href = '/home/privacy';
    };

    message.appendChild(learnMoreButton);
    message.appendChild(button);
    banner.appendChild(message);
    document.body.appendChild(banner);

    // Handle button click event to accept cookies and make the banner disappear smoothly
    button.onclick = function() {
      setCookieConsent();
      banner.style.opacity = '0'; // Fade out
      setTimeout(function() {
        banner.style.display = 'none'; // Hide after transition completes
      }, 500); // Delay for transition duration (500ms)
    };
  }

  // Show the banner if consent hasn't been given
  window.onload = function() {
    if (!checkCookieConsent()) {
      createCookieBanner();
    }
  };
})();
