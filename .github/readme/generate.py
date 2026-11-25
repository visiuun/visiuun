"""Renders the Material 3 Expressive cards used by the profile readme.

Every card is a self-contained SVG in assets/readme/: Google Sans Flex is
subset and embedded per file, app icons are inlined, and the colours switch
between a light and a dark M3 scheme with prefers-color-scheme.

Live numbers (stars, repo count, languages, "new" badges) come from the GitHub
API, so the GitHub Action in .github/workflows/readme.yml re-runs this daily.
To feature a different project, edit the lists below and add its card to
readme.md.

    pip install fonttools brotli pillow
    python .github/readme/generate.py [--cache DIR]
"""

from __future__ import annotations

import base64
import datetime as dt
import io
import json
import math
import os
import sys
import urllib.request
from functools import lru_cache
from pathlib import Path

from fontTools import subset
from fontTools.ttLib import TTFont
from fontTools.varLib import instancer
from PIL import Image

USER = "visiuun"
HERE = Path(__file__).resolve().parent
ROOT = HERE.parent.parent
OUT = ROOT / "assets" / "readme"
FONT_FILE = HERE / "GoogleSansFlex.woff2"

# --------------------------------------------------------------------------
# Content
# --------------------------------------------------------------------------

# Values taken from visiuun.com, which GitHub can't count.
SINCE = "2016"
REACH = "12M+"

ANDROID = [
    dict(repo="expressive-weather", name="Expressive Weather", icon="docs/icon.svg",
         platform="Android 7.0+",
         desc="Private weather with a live sky, rain radar and twelve home screen widgets. No ads, no tracking, no Google services."),
    dict(repo="expressive-keyboard", name="Expressive Keyboard", icon="docs/icon.png",
         platform="Android 8.0+",
         desc="A fully local keyboard that isn't ugly: glide typing, multilingual autocorrect, on-device AI and offline voice typing."),
    dict(repo="ark-browser", name="Ark", icon="docs/icon.svg",
         platform="Android 8.0+",
         desc="A fast, private browser with Arc's mobile layout on Firefox's GeckoView engine. Ad blocker built in, no account needed."),
    dict(repo="expressive-booru", name="Expressive Booru", icon="docs/icon.png",
         platform="Android 8.0+",
         desc="A fast, private booru client for Danbooru, Gelbooru, e621, yande.re and more, with favourites and a smooth viewer."),
    dict(repo="inkwell", name="Inkwell", icon="docs/icon.svg",
         platform="Android 7.0+ · NFC",
         desc="Put any picture on your NFC e-ink phone case, with a live four-ink preview and dithering. No account, no tracking."),
    dict(repo="fsb-android", name="FSB for Android", icon="docs/icon.png",
         platform="Android 8.0+",
         desc="Check any X (Twitter) account for search bans, ghost bans and reply deboosts. The app for FSB Sentinel."),
]

WINDOWS = [
    dict(repo="equinox", name="equinox", icon="docs/icon.png",
         platform="Windows 10 · 11",
         desc="System-wide equalizer: per-device sound, AutoEq headphone correction, mic EQ, automation and a CLI."),
    dict(repo="lumen", name="lumen", icon="docs/icon.png",
         platform="Windows 10 · 11",
         desc="Monitor calibration that changes real hardware settings (DDC/CI, GPU LUT, vibrance) and keeps them applied."),
    dict(repo="hush", name="Hush", icon="docs/logo.png",
         platform="Windows 10 · 11",
         desc="Quiet, smart fan control with curves, profiles, automation, a CLI and a JSON pipe. No bloat."),
    dict(repo="copyconfirm", name="CopyConfirm", icon="docs/icon.png",
         platform="Windows 11",
         desc="A small pill on screen every time you copy something, plus a searchable clipboard history. Under 1 MB."),
    dict(repo="vdisplay", name="Vdisplay", icon="docs/logo.png",
         platform="Windows 10 · 11",
         desc="Drives the MARS GAMING case screen: now playing, word-synced lyrics, a system monitor and GIFs."),
    dict(repo="VMacropad", name="VMacropad", icon="vmacropad.ico",
         platform="Windows · Python",
         desc="Open-source driver for generic 3-key and knob macropads, with per-app profiles and per-app volume."),
]

CREATIVE = [
    dict(repo="deexif", name="DEEXIF", icon="docs/icon.png",
         platform="Windows · Android",
         desc="See everything a photo gives away (GPS, serials, AI prompts, hidden payloads) and strip it losslessly."),
    dict(repo="kiln", name="kiln", icon="docs/icon.png",
         platform="Windows 10 · 11",
         desc="A folder of an artist's images in, an Illustrious style LoRA out. Cleaning, tagging and training in one app."),
    dict(repo="prism", name="Prism", icon="prism.png",
         platform="Windows · macOS · Linux",
         desc="Bulk image and video compressor that uses your GPU and checks its own work: AV1, HEVC, JPEG XL, verified outputs."),
    dict(repo="vtagger", name="Vtagger", icon=None, glyph="V",
         platform="Windows · Python",
         desc="A local, GPU-accelerated AI artist tagger that learns your library, with autocomplete and per-artist search."),
]

MODS = [
    dict(repo="tidaluna-plugins", name="Luna plugins", glyph="L",
         desc="Plugins for TidaLuna, the TIDAL client mod."),
    dict(repo="TidaLuna-Installer", name="TidaLuna Installer", glyph="T",
         desc="Auto-updating installer with one-click uninstall."),
    dict(repo="discord-plugins", name="Discord plugins", glyph="D",
         desc="Userplugins for Equicord and Testcord."),
]

# Favicons live in web-icons/<slug>.png. icon: "glyph" recolours a white
# favicon to the theme (other colours kept), "clip" fills the shape with it,
# "plain" shows it as is (it already has its own badge shape).
WEB = [
    dict(slug="hana", icon="clip", name="Hana", url="hanabot.xyz", glyph="H",
         desc="Discord bot with AI chat, moderation and a virtual stock market."),
    dict(slug="fsb", icon="plain", name="FSB", url="visiuun.com/fsb", glyph="F",
         desc="X (Twitter) shadowban and reach tester."),
    dict(slug="linky", icon="glyph", name="Linky", url="linky.moe", glyph="L",
         desc="Minimal link-in-bio pages with animated styling."),
    dict(slug="boopme", icon="glyph", name="BoopMe", url="visiuun.com/boopme", glyph="B",
         desc="A tiny social network of daily streaks and boops."),
    dict(slug="trakka", icon="glyph", name="Trakka", url="visiuun.com/trakka", glyph="T",
         desc="A multitrack audio workstation in your browser."),
    dict(slug="diff", icon="glyph", name="Diff", url="visiuun.com/diff", glyph="D",
         desc="AI-assisted diff and code merge workbench."),
    dict(slug="speed", icon="glyph", name="Speed", url="speed.visiuun.com", glyph="S",
         desc="An ad-free speed test: download, upload, ping, jitter."),
    dict(slug="meru", icon="plain", name="Meru", url="visiuun.com/meru", glyph="M",
         desc="A streaming app and animated episode player."),
]

BUTTONS = [
    dict(slug="website", label="visiuun.com", icon="globe", style="filled"),
    dict(slug="discord", label="Discord", icon="chat", style="tonal"),
    dict(slug="instagram", label="Instagram", icon="camera", style="tonal"),
    dict(slug="email", label="Email", icon="mail", style="tonal"),
]

# --------------------------------------------------------------------------
# Colour: an M3 scheme from the pink seed #F9A8D4, pushed a little more
# vivid the way Expressive themes are.
# --------------------------------------------------------------------------

LIGHT = dict(
    s1="#FFF0F5", s2="#FAE9F0", s3="#F4E1E9", s4="#EEDAE3",
    on="#24191E", onv="#5C4D54", outv="#DCC6CF",
    p="#A0306B", onp="#FFFFFF", pc="#FFD8E9", onpc="#5C1139",
    s="#755764", sc="#F8D9E7", onsc="#2E1520",
    t="#7A4D9C", tc="#F0DBFF", ontc="#3A1656",
    x="#9A4524", xc="#FFDBCF", onxc="#3A0B00",
    head="#A0306B", sub="#6E5F66",
    hs="#FFB0D6",  # primary fixed dim: the hero cookie, which needs more weight on light
)
DARK = dict(
    s1="#1B1317", s2="#21181C", s3="#2B2126", s4="#362B30",
    on="#F2DEE6", onv="#D2BFC7", outv="#4E4046",
    p="#FFAFD5", onp="#5E1139", pc="#7E2A55", onpc="#FFD8E9",
    s="#E0BDCC", sc="#57404B", onsc="#FCD9E8",
    t="#E2B8FF", tc="#5E3480", ontc="#F1DBFF",
    x="#FFB59A", xc="#76321A", onxc="#FFDBCF",
    head="#FFAFD5", sub="#B8A6AE",
    hs="#7E2A55",
)

ACCENTS = ["p", "t", "x", "s"]

LANG_COLORS = {
    "Kotlin": "#A97BFF", "Rust": "#DEA584", "Python": "#3572A5",
    "TypeScript": "#3178C6", "JavaScript": "#F1E05A", "C": "#555555",
}

# --------------------------------------------------------------------------
# GitHub data
# --------------------------------------------------------------------------

CACHE: Path | None = None


def fetch(url: str, raw: bool = False) -> bytes:
    if CACHE:
        key = CACHE / (base64.urlsafe_b64encode(url.encode()).decode()[:180])
        if key.exists():
            return key.read_bytes()
    headers = {"User-Agent": "profile-readme-cards"}
    token = os.environ.get("GITHUB_TOKEN")
    if token and "api.github.com" in url:
        headers["Authorization"] = f"Bearer {token}"
    with urllib.request.urlopen(urllib.request.Request(url, headers=headers), timeout=30) as r:
        data = r.read()
    if CACHE:
        key.write_bytes(data)
    return data


def api(path: str):
    return json.loads(fetch(f"https://api.github.com/{path}"))


# --------------------------------------------------------------------------
# Font: measuring text and embedding a per-file subset
# --------------------------------------------------------------------------

def _pinned_font() -> bytes:
    """Google Sans Flex with only the weight axis left variable: fully rounded
    (ROND 100) like M3 Expressive headlines, and small enough to embed."""
    f = instancer.instantiateVariableFont(
        TTFont(FONT_FILE), {"wdth": 100, "opsz": 24, "ROND": 100, "wght": (300, 1000)})
    buf = io.BytesIO()
    f.flavor = None
    f.recalcTimestamp = False
    f["head"].modified = f["head"].created  # keep output byte-identical between runs
    f.save(buf)
    return buf.getvalue()


BASE_FONT = _pinned_font()


@lru_cache(maxsize=None)
def instance(wght: int):
    f = instancer.instantiateVariableFont(TTFont(io.BytesIO(BASE_FONT)), {"wght": wght})
    return f.getBestCmap(), f["hmtx"].metrics, f["head"].unitsPerEm


def measure(text: str, size: float, wght=400, ls=0.0) -> float:
    cmap, hmtx, upm = instance(wght)
    w = 0
    for ch in text:
        g = cmap.get(ord(ch))
        w += hmtx[g][0] if g else upm * 0.55
    return w * size / upm + ls * len(text)


def wrap(text: str, size: float, width: float, **kw) -> list[str]:
    lines, cur = [], ""
    for word in text.split():
        trial = f"{cur} {word}".strip()
        if cur and measure(trial, size, **kw) > width:
            lines.append(cur)
            cur = word
        else:
            cur = trial
    if cur:
        lines.append(cur)
    return lines


def font_face(chars: set[str]) -> str:
    font = TTFont(io.BytesIO(BASE_FONT), recalcTimestamp=False)
    opts = subset.Options()
    opts.flavor = "woff"
    opts.layout_features = ["kern", "liga", "calt"]
    opts.hinting = False
    opts.name_IDs = []
    opts.notdef_outline = True
    s = subset.Subsetter(opts)
    s.populate(text="".join(sorted(chars | {" "})))
    s.subset(font)
    buf = io.BytesIO()
    font.recalcTimestamp = False
    font.flavor = "woff"
    font.save(buf)
    b64 = base64.b64encode(buf.getvalue()).decode()
    return ("@font-face{font-family:GSF;font-weight:300 1000;"
            f"src:url(data:font/woff;base64,{b64}) format('woff')}}")


# --------------------------------------------------------------------------
# M3 tokens (from androidx.compose.material3 tokens), in dp/sp.
# Cards are drawn at DP units per dp so they land close to 1:1 on GitHub.
# --------------------------------------------------------------------------

DP = 1.3

# Corner radius scale (ShapeTokens)
CORNER = dict(xs=4, sm=8, md=12, lg=16, lg_inc=20, xl=28, xl_inc=32, xxl=48)

# Type scale (TypeScaleTokens). Emphasized styles keep size and line height and
# step the weight up: Regular -> Medium, Medium -> Bold.
TYPE = dict(
    display_l=(57, 64, -0.25, 400), display_m=(45, 52, 0, 400),
    headline_l=(32, 40, 0, 400), headline_m=(28, 36, 0, 400), headline_s=(24, 32, 0, 400),
    title_l=(22, 28, 0, 400), title_m=(16, 24, 0.15, 500),
    body_l=(16, 24, 0.5, 400), body_m=(14, 20, 0.25, 400),
    label_l=(14, 20, 0.1, 500), label_m=(12, 16, 0.5, 500),
)
EMPHASIS = {400: 500, 500: 700}


def ts(style: str, emphasized=False, scale=DP):
    """Returns (size, line height, tracking, weight) in SVG units."""
    size, lh, track, wght = TYPE[style]
    if emphasized:
        wght = EMPHASIS[wght]
    return size * scale, lh * scale, track * scale, wght


# --------------------------------------------------------------------------
# The M3 Expressive shape library: a port of androidx MaterialShapes, rendered
# the way RoundedPolygon rounds its corners (circular fillets, cuts shared
# between neighbouring corners when an edge is too short).
# --------------------------------------------------------------------------

def _star(n, inner, r, rot=0.0):
    pts = []
    for i in range(n):
        a = 2 * math.pi * i / n
        b = math.pi * (2 * i + 1) / n
        pts += [((math.cos(a), math.sin(a)), r), ((inner * math.cos(b), inner * math.sin(b)), r)]
    return _rotate(pts, rot)


def _rotate(pts, deg, c=(0.0, 0.0)):
    a = math.radians(deg)
    out = []
    for (x, y), r in pts:
        dx, dy = x - c[0], y - c[1]
        out.append(((dx * math.cos(a) - dy * math.sin(a) + c[0],
                     dx * math.sin(a) + dy * math.cos(a) + c[1]), r))
    return out


def _custom(points, reps, mirroring=False, center=(0.5, 0.5)):
    cx, cy = center
    if not mirroring:
        out = []
        for k in range(len(points) * reps):
            (x, y), r = points[k % len(points)]
            out += _rotate([((x, y), r)], (k // len(points)) * 360 / reps, center)
        return out
    angles = [math.degrees(math.atan2(y - cy, x - cx)) for (x, y), _ in points]
    dists = [math.hypot(x - cx, y - cy) for (x, y), _ in points]
    actual = reps * 2
    section = 360 / actual
    out = []
    for it in range(actual):
        for index in range(len(points)):
            i = index if it % 2 == 0 else len(points) - 1 - index
            if i > 0 or it % 2 == 0:
                a = math.radians(section * it + (angles[i] if it % 2 == 0
                                                 else section - angles[i] + 2 * angles[0]))
                out.append(((math.cos(a) * dists[i] + cx, math.sin(a) * dists[i] + cy), points[i][1]))
    return out


def _regular(n, rounds, rot=0.0):
    return _rotate([((math.cos(2 * math.pi * i / n), math.sin(2 * math.pi * i / n)), rounds[i])
                    for i in range(n)], rot)


def _scale_y(pts, k):
    return [((x, y * k), r) for (x, y), r in pts]


P = lambda x, y, r=0.0: ((x, y), r)  # noqa: E731

SHAPES = {
    "cookie4": lambda: _custom([P(1.237, 1.236, .258), P(.5, .918, .233)], 4),
    "cookie6": lambda: _custom([P(.723, .884, .394), P(.5, 1.099, .398)], 6),
    "cookie7": lambda: _star(7, .75, .5, -90),
    "cookie9": lambda: _star(9, .8, .5, -90),
    "cookie12": lambda: _star(12, .8, .5, -90),
    "sunny": lambda: _star(8, .8, .15),
    "very_sunny": lambda: _custom([P(.5, 1.08, .085), P(.358, .843, .085)], 8),
    "clover4": lambda: _custom([P(.5, .074), P(.725, -.099, .476)], 4, mirroring=True),
    "clover8": lambda: _custom([P(.5, .036), P(.758, -.101, .209)], 8),
    "soft_burst": lambda: _custom([P(.193, .277, .053), P(.176, .055, .053)], 10),
    "flower": lambda: _custom([P(.37, .187), P(.416, .049, .381), P(.479, .001, .095)], 8, mirroring=True),
    "puffy_diamond": lambda: _custom([P(.87, .13, .146), P(.818, .357), P(1, .332, .853)], 4, mirroring=True),
    "pill": lambda: _custom([P(.961, .039, .426), P(1.001, .428), P(1, .609, 1)], 2, mirroring=True),
    "gem": lambda: _custom([P(.499, 1.023, .241), P(-.005, .792, .208), P(.073, .258, .228),
                            P(.433, 0, .491)], 1, mirroring=True),
    "pentagon": lambda: _custom([P(.5, -.009, .172), P(1.03, .365, .164), P(.828, .97, .169)], 1,
                                mirroring=True),
    "arch": lambda: _regular(4, [1, 1, .2, .2], -135),
    "bun": lambda: _custom([P(.796, .5), P(.853, .518, 1), P(.992, .631, 1), P(.968, 1, 1)], 2,
                           mirroring=True),
    "heart": lambda: _custom([P(.5, .268, .016), P(.792, -.066, .958), P(1.064, .276, 1),
                              P(.501, .946, .129)], 1, mirroring=True),
    "ghostish": lambda: _custom([P(.5, 0, 1), P(1, 0, 1), P(1, 1.14, .254), P(.575, .906, .253)], 1,
                                mirroring=True),
    "puffy": lambda: _scale_y(_custom(
        [P(.5, .053), P(.545, -.04, .405), P(.67, -.035, .426), P(.717, .066, .574), P(.722, .128),
         P(.777, .002, .36), P(.914, .149, .66), P(.926, .289, .66), P(.881, .346), P(.94, .344, .126),
         P(1.003, .437, .255)], 2, mirroring=True), .742),
}


def _rounded_outline(pts):
    """Fillets every corner like RoundedPolygon. Returns segments in polygon
    space: a start point and a list of ("L", p) / ("A", r, sweep, p)."""
    n = len(pts)
    V = [p for p, _ in pts]
    corners = []
    for i in range(n):
        p, v, q = V[i - 1], V[i], V[(i + 1) % n]
        d1 = (p[0] - v[0], p[1] - v[1])
        d2 = (q[0] - v[0], q[1] - v[1])
        l1, l2 = math.hypot(*d1), math.hypot(*d2)
        d1 = (d1[0] / l1, d1[1] / l1)
        d2 = (d2[0] / l2, d2[1] / l2)
        cos = d1[0] * d2[0] + d1[1] * d2[1]
        sin = abs(d1[0] * d2[1] - d1[1] * d2[0])
        cut = pts[i][1] * (cos + 1) / sin if sin > 1e-3 else 0.0
        turn = (v[0] - p[0]) * (q[1] - v[1]) - (v[1] - p[1]) * (q[0] - v[0])
        corners.append(dict(d1=d1, d2=d2, cos=cos, sin=sin, cut=cut, sweep=1 if turn > 0 else 0))
    ratio = []
    for i in range(n):
        side = math.dist(V[i], V[(i + 1) % n])
        want = corners[i]["cut"] + corners[(i + 1) % n]["cut"]
        ratio.append(side / want if want > side else 1.0)
    segs, start = [], None
    for i in range(n):
        c, v = corners[i], V[i]
        cut = c["cut"] * min(ratio[i - 1], ratio[i])
        t1 = (v[0] + c["d1"][0] * cut, v[1] + c["d1"][1] * cut)
        t2 = (v[0] + c["d2"][0] * cut, v[1] + c["d2"][1] * cut)
        radius = cut * c["sin"] / (c["cos"] + 1) if cut > 1e-6 else 0
        if start is None:
            start = t1
        else:
            segs.append(("L", t1))
        if radius > 1e-6:
            u = (c["d1"][0] + c["d2"][0], c["d1"][1] + c["d2"][1])
            ul = math.hypot(*u) or 1.0
            u = (u[0] / ul, u[1] / ul)
            half_sin = math.sqrt(max(1e-9, (1 - c["cos"]) / 2))
            centre = (v[0] + u[0] * radius / half_sin, v[1] + u[1] * radius / half_sin)
            mid = (centre[0] - u[0] * radius, centre[1] - u[1] * radius)
            segs.append(("A", radius, c["sweep"], t2, mid))
    segs.append(("L", start))
    return start, segs


@lru_cache(maxsize=None)
def _normalized(kind: str):
    """Outline fitted into the unit square centred on (0.5, 0.5)."""
    start, segs = _rounded_outline(SHAPES[kind]())
    xs, ys = [start[0]], [start[1]]
    for s in segs:
        for pt in ([s[1]] if s[0] == "L" else [s[3], s[4]]):  # arc ends and arc midpoints
            xs.append(pt[0])
            ys.append(pt[1])
    x0, x1, y0, y1 = min(xs), max(xs), min(ys), max(ys)
    span = max(x1 - x0, y1 - y0)
    ox, oy = (x0 + x1) / 2, (y0 + y1) / 2
    f = lambda p: ((p[0] - ox) / span + .5, (p[1] - oy) / span + .5)  # noqa: E731
    return f(start), [(s[0], s[1] / span, s[2], f(s[3])) if s[0] == "A" else ("L", f(s[1]))
                      for s in segs]


def shape_path(kind, cx, cy, r, rot=0.0) -> str:
    """Path for a MaterialShape filling a 2r square centred on (cx, cy)."""
    start, segs = _normalized(kind)
    a = math.radians(rot)
    ca, sa = math.cos(a), math.sin(a)

    def t(p):
        x, y = (p[0] - .5) * 2 * r, (p[1] - .5) * 2 * r
        return cx + x * ca - y * sa, cy + x * sa + y * ca

    f = lambda v: f"{v:.1f}".rstrip("0").rstrip(".")  # noqa: E731
    sx, sy = t(start)
    d = [f"M{f(sx)} {f(sy)}"]
    for s in segs:
        if s[0] == "L":
            x, y = t(s[1])
            d.append(f"L{f(x)} {f(y)}")
        else:
            x, y = t(s[3])
            rr = s[1] * 2 * r
            d.append(f"A{f(rr)} {f(rr)} 0 0 {s[2]} {f(x)} {f(y)}")
    return "".join(d) + "Z"


def shape(kind, cx, cy, r, color, rot=0.0, cls="", css="", extra=""):
    c = f' class="{cls}"' if cls else ""
    css = f";{css}" if css else ""
    if kind == "circle":
        return f'<circle{c} cx="{cx:.1f}" cy="{cy:.1f}" r="{r:.1f}" style="fill:var(--{color}){css}"{extra}/>'
    return f'<path{c} d="{shape_path(kind, cx, cy, r, rot)}" style="fill:var(--{color}){css}"{extra}/>'


# Line icons on a 24 unit grid (Material Symbols style: 2 unit strokes, round joins).
GLYPHS = {
    "globe": '<circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18"/>',
    "chat": '<path d="M5 4h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-7l-5 4v-4H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>',
    "camera": '<rect x="3" y="3" width="18" height="18" rx="5.5"/><circle cx="12" cy="12" r="4"/>'
              '<circle cx="17.2" cy="6.8" r=".6"/>',
    "mail": '<rect x="3" y="5" width="18" height="14" rx="3"/><path d="M4 7l8 6 8-6"/>',
    "phone": '<rect x="6" y="2.5" width="12" height="19" rx="3.5"/><path d="M10.5 18.5h3"/>',
    "window": '<rect x="3" y="3" width="8" height="8" rx="2"/><rect x="13" y="3" width="8" height="8" rx="2"/>'
              '<rect x="3" y="13" width="8" height="8" rx="2"/><rect x="13" y="13" width="8" height="8" rx="2"/>',
    "spark": '<path d="M12 3c.6 4.6 3.4 7.4 9 9-5.6 1.6-8.4 4.4-9 9-.6-4.6-3.4-7.4-9-9 5.6-1.6 8.4-4.4 9-9z"/>',
    "code": '<path d="M8.5 7 3.5 12l5 5M15.5 7l5 5-5 5M13.5 4.5l-3 15"/>',
    "star": '<path d="M12 3.5l2.6 5.3 5.8.8-4.2 4.1 1 5.8-5.2-2.7-5.2 2.7 1-5.8-4.2-4.1 5.8-.8z"/>',
    "folder": '<path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
    "people": '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 19.5c.8-3.6 3.4-5.5 6.5-5.5s5.7 1.9 6.5 5.5"/>'
              '<path d="M15.5 4.8a3.5 3.5 0 0 1 0 6.4M18 14.4c1.8.8 3 2.5 3.5 5.1"/>',
    "cake": '<path d="M4 20h16v-6.5a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2z"/><path d="M4 15.5c2.7 1.6 5.3 1.6 8 0 '
            '2.7 1.6 5.3 1.6 8 0M12 11.5v-3"/><path d="M12 3.5c1 1.2 1 2.4 0 3-1-.6-1-1.8 0-3z"/>',
}


def glyph(name, x, y, size, color, stroke=2.0, fill=False):
    k = size / 24
    paint = (f"fill:var(--{color});stroke:var(--{color});stroke-width:{stroke}" if fill
             else f"fill:none;stroke:var(--{color});stroke-width:{stroke}")
    return (f'<g transform="translate({x:.1f} {y:.1f}) scale({k:.4f})" '
            f'style="{paint};stroke-linecap:round;stroke-linejoin:round">{GLYPHS[name]}</g>')


# --------------------------------------------------------------------------
# SVG canvas
# --------------------------------------------------------------------------

def esc(s: str) -> str:
    return s.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;")


def scheme_css(pal: dict) -> str:
    return ";".join(f"--{k}:{v}" for k, v in pal.items())


class Canvas:
    def __init__(self, w, h, title):
        self.w, self.h, self.title = w, h, title
        self.parts: list[str] = []
        self.chars: set[str] = set()
        self.ids = 0

    def uid(self, prefix="i"):
        self.ids += 1
        return f"{prefix}{self.ids}"

    def add(self, s: str):
        self.parts.append(s)

    def text(self, x, y, s, size, color="on", wght=400, anchor="start", ls=0.0, extra=""):
        self.chars |= set(s)
        style = (f"font-size:{size:.1f}px;font-weight:{wght};fill:var(--{color});"
                 f"font-variation-settings:'wght' {wght}")
        if ls:
            style += f";letter-spacing:{ls:.2f}px"
        a = f' text-anchor="{anchor}"' if anchor != "start" else ""
        self.add(f'<text x="{x:.1f}" y="{y:.1f}"{a} style="{style}"{extra}>{esc(s)}</text>')

    def styled(self, x, y, s, style, color="on", emphasized=False, scale=DP, anchor="start", extra=""):
        size, _, track, wght = ts(style, emphasized, scale)
        self.text(x, y, s, size, color, wght, anchor, track, extra)
        return measure(s, size, wght, track)

    def render(self) -> str:
        css = (font_face(self.chars) if self.chars else "") + (
            f"svg{{{scheme_css(LIGHT)}}}"
            f"@media (prefers-color-scheme:dark){{svg{{{scheme_css(DARK)}}}}}"
            "text{font-family:GSF,'Google Sans Flex','Google Sans',Roboto,'Segoe UI',system-ui,sans-serif}"
            # Slow, continuous motion only; nothing moves for people who ask for less.
            ".spin{transform-box:fill-box;transform-origin:center;animation:spin 60s linear infinite}"
            ".spin.rev{animation-direction:reverse;animation-duration:40s}"
            ".bob{transform-box:fill-box;transform-origin:center;"
            "animation:bob 7s cubic-bezier(.42,1.67,.21,.9) infinite alternate}"
            "@keyframes spin{to{transform:rotate(360deg)}}"
            "@keyframes bob{to{transform:translateY(-6px) rotate(10deg)}}"
            "@media (prefers-reduced-motion:reduce){.spin,.bob{animation:none}}"
        )
        return (f'<svg xmlns="http://www.w3.org/2000/svg" width="{self.w}" height="{self.h}" '
                f'viewBox="0 0 {self.w} {self.h}" role="img" aria-label="{esc(self.title)}">'
                f"<title>{esc(self.title)}</title><style>{css}</style>"
                + "".join(self.parts) + "</svg>\n")


def save(name: str, canvas: Canvas):
    OUT.mkdir(parents=True, exist_ok=True)
    (OUT / f"{name}.svg").write_text(canvas.render(), encoding="utf-8", newline="\n")
    print(f"  {name}.svg")


# --------------------------------------------------------------------------
# Components
# --------------------------------------------------------------------------

def assist_chip(c: Canvas, x, y, label, anchor="start", icon=None, dot=None, shape_icon=None,
                fill=None, fg="on", icon_color="p", scale=DP):
    """M3 assist chip: 32dp tall, small (8dp) corners, 1dp outline-variant
    outline when flat, 18dp leading icon, label large. Returns its width."""
    h = 32 * scale
    size, _, track, wght = ts("label_l", scale=scale)
    lead = 8 * scale if (icon or dot or shape_icon) else 16 * scale
    icon_w = (18 + 8) * scale if (icon or dot or shape_icon) else 0
    w = lead + icon_w + measure(label, size, wght, track) + 16 * scale
    x0 = x - w if anchor == "end" else x
    rx = CORNER["sm"] * scale
    if fill:
        c.add(f'<rect x="{x0:.1f}" y="{y:.1f}" width="{w:.1f}" height="{h:.1f}" rx="{rx:.1f}" '
              f'style="fill:var(--{fill})"/>')
    else:
        b = scale / 2
        c.add(f'<rect x="{x0 + b:.1f}" y="{y + b:.1f}" width="{w - 2 * b:.1f}" height="{h - 2 * b:.1f}" '
              f'rx="{rx:.1f}" style="fill:none;stroke:var(--outv);stroke-width:{scale:.1f}"/>')
    ix, iy, isz = x0 + lead, y + (h - 18 * scale) / 2, 18 * scale
    if icon:
        c.add(glyph(icon, ix, iy, isz, icon_color, stroke=1.8, fill=True))
    if dot:
        c.add(f'<circle cx="{ix + isz / 2:.1f}" cy="{iy + isz / 2:.1f}" r="{isz * .36:.1f}" fill="{dot}"/>')
    if shape_icon:
        c.add(shape(shape_icon, ix + isz / 2, iy + isz / 2, isz / 2, icon_color))
    c.text(x0 + lead + icon_w, y + h / 2 + size * .36, label, size, fg, wght, ls=track)
    return w


def icon_image(repo: str, path: str, size: int) -> str | None:
    try:
        data = fetch(f"https://raw.githubusercontent.com/{USER}/{repo}/HEAD/{path}")
    except Exception as e:  # missing icon: fall back to a shape
        print(f"  ! no icon for {repo}: {e}", file=sys.stderr)
        return None
    if path.endswith(".svg"):
        return "data:image/svg+xml;base64," + base64.b64encode(data).decode()
    im = Image.open(io.BytesIO(data))  # .ico files open at their largest size
    im = im.convert("RGBA").resize((size * 2, size * 2), Image.LANCZOS)
    buf = io.BytesIO()
    im.save(buf, "PNG", optimize=True)
    return "data:image/png;base64," + base64.b64encode(buf.getvalue()).decode()


def is_new(repo_info) -> bool:
    if "created_at" not in repo_info:
        return False
    created = dt.datetime.fromisoformat(repo_info["created_at"].replace("Z", "+00:00"))
    return (dt.datetime.now(dt.timezone.utc) - created).days <= 21


def fmt(n: int) -> str:
    return f"{n / 1000:.1f}k".replace(".0k", "k") if n >= 1000 else str(n)


def filled_card(c: Canvas, x, y, w, h, color="s4", corner="xl"):
    """Filled card container. Corners use the expressive extra-large step."""
    c.add(f'<rect x="{x:.1f}" y="{y:.1f}" width="{w:.1f}" height="{h:.1f}" rx="{CORNER[corner] * DP:.1f}" '
          f'style="fill:var(--{color})"/>')


# Shape + container colour pairs, cycled so neighbouring cards differ.
CARD_SHAPES = ["cookie9", "sunny", "clover4", "cookie12", "puffy_diamond", "soft_burst", "cookie7", "clover8"]


def project_card(p: dict, idx: int, info: dict):
    W, H = 600, 324
    pad = 24 * DP
    accent = ACCENTS[idx % 3]
    c = Canvas(W, H, f"{p['name']}: {p['desc']}")
    filled_card(c, 0, 0, W, H)

    icon = 56 * DP
    img = icon_image(p["repo"], p["icon"], round(icon)) if p.get("icon") else None
    if img:
        c.add(f'<image href="{img}" x="{pad:.1f}" y="{pad:.1f}" width="{icon:.1f}" height="{icon:.1f}"/>')
    else:  # no app icon: an expressive shape holding the initial
        cx, cy = pad + icon / 2, pad + icon / 2
        c.add(shape(CARD_SHAPES[idx % len(CARD_SHAPES)], cx, cy, icon / 2, accent + "c"))
        size, _, _, wght = ts("headline_s", True)
        c.text(cx, cy + size * .36, p.get("glyph", p["name"][0]), size, "on" + accent + "c", wght,
               anchor="middle")

    # Assist chips, right aligned and centred on the icon.
    cy = pad + (icon - 32 * DP) / 2
    x = W - pad
    stars = info.get("stargazers_count", 0)
    if stars:
        x -= assist_chip(c, x, cy, fmt(stars), anchor="end", icon="star") + 8 * DP
    if info.get("language"):
        x -= assist_chip(c, x, cy, info["language"], anchor="end",
                         dot=LANG_COLORS.get(info["language"], "#888")) + 8 * DP
    if is_new(info):
        assist_chip(c, x, cy, "New", anchor="end", fill="tc", fg="ontc", shape_icon="sunny",
                    icon_color="t")

    y = pad + icon + 24 * DP
    c.styled(pad, y + 14 * DP * .8, p["platform"], "label_l", accent, emphasized=True)
    y += 20 * DP + 8 * DP
    c.styled(pad, y + 24 * DP * .82, p["name"], "headline_s", "on", emphasized=True)
    y += 32 * DP + 4 * DP
    size, lh, track, wght = ts("body_l")
    for i, line in enumerate(wrap(p["desc"], size, W - 2 * pad, wght=wght, ls=track)[:3]):
        c.text(pad, y + size * .8 + i * lh, line, size, "onv", wght, ls=track)
    save(p["repo"], c)


def png_uri(im: Image.Image) -> str:
    buf = io.BytesIO()
    im.save(buf, "PNG", optimize=True)
    return "data:image/png;base64," + base64.b64encode(buf.getvalue()).decode()


def split_glyph(im: Image.Image):
    """Splits a favicon into its white ink (returned as an alpha mask, to be
    filled with a theme colour) and its accent colours (kept as is)."""
    im = im.convert("RGBA")
    ink = Image.new("RGBA", im.size, (255, 255, 255, 0))
    colour = Image.new("RGBA", im.size, (0, 0, 0, 0))
    ip, cp = ink.load(), colour.load()
    for yy in range(im.size[1]):
        for xx in range(im.size[0]):
            r_, g_, b_, a_ = im.getpixel((xx, yy))
            if not a_:
                continue
            neutral = max(r_, g_, b_) - min(r_, g_, b_) < 48
            if neutral and min(r_, g_, b_) > 140:
                ip[xx, yy] = (255, 255, 255, a_)
            elif neutral and max(r_, g_, b_) < 110:
                continue  # dark outlines only make sense on light ink; drop them
            else:
                cp[xx, yy] = (r_, g_, b_, a_)
    has_colour = colour.getchannel("A").getbbox() is not None
    return ink, (colour if has_colour else None)


def shape_icon(c: Canvas, kind, cx, cy, r, accent, glyph_char, icon_mode=None, icon_file=None):
    """An expressive shape holding a favicon, or the initial when there is none."""
    im = None
    if icon_file and Path(icon_file).exists():
        im = Image.open(icon_file).convert("RGBA")
    if im and icon_mode == "plain":
        c.add(f'<image href="{png_uri(im.resize((round(4 * r), round(4 * r)), Image.LANCZOS))}" '
              f'x="{cx - r:.1f}" y="{cy - r:.1f}" width="{2 * r:.1f}" height="{2 * r:.1f}"/>')
        return
    if im and icon_mode == "clip":
        clip = c.uid("s")
        c.add(f'<clipPath id="{clip}"><path d="{shape_path(kind, cx, cy, r)}"/></clipPath>')
        c.add(f'<image href="{png_uri(im.resize((round(4 * r), round(4 * r)), Image.LANCZOS))}" '
              f'x="{cx - r:.1f}" y="{cy - r:.1f}" width="{2 * r:.1f}" height="{2 * r:.1f}" '
              f'clip-path="url(#{clip})" preserveAspectRatio="xMidYMid slice"/>')
        return
    c.add(shape(kind, cx, cy, r, accent + "c"))
    if im and icon_mode == "glyph":
        g = 1.1 * r  # the ink sits in the shape's safe zone
        ink, colour = split_glyph(im.resize((round(2 * g), round(2 * g)), Image.LANCZOS))
        m = c.uid("m")
        box = f'x="{cx - g / 2:.1f}" y="{cy - g / 2:.1f}" width="{g:.1f}" height="{g:.1f}"'
        c.add(f'<mask id="{m}" maskUnits="userSpaceOnUse" {box}><image href="{png_uri(ink)}" {box}/></mask>'
              f'<rect {box} mask="url(#{m})" style="fill:var(--on{accent}c)"/>')
        if colour:
            c.add(f'<image href="{png_uri(colour)}" {box}/>')
        return
    size, _, _, wght = ts("headline_m", True)
    c.text(cx, cy + size * .36, glyph_char, size, "on" + accent + "c", wght, anchor="middle")


def compact_card(key: str, name: str, desc: str, glyph_char: str, idx: int, sub: str | None = None,
                 info: dict | None = None, icon_mode: str | None = None):
    W, H = 600, 184
    pad = 24 * DP
    accent = ACCENTS[idx % 3]
    c = Canvas(W, H, f"{name}: {desc}")
    filled_card(c, 0, 0, W, H)
    r = 32 * DP
    kind = CARD_SHAPES[idx % len(CARD_SHAPES)]
    icon_file = HERE / "web-icons" / f"{key.removeprefix('web-')}.png" if icon_mode else None
    shape_icon(c, kind, pad + r, H / 2, r, accent, glyph_char, icon_mode, icon_file)

    x = pad + 2 * r + 16 * DP
    right = W - pad
    if info and info.get("stargazers_count"):
        right -= assist_chip(c, W - pad, pad - 6, fmt(info["stargazers_count"]), anchor="end",
                             icon="star") + 8 * DP
    t_size, t_lh, _, _ = ts("title_l", True)
    b_size, b_lh, b_track, b_wght = ts("body_m")
    lines = wrap(desc, b_size, W - x - pad, wght=b_wght, ls=b_track)[:2]
    block = t_lh + len(lines) * b_lh + (ts("label_l")[1] + 4 * DP if sub else 0)
    y = (H - block) / 2
    c.styled(x, y + t_size * .82, name, "title_l", "on", emphasized=True)
    y += t_lh
    for line in lines:
        c.text(x, y + b_size * .85, line, b_size, "onv", b_wght, ls=b_track)
        y += b_lh
    if sub:
        y += 4 * DP
        c.styled(x, y + 14 * DP * .85, sub, "label_l", accent, emphasized=True)
    save(key, c)


def section_header(key: str, title: str, subtitle: str, icon: str, kind: str, accent: str):
    W, H = 1200, 128
    c = Canvas(W, H, f"{title}. {subtitle}")
    r = 36 * DP
    c.add(shape(kind, r + 4, H / 2, r, accent + "c", cls="spin"))
    gs = 28 * DP
    c.add(glyph(icon, r + 4 - gs / 2, H / 2 - gs / 2, gs, "on" + accent + "c", stroke=2))
    x = 2 * r + 4 + 20 * DP
    c.styled(x, H / 2 - 2, title, "headline_l", "head", emphasized=True)
    c.styled(x, H / 2 + 32, subtitle, "body_l", "sub")
    save(key, c)


def button(b: dict):
    """M3 Expressive small button (40dp, round), drawn at 2x so it stays sharp:
    16dp side padding, 20dp icon, 8dp icon-label gap, label large. Filled uses
    primary, tonal uses secondary container."""
    k = 2
    H = 40 * k
    size, _, track, wght = ts("label_l", scale=k)
    W = round(16 * k + 20 * k + 8 * k + measure(b["label"], size, wght, track) + 16 * k)
    c = Canvas(W, H, b["label"])
    bg, fg = ("p", "onp") if b["style"] == "filled" else ("sc", "onsc")
    c.add(f'<rect width="{W}" height="{H}" rx="{H / 2}" style="fill:var(--{bg})"/>')
    c.add(glyph(b["icon"], 16 * k, (H - 20 * k) / 2, 20 * k, fg, stroke=2))
    c.text(16 * k + 20 * k + 8 * k, H / 2 + size * .36, b["label"], size, fg, wght, ls=track)
    save("btn-" + b["slug"], c)


def hero(avatar_uri: str | None):
    W, H = 1200, 520
    c = Canvas(W, H, "Ciao! I'm Vis. I build private, good-looking apps for Android and Windows.")
    clip = c.uid("k")
    rx = CORNER["xxl"] * DP
    c.add(f'<clipPath id="{clip}"><rect width="{W}" height="{H}" rx="{rx:.1f}"/></clipPath>')
    c.add(f'<rect width="{W}" height="{H}" rx="{rx:.1f}" style="fill:var(--s3)"/>')

    # Right: avatar on a slowly turning 12-sided cookie, a few shapes around it.
    cx, cy = 938, 262
    c.add(f'<g clip-path="url(#{clip})">'
          + shape("clover8", 1215, 10, 110, "tc", rot=12, extra=' opacity=".55"')
          + "</g>")
    c.add(shape("cookie12", cx, cy, 196, "hs", cls="spin"))
    c.add(shape("very_sunny", 1112, 92, 38, "t", cls="spin rev"))
    c.add(shape("clover4", 760, 418, 34, "tc", rot=12, cls="bob"))
    c.add(shape("pill", 1112, 420, 46, "x", rot=-35, cls="bob", css="animation-delay:-3.5s"))
    c.add(shape("circle", 776, 96, 14, "p"))
    if avatar_uri:
        c.add(f'<image href="{avatar_uri}" x="{cx - 170}" y="{cy - 170}" width="340" height="340"/>')

    x = 64
    c.styled(x, 112, "Ciao! I'm", "title_l", "p", emphasized=True)
    # Display large, emphasized, scaled up for the one hero moment on the page.
    big = 57 * 3.2
    c.text(x - 8, 112 + big * .84, "Vis", big, "p", 500, ls=-.25 * 3.2)
    vis_w = measure("Vis", big, 500, -.25 * 3.2)
    c.add(f'<g transform="rotate(-10 {x + vis_w + 40:.0f} 180)">')
    c.text(x + vis_w + 4, 196, ":3", 45 * DP, "t", 500)
    c.add("</g>")
    h_size, h_lh, h_tr, h_w = ts("headline_m")
    c.text(x, 352, "I build private, good-looking apps", h_size, "on", h_w, ls=h_tr)
    c.text(x, 352 + h_lh, "for Android and Windows.", h_size, "on", h_w, ls=h_tr)
    cxp = x
    for label, kind, col in [("Kotlin + Compose", "cookie9", "p"), ("Rust", "sunny", "t"),
                             ("Material 3 Expressive", "clover4", "x")]:
        cxp += assist_chip(c, cxp, 430, label, shape_icon=kind, icon_color=col) + 8 * DP
    save("hero", c)


def wavy_indicator(c: Canvas, x, y, w, progress, scale=DP):
    """M3 Expressive linear wavy progress indicator (determinate): 4dp active
    indicator waving 3dp over a 40dp wavelength, a 4dp gap, a flat 4dp track in
    secondary container and the 4dp stop dot at the end."""
    th, amp, wl, gap, stop = 4 * scale, 3 * scale, 40 * scale, 4 * scale, 4 * scale
    end = x + max(th, (w - th) * progress)
    pts = []
    steps = max(8, int((end - x) / 3))
    for i in range(steps + 1):
        px = x + th / 2 + (end - x - th / 2) * i / steps
        pts.append(f"{px:.1f} {y + amp * math.sin(2 * math.pi * (px - x) / wl):.1f}")
    c.add(f'<path d="M{" L".join(pts)}" style="fill:none;stroke:var(--p);stroke-width:{th:.1f};'
          f'stroke-linecap:round;stroke-linejoin:round"/>')
    t0 = end + gap + th / 2
    if t0 < x + w - th / 2:
        c.add(f'<line x1="{t0:.1f}" y1="{y}" x2="{x + w - th / 2:.1f}" y2="{y}" '
              f'style="stroke:var(--sc);stroke-width:{th:.1f};stroke-linecap:round"/>')
    c.add(f'<circle cx="{x + w - stop / 2:.1f}" cy="{y}" r="{stop / 2:.1f}" style="fill:var(--p)"/>')


def glance(stats: list[tuple[str, str, str, str]], langs: list[tuple[str, float]]):
    W = 1200
    gap = 16 * DP
    pad = 24 * DP
    tw, th = (W - 3 * gap) / 4, 228
    # Language panel on the 4dp grid: title (28dp line), 20dp, two rows of
    # label (24dp line) + 8dp + wavy indicator (10dp wave height) with 24dp
    # between them, and the same 24dp padding at the bottom as at the top.
    rows = 2
    row_h = (24 + 8 + 10) * DP
    lh = pad + 28 * DP + 20 * DP + rows * row_h + (rows - 1) * 24 * DP + pad
    H = th + gap + lh
    c = Canvas(W, H, "At a glance: " + ", ".join(f"{v} {k}" for k, v, *_ in stats))
    for i, (label, value, icon, kind) in enumerate(stats):
        x = i * (tw + gap)
        a = ACCENTS[i % 3]
        filled_card(c, x, 0, tw, th)
        r = 24 * DP
        c.add(shape(kind, x + pad + r, pad + r, r, a + "c", cls="spin" if i % 2 == 0 else "spin rev"))
        c.add(glyph(icon, x + pad + r - 12 * DP, pad + r - 12 * DP, 24 * DP, "on" + a + "c", stroke=2))
        c.styled(x + pad, pad + 2 * r + 16 * DP + 45 * DP * .8, value, "display_m", a, emphasized=True)
        c.styled(x + pad, th - pad, label, "body_l", "onv")

    y0 = th + gap
    filled_card(c, 0, y0, W, lh)
    c.styled(pad, y0 + pad + 22 * DP * .8, "What I write in", "title_l", "on", emphasized=True)
    c.styled(W - pad, y0 + pad + 22 * DP * .8, "share of code across the projects below", "body_m",
             "onv", anchor="end")
    col_w = (W - 2 * pad - 32 * DP) / 2
    for i, (name, share) in enumerate(langs[:4]):
        cx = pad + (i % 2) * (col_w + 32 * DP)
        cy = y0 + pad + 28 * DP + 20 * DP + (i // 2) * (row_h + 24 * DP)
        base = cy + 12 * DP + 16 * DP * .36  # label baseline, centred in its 24dp line
        c.styled(cx, base, name, "title_m", "on")
        c.styled(cx + col_w, base, f"{share * 100:.0f}%", "label_l", "onv", anchor="end")
        wavy_indicator(c, cx, cy + (24 + 8 + 5) * DP, col_w, share)
    save("glance", c)


def footer():
    W, H = 1200, 150
    c = Canvas(W, H, "Thanks for stopping by")
    kinds = ["cookie9", "sunny", "clover4", "pill", "puffy", "very_sunny", "cookie12", "heart"]
    cols = ["pc", "tc", "xc", "sc", "pc", "t", "tc", "p"]
    x0 = W / 2 - (len(kinds) - 1) * 44
    for i, (k, col) in enumerate(zip(kinds, cols)):
        c.add(shape(k, x0 + i * 88, 46, 26, col, rot=-30 if k == "pill" else 0, cls="bob",
                    css=f"animation-delay:-{i * .9:.1f}s"))
    c.styled(W / 2, 128, "Thanks for stopping by :3", "title_l", "sub", emphasized=True, anchor="middle")
    save("footer", c)


# --------------------------------------------------------------------------

def main():
    global CACHE
    if "--cache" in sys.argv:
        CACHE = Path(sys.argv[sys.argv.index("--cache") + 1])
        CACHE.mkdir(parents=True, exist_ok=True)

    user = api(f"users/{USER}")
    repos = api(f"users/{USER}/repos?per_page=100&type=owner")
    by_name = {r["name"]: r for r in repos}
    own = [r for r in repos if not r["fork"]]
    stars = sum(r["stargazers_count"] for r in own)

    featured = ANDROID + WINDOWS + CREATIVE + MODS
    totals: dict[str, int] = {}
    for p in featured:
        for lang, size in api(f"repos/{USER}/{p['repo']}/languages").items():
            totals[lang] = totals.get(lang, 0) + size
    total = sum(totals.values()) or 1
    langs = [(k, v / total) for k, v in sorted(totals.items(), key=lambda kv: -kv[1])]

    print("Rendering cards")
    avatar = None
    try:
        im = Image.open(io.BytesIO(fetch(f"https://avatars.githubusercontent.com/u/{user['id']}?s=400")))
        buf = io.BytesIO()
        im = im.convert("RGBA").resize((340, 340), Image.LANCZOS)
        im.quantize(96, method=Image.Quantize.FASTOCTREE).save(buf, "PNG", optimize=True)
        avatar = "data:image/png;base64," + base64.b64encode(buf.getvalue()).decode()
    except Exception as e:
        print(f"  ! avatar: {e}", file=sys.stderr)

    hero(avatar)
    glance([("public repos", str(user["public_repos"]), "folder", "cookie9"),
            ("stars on GitHub", fmt(stars), "star", "sunny"),
            ("people reached", REACH, "people", "clover4"),
            ("building since", SINCE, "cake", "soft_burst")], langs)
    for b in BUTTONS:
        button(b)
    section_header("h-android", "Android apps", "Kotlin, Jetpack Compose and Material 3 Expressive",
                   "phone", "cookie9", "p")
    section_header("h-windows", "Windows apps", "Small, fast and native. Mostly Rust, no bloat",
                   "window", "sunny", "t")
    section_header("h-creative", "Images, media and AI", "Privacy, compression and local models",
                   "spark", "clover4", "s")
    section_header("h-mods", "Mods and plugins", "Making apps I already use a little better",
                   "code", "puffy_diamond", "p")
    section_header("h-web", "On the web", "Live at visiuun.com and friends", "globe", "cookie12", "t")
    for group in (ANDROID, WINDOWS, CREATIVE):
        for i, p in enumerate(group):
            project_card(p, i, by_name.get(p["repo"], {}))
    for i, m in enumerate(MODS):
        compact_card(m["repo"], m["name"], m["desc"], m["glyph"], i + 1, info=by_name.get(m["repo"], {}))
    for i, w in enumerate(WEB):
        compact_card("web-" + w["slug"], w["name"], w["desc"], w["glyph"], i, sub=w["url"],
                     icon_mode=w.get("icon"))
    footer()


if __name__ == "__main__":
    main()
