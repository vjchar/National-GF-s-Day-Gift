document.addEventListener("DOMContentLoaded", () => {
  initializeNavigation();
  initializeMobileMenu();
  initializeMusic();
  initializeFlowers();
  initializeMemoryStars();
  initializeGallery();
  initializeRelationshipCounter();
  initializeSpecialCountdowns();
  initializeReplyForm();
  initializeOpenOnce();
  initializeFinalSurprise();
});


function initializeMobileMenu() {
  const button = document.getElementById("mobileMenuButton");
  const navigation = document.getElementById("siteNav");

  if (!button || !navigation) return;

  button.addEventListener("click", () => {
    const isOpen = navigation.classList.toggle("is-open");
    button.setAttribute("aria-expanded", String(isOpen));
    button.setAttribute(
      "aria-label",
      isOpen ? "Close navigation" : "Open navigation"
    );
    button.textContent = isOpen ? "✕" : "☰";
  });

  navigation.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      navigation.classList.remove("is-open");
      button.setAttribute("aria-expanded", "false");
      button.setAttribute("aria-label", "Open navigation");
      button.textContent = "☰";
    });
  });
}

function initializeNavigation() {
  const button = document.getElementById("enterStoryButton");
  const target = document.getElementById("flowers");

  if (!button || !target) return;

  button.addEventListener("click", () => {
    target.scrollIntoView({ behavior: "smooth" });
  });
}

function initializeMusic() {
  const button = document.getElementById("musicButton");
  const audio = document.getElementById("backgroundMusic");

  if (!button || !audio) return;

  let playing = false;

  button.addEventListener("click", async () => {
    try {
      if (playing) {
        audio.pause();
        button.textContent = "♫";
      } else {
        await audio.play();
        button.textContent = "❚❚";
      }

      playing = !playing;
    } catch (error) {
      alert("Add an MP3 file named song.mp3 inside assets/audio.");
      console.error(error);
    }
  });
}

function initializeFlowers() {
  const flowers = document.querySelectorAll(".flower");
  const messageBox = document.getElementById("flowerMessage");
  const waterButton = document.getElementById("waterFlowersButton");

  flowers.forEach((flower) => {
    flower.addEventListener("click", () => {
      flowers.forEach((item) => item.classList.remove("is-selected"));
      flower.classList.add("is-selected");

      if (messageBox) {
        messageBox.textContent =
          flower.dataset.message || "You are loved more than you know.";
      }
    });
  });

  if (waterButton) {
    waterButton.addEventListener("click", () => {
      flowers.forEach((flower, index) => {
        window.setTimeout(() => {
          flower.classList.add("is-watered");
        }, index * 100);
      });

      const today = new Date().toISOString().slice(0, 10);
      localStorage.setItem("lastFlowerWatering", today);

      if (messageBox) {
        messageBox.textContent =
          "The garden grew a little more today—just like my love for you. 🌱";
      }
    });
  }

  const today = new Date().toISOString().slice(0, 10);

  if (localStorage.getItem("lastFlowerWatering") === today) {
    flowers.forEach((flower) => flower.classList.add("is-watered"));
  }
}

function initializeMemoryStars() {
  const modal = document.getElementById("memoryModal");
  const title = document.getElementById("memoryModalTitle");
  const text = document.getElementById("memoryModalText");
  const close = document.getElementById("closeMemoryModal");

  if (!modal || !title || !text || !close) return;

  document.querySelectorAll(".memory-star").forEach((star) => {
    star.addEventListener("click", () => {
      title.textContent = star.dataset.title || "Our Memory";
      text.textContent = star.dataset.text || "";
      modal.hidden = false;
      document.body.style.overflow = "hidden";
    });
  });

  const closeModal = () => {
    modal.hidden = true;
    document.body.style.overflow = "";
  };

  close.addEventListener("click", closeModal);
  modal.addEventListener("click", (event) => {
    if (event.target === modal) closeModal();
  });
}

function initializeGallery() {
  const modal = document.getElementById("imageModal");
  const preview = document.getElementById("imageModalPreview");
  const close = document.getElementById("closeImageModal");

  if (!modal || !preview || !close) return;

  document.querySelectorAll(".gallery-item").forEach((item) => {
    item.addEventListener("click", () => {
      preview.src = item.dataset.image || "";
      modal.hidden = false;
      document.body.style.overflow = "hidden";
    });
  });

  const closeModal = () => {
    modal.hidden = true;
    preview.src = "";
    document.body.style.overflow = "";
  };

  close.addEventListener("click", closeModal);
  modal.addEventListener("click", (event) => {
    if (event.target === modal) closeModal();
  });
}

function initializeRelationshipCounter() {
  const counter = document.getElementById("relationshipCounter");

  if (!counter) return;

  const startDate = new Date(counter.dataset.start.replace(" ", "T"));

  if (Number.isNaN(startDate.getTime())) return;

  const elements = {
    days: document.getElementById("days"),
    hours: document.getElementById("hours"),
    minutes: document.getElementById("minutes"),
    seconds: document.getElementById("seconds")
  };

  function update() {
    const difference = Math.max(0, Date.now() - startDate.getTime());

    const days = Math.floor(difference / 86400000);
    const hours = Math.floor(difference / 3600000) % 24;
    const minutes = Math.floor(difference / 60000) % 60;
    const seconds = Math.floor(difference / 1000) % 60;

    if (elements.days) elements.days.textContent = String(days);
    if (elements.hours) elements.hours.textContent = String(hours).padStart(2, "0");
    if (elements.minutes) elements.minutes.textContent = String(minutes).padStart(2, "0");
    if (elements.seconds) elements.seconds.textContent = String(seconds).padStart(2, "0");
  }

  update();
  window.setInterval(update, 1000);
}

function initializeSpecialCountdowns() {
  document.querySelectorAll(".countdown-card").forEach((card) => {
    const value = card.querySelector(".special-countdown-value");

    if (!value) return;

    const now = new Date();
    const type = card.dataset.countdownType;
    let target;

    if (type === "birthday") {
      const date = new Date(card.dataset.date + "T00:00:00");
      target = new Date(now.getFullYear(), date.getMonth(), date.getDate());

      if (target <= now) {
        target.setFullYear(now.getFullYear() + 1);
      }
    } else if (type === "anniversary") {
      const [month, day] = (card.dataset.date || "01-01").split("-").map(Number);
      target = new Date(now.getFullYear(), month - 1, day);

      if (target <= now) {
        target.setFullYear(now.getFullYear() + 1);
      }
    } else {
      target = new Date(now.getFullYear(), 11, 25);

      if (target <= now) {
        target.setFullYear(now.getFullYear() + 1);
      }
    }

    const days = Math.ceil((target - now) / 86400000);
    value.textContent = `${days} day${days === 1 ? "" : "s"} to go`;
  });
}

function initializeReplyForm() {
  const form = document.getElementById("replyForm");
  const status = document.getElementById("replyStatus");

  if (!form || !status) return;

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    status.textContent = "Saving your message…";

    try {
      const response = await fetch("api/save_message.php", {
        method: "POST",
        body: new FormData(form)
      });

      const data = await response.json();
      status.textContent = data.message;

      if (data.success) {
        form.reset();
        window.setTimeout(() => window.location.reload(), 900);
      }
    } catch (error) {
      status.textContent = "Something went wrong while saving your message.";
      console.error(error);
    }
  });
}

function initializeOpenOnce() {
  const button = document.getElementById("openOnceButton");
  const result = document.getElementById("openOnceResult");

  if (!button || !result) return;

  button.addEventListener("click", async () => {
    button.disabled = true;
    result.textContent = "Opening the sealed letter…";

    try {
      const response = await fetch("api/open_once.php", {
        method: "POST"
      });

      const data = await response.json();
      result.textContent = data.message;

      if (!data.success) {
        button.textContent = "Letter Already Opened";
      } else {
        button.textContent = "Opened ♡";
        createCelebration("heart");
      }
    } catch (error) {
      result.textContent = "The sealed letter could not be opened.";
      button.disabled = false;
      console.error(error);
    }
  });
}

function initializeFinalSurprise() {
  const button = document.getElementById("finalSurpriseButton");
  const message = document.getElementById("finalMessage");

  if (!button || !message) return;

  button.addEventListener("click", () => {
    const visible = message.classList.toggle("is-visible");
    button.textContent = visible ? "Close the Gift" : "Open the Final Gift 🎁";

    if (visible) {
      createCelebration("mixed");
    }
  });
}

function createCelebration(type) {
  const layer = document.getElementById("celebrationLayer");

  if (!layer) return;

  layer.innerHTML = "";

  const symbols =
    type === "heart"
      ? ["♡", "♥"]
      : ["♡", "♥", "✦", "🌸", "🌹"];

  for (let index = 0; index < 60; index += 1) {
    const particle = document.createElement("span");
    particle.className = "celebration-particle";
    particle.textContent = symbols[Math.floor(Math.random() * symbols.length)];
    particle.style.left = `${Math.random() * 100}%`;
    particle.style.animationDelay = `${Math.random() * 0.8}s`;
    particle.style.animationDuration = `${2.5 + Math.random() * 2}s`;
    layer.appendChild(particle);
  }

  window.setTimeout(() => {
    layer.innerHTML = "";
  }, 5000);
}
