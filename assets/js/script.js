document.addEventListener('DOMContentLoaded', function() { // **SECTION: DOMContentLoaded Event Listener** - Ensures all code inside runs after the HTML document is fully loaded and parsed.

  // **SECTION: AOS (Animate On Scroll) Initialization** - Initializes the AOS library to enable animations triggered by scrolling.
  AOS.init();

  // **SECTION: ScrollReveal Initialization and Configuration** - Sets up ScrollReveal to create reveal animations for elements as they come into the viewport.
  const sr = ScrollReveal({
    origin: 'bottom',
    distance: '60px',
    duration: 1000,
    delay: 400
  });

  const ops = { interval: 100 };

  // **SECTION: ScrollReveal Element Reveals - Hero and General Content** - Defines which elements will have reveal animations and their general animation settings.
  sr.reveal('.head, .paragraph, .hero-button', ops);
  sr.reveal('.icon', ops);
  sr.reveal(".about-title, .about-img, .about-text, .about-description.grey", ops);
  sr.reveal('.stats-item', ops);
  sr.reveal('.card', { interval: 100, delay: 50 });
  // **SECTION: ScrollReveal Element Reveals - Project Section (Right)** - Defines reveal animations specifically for project elements on the right side, using different origins and durations.
  sr.reveal(".right .project-image", { interval: 100, origin: 'left', distance: '60px', duration: 2000 });
  sr.reveal('.right .project-content', { interval: 100, origin: 'right', distance: '60px', duration: 2000 });
  // **SECTION: ScrollReveal Element Reveals - Project Section (Left)** - Defines reveal animations specifically for project elements on the left side, using different origins and durations.
  sr.reveal(".left .project-image", { interval: 100, origin: 'right', distance: '180px', duration: 2000 });
  sr.reveal('.left .project-content', { interval: 100, origin: 'left', distance: '180px', duration: 2000 });

  // **SECTION: Three.js Blob Animation Setup** - Initializes Three.js renderer, scene, camera, geometry, and material for the 3D blob animation.
  const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('canvas'), antialias: true });
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setSize(452, 250);
  const scene = new THREE.Scene();
  let camera = new THREE.PerspectiveCamera(27, window.innerWidth / window.innerHeight, 0.1, 1000);
  camera.position.z = 5;
  const sphere_geometry = new THREE.SphereGeometry(1, 128, 128);
  const material = new THREE.MeshNormalMaterial();
  let sphere = new THREE.Mesh(sphere_geometry, material);
  scene.add(sphere);

  // **SECTION: Three.js Blob Animation Update Function** - Defines the function that modifies the blob's vertices based on noise and time, creating the animated effect.
  const update = function () {
    const time = performance.now() * 0.003;
    const k = 3;
    for (let i = 0; i < sphere.geometry.vertices.length; i++) {
      let p = sphere.geometry.vertices[i];
      p.normalize().multiplyScalar(1 + 0.3 * noise.perlin3(p.x * k + time, p.y * k, p.z * k));
    }
    sphere.geometry.computeVertexNormals();
    sphere.geometry.normalsNeedUpdate = true;
    sphere.geometry.verticesNeedUpdate = true;
  }

  // **SECTION: Three.js Animation Loop** - Sets up the animation loop to continuously update and render the 3D scene for the blob animation.
  function animate() {
    update();
    renderer.render(scene, camera);
    requestAnimationFrame(animate);
  }
  requestAnimationFrame(animate);

  // **SECTION: Navigation Links Smooth Scrolling** - Adds smooth scrolling behavior to navigation links that have the `data-scroll` attribute.
  const links = document.querySelectorAll(".nav-link");
  Array.from(links).forEach(link => {
    if (link.getAttribute('data-scroll')) {
      link.onclick = () => window.scrollTo({ top: document.querySelector(link.getAttribute("data-scroll")).offsetTop, behavior: 'smooth' })
    }
  })

  // **SECTION: Mobile Class Toggle Function** - Defines the function `add()` to add or remove the 'mobile' class on the body based on window width.
  function add() {
    if (window.innerWidth < 900) {
      document.body.classList.add('mobile')
    } else {
      document.body.classList.remove('mobile')
    }
  }
  add(); // **SECTION: Initial Mobile Class Check** - Calls the `add()` function immediately to set the 'mobile' class on initial page load if necessary.
  window.addEventListener('resize', add); // **SECTION: Mobile Class Update on Resize** - Adds an event listener to update the 'mobile' class whenever the window is resized.

  // **SECTION: Tippy.js Tooltip Initialization** - Initializes Tippy.js tooltips for specified elements using the `tips` array.
  const tips = [
    {
      query: '#discord',
      content: 'Discord'
    },
    {
      query: '#instagram',
      content: 'Instagram',
    },
    {
      query: '#github',
      content: 'Github',
    },
  ];

  for (const { query, content } of tips) {
    tippy(query, { content })
  }

  // **SECTION: Hamburger Menu Logic** - Handles the functionality of the hamburger menu for mobile navigation, toggling the 'open' class and animating the hamburger icon.
  let hamburger = document.querySelector('.hamburger')
  let mobileNav = document.querySelector('.nav-list')
  let bars = document.querySelectorAll('.hamburger span')
  let isActive = false
  hamburger.addEventListener('click', function () {
    mobileNav.classList.toggle('open')
    if (!isActive) {
      bars[0].style.transform = 'rotate(45deg)'
      bars[1].style.opacity = '0'
      bars[2].style.transform = 'rotate(-45deg)'
      isActive = true
    } else {
      bars[0].style.transform = 'rotate(0deg)'
      bars[1].style.opacity = '1'
      bars[2].style.transform = 'rotate(0deg)'
      isActive = false
    }
  })
}); // **SECTION: End of DOMContentLoaded Event Listener**

// **SECTION: Scroll Event Listener for Navigation Bar Style** - Listens for scroll events to change the navigation bar's background and backdrop filter when scrolling down, and reset styles when at the top.
window.addEventListener('scroll', e => {
  if (document.documentElement.scrollTop > 20) {
    const nav = document.getElementById('nav')
    nav.style.backgroundColor = 'rgba(0,0,0,0.5)'
    nav.style.backdropFilter = 'blur(5px)'
  } else {
    const nav = document.getElementById('nav') // Added to ensure nav is defined in else block too
    nav.style.boxShadow = 'inset 0 -1px 0 0 hsla(0,0%,100%,0.1)'
    nav.style.backgroundColor = 'transparent'
  }
})
