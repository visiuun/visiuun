<?php
// Array of GIF URLs
$gifs = [
    "https://files.catbox.moe/9pwnou.gif",
    "https://files.catbox.moe/5uzpkl.gif",
    "https://files.catbox.moe/40bpw7.gif",
    "https://files.catbox.moe/t4qx30.gif",
    "https://files.catbox.moe/tg890q.gif",
    "https://files.catbox.moe/6lyhxt.gif",
    "https://files.catbox.moe/25tfq9.gif",
    "https://files.catbox.moe/lo4nb1.gif",
    "https://files.catbox.moe/15e8ib.gif",
    "https://files.catbox.moe/pgzsci.gif",
    "https://files.catbox.moe/x1hmvn.gif",
    "https://files.catbox.moe/x12ebw.gif",
    "https://files.catbox.moe/hgidjl.gif",
    "https://files.catbox.moe/ko68lp.gif",
    "https://files.catbox.moe/aly0sk.gif",
    "https://files.catbox.moe/ae50e8.gif",
    "https://files.catbox.moe/l6bzaa.gif",
    "https://files.catbox.moe/e6a8dk.gif",
    "https://files.catbox.moe/pej9i1.gif",
    "https://files.catbox.moe/a2our8.gif",
    "https://files.catbox.moe/l4ddpy.gif",
    "https://files.catbox.moe/e0dzj0.gif",
    "https://files.catbox.moe/s5avgp.gif",
    "https://files.catbox.moe/go9qoi.gif",
    "https://files.catbox.moe/rf1dew.gif",
    "https://files.catbox.moe/6aa4s6.gif",
    "https://files.catbox.moe/jdhxo7.gif",
    "https://files.catbox.moe/mxqgti.gif",
    "https://files.catbox.moe/626r48.gif",
    "https://files.catbox.moe/2jw3wi.gif",
    "https://files.catbox.moe/47coqg.gif",
	"https://files.catbox.moe/3s0oq4.gif",
	"https://files.catbox.moe/vfp1fx.gif",
	"https://files.catbox.moe/idk3sn.gif",
	"https://files.catbox.moe/6jmb7r.gif",
	"https://files.catbox.moe/u0l9gf.gif",
	"https://files.catbox.moe/211cl3.gif",
	"https://files.catbox.moe/8ch49h.gif",
	"https://files.catbox.moe/4amb1h.gif",
	"https://files.catbox.moe/myl934.gif",
	"https://files.catbox.moe/fl9k4y.gif",
	"https://files.catbox.moe/8wxpym.gif",
	"https://files.catbox.moe/ul1dru.gif",
	"https://files.catbox.moe/g00run.gif",
	"https://files.catbox.moe/ts3yp0.gif",
	"https://files.catbox.moe/3ojd68.gif",
	"https://files.catbox.moe/jsemzt.gif",
	"https://files.catbox.moe/vhf9xd.webp",
	"https://files.catbox.moe/smo86w.gif",
	"https://files.catbox.moe/e4q64p.gif",
    "https://files.catbox.moe/lchhhv.gif",
    "https://files.catbox.moe/mmqip7.gif",
    "https://files.catbox.moe/tq8y6j.gif",
    "https://files.catbox.moe/211cl3.gif",
    "https://files.catbox.moe/rc0jof.gif",
    "https://files.catbox.moe/ppixto.gif",
    "https://files.catbox.moe/o674z3.gif",
    "https://files.catbox.moe/mh6mex.gif",
    "https://files.catbox.moe/mbdouz.gif",
    "https://files.catbox.moe/r8uvd5.gif",
    "https://files.catbox.moe/52mtcr.gif",
    "https://files.catbox.moe/hj407v.gif",
    "https://files.catbox.moe/l3gka0.gif",
    "https://files.catbox.moe/ctou70.gif",
    "https://files.catbox.moe/uwvbtr.gif",
	"https://files.catbox.moe/wu1cuu.gif",
	"https://files.catbox.moe/e8s5i3.gif",
	"https://files.catbox.moe/aqtk2x.gif",
	"https://files.catbox.moe/mj62m6.gif",
	"https://files.catbox.moe/iazzai.gif",
	"https://files.catbox.moe/o5xows.gif",
	"https://files.catbox.moe/wuwi16.gif",
	"https://files.catbox.moe/1mfwfm.gif",
    "https://files.catbox.moe/1cu5s1.gif",
    "https://files.catbox.moe/nur38y.gif",
    "https://files.catbox.moe/e6ijgz.gif",
    "https://files.catbox.moe/7l2q0a.gif",
    "https://files.catbox.moe/2n24ov.gif",
    "https://files.catbox.moe/5vsc93.gif",
    "https://files.catbox.moe/e71oxg.gif"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSFW Stomp GIF Gallery</title>
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