<?php
// Array of GIF URLs
$gifs = [
    "https://files.catbox.moe/b583ly.gif",
    "https://files.catbox.moe/9zmkri.gif",
    "https://files.catbox.moe/tzpme4.gif",
    "https://files.catbox.moe/qeki1t.gif",
    "https://files.catbox.moe/q5ba6a.gif",
    "https://files.catbox.moe/mwpi1d.gif",
    "https://files.catbox.moe/7riqwf.gif",
    "https://files.catbox.moe/99w3ld.gif",
    "https://files.catbox.moe/672cbz.gif",
    "https://files.catbox.moe/dhzopa.gif",
    "https://files.catbox.moe/ya0gxk.gif",
    "https://files.catbox.moe/gk0u9o.gif",
    "https://files.catbox.moe/h4dgp4.gif",
    "https://files.catbox.moe/wnd4zl.gif",
    "https://files.catbox.moe/at00u4.gif",
    "https://files.catbox.moe/iyf9h4.gif",
    "https://files.catbox.moe/fpvarl.gif",
    "https://files.catbox.moe/vqdju3.gif",
    "https://files.catbox.moe/nv243o.gif",
    "https://files.catbox.moe/0bm15x.gif",
    "https://files.catbox.moe/jhiovt.gif",
    "https://files.catbox.moe/q0ahsx.gif",
    "https://files.catbox.moe/3jo7oo.gif",
	"https://files.catbox.moe/h0x9cu.gif",
	"https://files.catbox.moe/s1dont.gif",
	"https://files.catbox.moe/p2hhkq.gif",
	"https://files.catbox.moe/t2nobx.webp",
    "https://files.catbox.moe/fgmvx7.gif",
	"https://files.catbox.moe/namrf2.gif",
    "https://files.catbox.moe/2k41wr.gif",
    "https://files.catbox.moe/9adult.gif",
    "https://files.catbox.moe/1ba387.gif",
    "https://files.catbox.moe/aiu29i.gif",
    "https://files.catbox.moe/n28tcx.gif"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSFW Vore GIF Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .gif-container {
            margin: 10px;
            text-align: center;
        }
        img {
            max-width: 200px;
            border: 2px solid #ccc;
            border-radius: 8px;
            transition: transform 0.3s;
        }
        img:hover {
            transform: scale(1.05);
        }
        a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            display: block;
            margin-top: 5px;
        }
        .load-time {
            color: #555;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <?php foreach ($gifs as $gif): ?>
        <div class="gif-container">
            <a href="<?php echo $gif; ?>" target="_blank">
                <img src="" alt="GIF Preview" data-url="<?php echo $gif; ?>">
            </a>
            <a href="<?php echo $gif; ?>" target="_blank"><?php echo $gif; ?></a>
            <div class="load-time">Server Load Time: Loading...</div>
            <div class="load-time">Client Load Time: Loading...</div>
        </div>
    <?php endforeach; ?>

    <script>
        // Select all images
const images = document.querySelectorAll('img');

images.forEach(img => {
    const serverLoadTimeElement = img.parentElement.nextElementSibling.nextElementSibling; // Server load time element
    const clientLoadTimeElement = serverLoadTimeElement.nextElementSibling; // Client load time element
    const url = img.getAttribute('data-url'); // Get the URL of the image
    const maxRetries = 3; // Set the max retries
    let attempts = 0; // Initialize retry count

    // Start server performance measurement
    const serverStart = performance.now();

    // Function to load the image and handle retries
    function loadImage() {
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to fetch");
                }

                const serverLoadTime = (performance.now() - serverStart).toFixed(2); // Calculate server load time
                serverLoadTimeElement.textContent = `Server Load Time: ${serverLoadTime} ms`; // Update server load time
                img.src = url; // Set the image src to load it

                // Start client performance measurement
                const clientStart = performance.now();

                // When the image loads, calculate and display client load time
                img.onload = () => {
                    const clientLoadTime = (performance.now() - clientStart).toFixed(2); // Calculate client load time
                    clientLoadTimeElement.textContent = `Client Load Time: ${clientLoadTime} ms`; // Update client load time
                };

                // Error handling for image load failure
                img.onerror = () => {
                    if (attempts < maxRetries) {
                        attempts++;
                        clientLoadTimeElement.textContent = `Retrying... Attempt ${attempts}`;
                        loadImage(); // Retry fetching the image
                    } else {
                        clientLoadTimeElement.textContent = "Failed to load after retries";
                    }
                };
            })
            .catch(() => {
                if (attempts < maxRetries) {
                    attempts++;
                    serverLoadTimeElement.textContent = `Retrying... Attempt ${attempts}`;
                    loadImage(); // Retry fetching the image
                } else {
                    serverLoadTimeElement.textContent = "Failed to fetch after retries";
                }
            });
    }

    // Initial call to load the image
    loadImage();
});
    </script>

</body>
</html>