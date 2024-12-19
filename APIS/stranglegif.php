<?php
// Array of GIF URLs
$gifs = [
    "https://files.catbox.moe/izm8ho.gif",
    "https://files.catbox.moe/mseiap.gif",
    "https://files.catbox.moe/tapd64.gif",
    "https://files.catbox.moe/ha5z5n.gif",
    "https://files.catbox.moe/1dxnac.gif",
    "https://files.catbox.moe/11crw5.gif",
    "https://files.catbox.moe/0o44mc.gif",
    "https://files.catbox.moe/tk7e83.gif",
    "https://files.catbox.moe/svarec.gif",
    "https://files.catbox.moe/trhcgl.gif",
    "https://files.catbox.moe/kyn8tw.gif",
    "https://files.catbox.moe/qm04ae.gif",
    "https://files.catbox.moe/ohfrts.gif",
    "https://files.catbox.moe/4jke3z.gif"
];

// Select a random GIF URL
$randomGif = $gifs[array_rand($gifs)];

// Return the URL in JSON format
header('Content-Type: application/json');
echo json_encode(['gif' => $randomGif]);
?>