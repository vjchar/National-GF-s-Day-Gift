(() => {
  const canvas = document.getElementById("stars");

  if (!(canvas instanceof HTMLCanvasElement)) {
    return;
  }

  const context = canvas.getContext("2d");

  if (!context) {
    return;
  }

  let stars = [];

  function resizeCanvas() {
    const ratio = window.devicePixelRatio || 1;

    canvas.width = Math.floor(window.innerWidth * ratio);
    canvas.height = Math.floor(window.innerHeight * ratio);
    canvas.style.width = `${window.innerWidth}px`;
    canvas.style.height = `${window.innerHeight}px`;

    context.setTransform(ratio, 0, 0, ratio, 0, 0);

    stars = Array.from(
      { length: Math.min(190, Math.max(80, Math.floor(window.innerWidth / 6))) },
      () => ({
        x: Math.random() * window.innerWidth,
        y: Math.random() * window.innerHeight,
        radius: Math.random() * 1.8 + 0.2,
        phase: Math.random() * Math.PI * 2,
        speed: Math.random() * 0.012 + 0.004
      })
    );
  }

  function draw() {
    context.clearRect(0, 0, window.innerWidth, window.innerHeight);

    for (const star of stars) {
      star.phase += star.speed;
      const opacity = 0.2 + Math.abs(Math.sin(star.phase)) * 0.8;

      context.beginPath();
      context.arc(star.x, star.y, star.radius, 0, Math.PI * 2);
      context.fillStyle = `rgba(255,255,255,${opacity})`;
      context.fill();
    }

    window.requestAnimationFrame(draw);
  }

  window.addEventListener("resize", resizeCanvas);
  resizeCanvas();
  draw();
})();
