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
    "https://files.catbox.moe/gk0u9o.gif",
    "https://files.catbox.moe/h4dgp4.gif",
    "https://files.catbox.moe/wnd4zl.gif",
    "https://files.catbox.moe/iyf9h4.gif",
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
    "https://files.catbox.moe/aiu29i.gif",
    "https://files.catbox.moe/n28tcx.gif"
];

// Select a random GIF URL
$randomGif = $gifs[array_rand($gifs)];

// Return the URL in JSON format
header('Content-Type: application/json');
echo json_encode(['gif' => $randomGif]);
?>