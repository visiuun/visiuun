import React from 'https://cdn.skypack.dev/react';
import { render } from 'https://cdn.skypack.dev/react-dom';

const ROOT_NODE = document.querySelector('#app');

/**
* Tiny hook that you can use where you need it
*/
const usePointerGlow = () => {
  const [status, setStatus] = React.useState(null);
  React.useEffect(() => {
    const syncPointer = ({ x: pointerX, y: pointerY }) => {
      const x = pointerX.toFixed(2);
      const y = pointerY.toFixed(2);
      const xp = (pointerX / window.innerWidth).toFixed(2);
      const yp = (pointerY / window.innerHeight).toFixed(2);
      document.documentElement.style.setProperty('--x', x);
      document.documentElement.style.setProperty('--xp', xp);
      document.documentElement.style.setProperty('--y', y);
      document.documentElement.style.setProperty('--yp', yp);
      setStatus({ x, y, xp, yp });
    };
    document.body.addEventListener('pointermove', syncPointer);
    return () => {
      document.body.removeEventListener('pointermove', syncPointer);
    };
  }, []);
  return [status];
};

const App = () => {
  const [status] = usePointerGlow();
  const [tooltipText, setTooltipText] = React.useState(null);
  const [tooltipVisible, setTooltipVisible] = React.useState(false);
  const [tooltipPosition, setTooltipPosition] = React.useState({ x: 0, y: 0 });

  const handleTooltipMouseEnter = (text, event) => {
    setTooltipText(text);
    setTooltipVisible(true);
    setTooltipPosition({ x: event.clientX, y: event.clientY });
  };

  const handleTooltipMouseLeave = () => {
    setTooltipVisible(false);
  };


  const links = [
  {
    href: "https://www.visiuun.com",
    text: "Portfolio",
    icon: /*#__PURE__*/React.createElement("i", { className: "fas fa-home fa-lg", style: { color: 'white' } }), // Briefcase Icon
    imageUrl: "https://visiuun.altervista.org/Nekobox/uploads/C6vnKkOcQf.png" },

  {
    href: "https://www.instagram.com/visiuun/",
    text: "Instagram",
    icon: /*#__PURE__*/React.createElement("i", { className: "fab fa-instagram fa-lg", style: { color: 'white' } }), // Instagram Icon
    imageUrl: "https://visiuun.altervista.org/Nekobox/uploads/xLAOy7tPXR.png" },

  {
    href: "https://discord.gg/vXUvdUcvDM",
    text: "Discord",
    icon: /*#__PURE__*/React.createElement("i", { className: "fab fa-discord fa-lg", style: { color: 'white' } }), // Discord Icon
    imageUrl: "http://visiuun.altervista.org/Nekobox/uploads/z2Cw7HWUAM.png" },

  {
    href: "https://twitter.com/visiuun",
    text: "X",
    icon: /*#__PURE__*/React.createElement("i", { className: "fab fa-x-twitter fa-lg", style: { color: 'white' } }), // X Icon (formerly Twitter)
    imageUrl: "https://visiuun.altervista.org/Nekobox/uploads/CgsA3ViQYp.png",
    nsfw: true // Added NSFW flag
  },
  {
    href: "https://github.com/visiuun",
    text: "GitHub",
    icon: /*#__PURE__*/React.createElement("i", { className: "fab fa-github fa-lg", style: { color: 'white' } }), // GitHub Icon
    imageUrl: "https://visiuun.altervista.org/Nekobox/uploads/fnaizUznAJ.png" },

  {
    href: "https://www.deviantart.com/visionuse",
    text: "DeviantArt",
    icon: /*#__PURE__*/React.createElement("i", { className: "fab fa-deviantart fa-lg", style: { color: 'white' } }), // DeviantArt Icon
    imageUrl: "https://visiuun.altervista.org/Nekobox/uploads/vRqAUfjb0v.png",
    nsfw: true // Added NSFW flag
  }];


  return /*#__PURE__*/(
    React.createElement("main", null,
    links.map((link, index) => /*#__PURE__*/
    React.createElement("article", { key: index, "data-glow": true }, /*#__PURE__*/
    React.createElement("span", { "data-glow": true }), /*#__PURE__*/
    React.createElement("div", { className: "image-container" }, /*#__PURE__*/
    React.createElement("img", { src: link.imageUrl, alt: link.text })), /*#__PURE__*/

    React.createElement("div", { className: "icon-container" },
    link.icon,
    link.nsfw && /*#__PURE__*/
    React.createElement("i", {
      className: "fas fa-exclamation-triangle fa-shake nsfw-icon",
      onMouseEnter: e => handleTooltipMouseEnter("NSFW", e),
      onMouseLeave: handleTooltipMouseLeave })), /*#__PURE__*/



    React.createElement("a", { "data-glow": true, href: link.href, target: "_blank", rel: "noopener noreferrer" }, /*#__PURE__*/
    React.createElement("span", null, link.text)))),



    tooltipVisible && tooltipText && /*#__PURE__*/
    React.createElement("div", {
      className: "tooltip",
      style: { left: tooltipPosition.x + 10, top: tooltipPosition.y + 10 } },

    tooltipText)));




};

render( /*#__PURE__*/React.createElement(App, null), ROOT_NODE);
