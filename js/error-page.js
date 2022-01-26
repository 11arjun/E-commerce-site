el = document.getElementById('backgroundslide');

el.addEventListener("mousemove", (e) => {
    el.style.backgroundPositionX = -e.offsetX + "px";
  });