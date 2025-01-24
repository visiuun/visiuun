function updateFavicon() {
            // Select the favicon <link> element
            const favicon = document.querySelector("link[rel~='icon']");
            if (!favicon) return;

            const darkModeIcon = "https://visiuun.altervista.org/data/Icons/eye1.png";
            const lightModeIcon = "https://visiuun.altervista.org/data/Icons/eye1_d.png";

            // Check the system's color scheme preference
            const isDarkMode = window.matchMedia("(prefers-color-scheme: dark)").matches;

            // Set the favicon based on the current preference
            favicon.href = isDarkMode ? darkModeIcon : lightModeIcon;
        }

        // Update favicon on page load
        updateFavicon();

        // Listen for changes in color scheme preference
        window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", updateFavicon);
