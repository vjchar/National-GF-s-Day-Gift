<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
requireLogin();

$galleryDirectory = __DIR__ . '/assets/images/gallery';
$galleryWebPath = 'assets/images/gallery';
$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
$galleryImages = [];

if (is_dir($galleryDirectory)) {
    foreach (scandir($galleryDirectory) ?: [] as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (in_array($extension, $allowedExtensions, true)) {
            $galleryImages[] = $galleryWebPath . '/' . rawurlencode($file);
        }
    }
}

$messages = array_reverse(readJsonFile(MESSAGE_FILE, []));
$messages = array_slice($messages, 0, 12);

$timeline = [
    ['date' => 'The beginning', 'title' => 'Our first conversation', 'text' => 'I still remember the day we first talked. It seemed like such a simple moment back then, but little did I know it would become the beginning of one of the most meaningful chapters of my life. Looking back, I\'m so thankful that our paths crossed.'],
    ['date' => 'A favorite day', 'title' => 'The moment I knew', 'text' => 'There wasn\'t one huge moment that made me fall for you—it was all the little moments that slowly added up. Your kindness, your smile, and the way you made me feel comfortable made me realize that you had become someone incredibly special to me.'],
    ['date' => 'One adventure',  'title' => 'A memory worth keeping', 'text' => 'Whether it was a special date, a random trip, or simply spending time together doing nothing, every moment with you has become a memory I treasure. You have a way of making ordinary days feel extraordinary just by being there.'],
    ['date' => 'Still ahead',  'title' => 'A memory worth keeping', 'text' => 'I dream of creating many more memories with you—traveling to new places, celebrating our milestones, supporting each other through every challenge, and building a future filled with love, laughter, and countless beautiful moments together.'],
];

$places = [
    ['name' =>  'Where We First Met', 'text' => 'Every love story starts somewhere, and ours began in a place that will always be special to me. Whenever I think about it, I remember how one simple moment eventually led us to everything we have today. It will always be a place close to my heart because it was where our journey together truly began.'],
    ['name' => 'Our Favorite Place', 'text' => 'No matter where we go, my favorite place is wherever I\'m with you. Whether it\'s our favorite café, a quiet park, or simply sitting together and talking for hours, those moments become my favorite because they\'re shared with you.'],
    ['name' => 'Where We Should Go Next','text' => 'There are still so many places I want to explore with you. I dream of watching sunsets on beautiful beaches, discovering new cities, trying different foods, and making memories in places we\'ve never been. Wherever our next adventure takes us, I just hope it\'s with you by my side.'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta
    name="description"
    content="A private interactive National Girlfriend's Day gift."
  >
  <meta name="theme-color" content="#060512">
  <title><?= htmlspecialchars(APP_NAME) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <canvas id="stars" aria-hidden="true"></canvas>
  <div class="nebula" aria-hidden="true"></div>

  <header class="site-header">
    <a class="brand" href="#home">✦ <?= htmlspecialchars(APP_NAME) ?></a>

    <button
      class="mobile-menu-button"
      id="mobileMenuButton"
      type="button"
      aria-label="Open navigation"
      aria-expanded="false"
    >
      ☰
    </button>

    <nav class="site-nav" id="siteNav" aria-label="Main navigation">
      <a href="#flowers">Flowers</a>
      <a href="#memories">Memories</a>
      <a href="#letter">Letter</a>
      <a href="#reply">Reply</a>
      <a href="logout.php">Lock</a>
    </nav>
  </header>

  <button
    class="music-button"
    id="musicButton"
    type="button"
    aria-label="Play background music"
  >
    ♫
  </button>

  <audio id="backgroundMusic" loop preload="none">
    <source src="assets/audio/song.mp3" type="audio/mpeg">
  </audio>

  <main>
    <section class="hero-section" id="home">
      <div class="container hero">
        <p class="eyebrow">National Girlfriend's Day</p>

        <h1>
          For <?= htmlspecialchars(GIRLFRIEND_NAME) ?>,
          <span>My Favorite Universe</span>
        </h1>

        <p class="hero-description">
          I could have sent you a simple message, but you deserve a whole world
          made from memories, music, flowers, and everything I still want to say.
        </p>

        <button class="primary-button" id="enterStoryButton" type="button">
          Begin the Experience ✦
        </button>
      </div>
    </section>

    <section class="content-section" id="flowers">
      <div class="container">
        <p class="eyebrow center">A bouquet that never fades</p>
        <h2 class="section-title">The Garden I Grew for You</h2>

        <p class="section-description">
          Touch each flower. Every bloom carries a message meant only for you.
        </p>

        <div class="flower-garden glass-card" id="flowerGarden">
          <?php
          $flowerMessages = [
              'You make ordinary days feel worth remembering.',
              'Your smile can change the mood of my entire day.',
              'I admire how strong you are, even when things are difficult.',
              'You are one of the safest places my heart has ever known.',
              'I love the little things about you that nobody else notices.',
              'Choosing you is still one of my favorite decisions.',
              'I hope I get to keep growing beside you.',
              'You are loved more deeply than I always know how to say.',
          ];

          foreach ($flowerMessages as $index => $message):
              $flowerNumber = ($index % 4) + 1;
          ?>
            <button
              class="flower flower-<?= $flowerNumber ?>"
              type="button"
              data-message="<?= htmlspecialchars($message, ENT_QUOTES) ?>"
              aria-label="Open flower message <?= $index + 1 ?>"
            >
              <span class="flower-head" aria-hidden="true">
                <span class="petal-ring petal-ring-back">
                  <span class="petal petal-1"></span><span class="petal petal-2"></span>
                  <span class="petal petal-3"></span><span class="petal petal-4"></span>
                  <span class="petal petal-5"></span><span class="petal petal-6"></span>
                  <span class="petal petal-7"></span><span class="petal petal-8"></span>
                </span>
                <span class="petal-ring petal-ring-front">
                  <span class="petal petal-1"></span><span class="petal petal-2"></span>
                  <span class="petal petal-3"></span><span class="petal petal-4"></span>
                  <span class="petal petal-5"></span><span class="petal petal-6"></span>
                  <span class="petal petal-7"></span><span class="petal petal-8"></span>
                </span>
                <span class="flower-center"><span></span></span>
              </span>
              <span class="stem" aria-hidden="true"><span class="stem-highlight"></span></span>
              <span class="leaf leaf-left" aria-hidden="true"><span></span></span>
              <span class="leaf leaf-right" aria-hidden="true"><span></span></span>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="flower-message glass-card" id="flowerMessage">
          Pick a flower to reveal its message.
        </div>

        <button class="secondary-button centered-button" id="waterFlowersButton" type="button">
          Water the Flowers 💧
        </button>
      </div>
    </section>

    <section class="content-section" id="memories">
      <div class="container">
        <h2 class="section-title">The Constellation of Us</h2>
        <p class="section-description">
          Every glowing star holds a piece of our story.
        </p>

        <div class="constellation-card glass-card" aria-label="Interactive constellation map of our memories">
          <div class="constellation-heading" aria-hidden="true">
            <span>CELESTIAL MEMORY MAP</span>
            <small>Hover or tap a major star</small>
          </div>

          <svg class="constellation-lines" viewBox="0 0 1000 620" role="img" aria-label="A six-star constellation joined by fine celestial lines">
            <defs>
              <radialGradient id="starGlow">
                <stop offset="0" stop-color="#ffffff" stop-opacity=".92"/>
                <stop offset=".28" stop-color="#e7e2ff" stop-opacity=".32"/>
                <stop offset="1" stop-color="#9d8cff" stop-opacity="0"/>
              </radialGradient>
            </defs>
            <g class="celestial-grid" aria-hidden="true">
              <circle cx="500" cy="310" r="235"></circle>
              <circle cx="500" cy="310" r="150"></circle>
              <path d="M120 310H880 M500 78V542"></path>
            </g>
            <g class="minor-stars" aria-hidden="true">
              <circle cx="84" cy="102" r="2"/><circle cx="178" cy="490" r="1.5"/>
              <circle cx="258" cy="88" r="1.6"/><circle cx="356" cy="520" r="2"/>
              <circle cx="594" cy="94" r="1.4"/><circle cx="730" cy="518" r="1.7"/>
              <circle cx="902" cy="130" r="2"/><circle cx="918" cy="438" r="1.4"/>
              <circle cx="430" cy="210" r="1.2"/><circle cx="612" cy="426" r="1.3"/>
            </g>
            <g class="constellation-paths" aria-hidden="true">
              <path d="M145 205 L300 360 L487 170 L662 390 L848 222"></path>
              <path d="M300 360 L515 498 L662 390"></path>
              <path class="faint-link" d="M487 170 L515 498"></path>
            </g>
            <g class="star-glows" aria-hidden="true">
              <circle cx="145" cy="205" r="38"/><circle cx="300" cy="360" r="32"/>
              <circle cx="487" cy="170" r="42"/><circle cx="662" cy="390" r="34"/>
              <circle cx="848" cy="222" r="38"/><circle cx="515" cy="498" r="34"/>
            </g>
          </svg>

          <?php
          $starMemories = [
              ['The First Spark', 'I still remember the first time we started talking. I never imagined that a simple conversation would eventually become one of the best things that ever happened to me. Looking back now, I\'m really grateful that our paths crossed because that moment changed my life in the most beautiful way.'],
              ['My Favorite Memory', 'Out of all the memories we\'ve made together, my favorite will always be the moments where we laugh until we forget everything else. It doesn\'t matter where we are or what we\'re doing—being with you always turns an ordinary day into something unforgettable.'],
              ['What I Admire', 'What I admire most about you is your kind heart. You care deeply about the people around you, even when you don\'t realize it. Your strength, patience, and the way you keep moving forward inspire me every single day to become a better person.'],
              ['The Little Things', 'I love the little things you probably don\'t even notice about yourself—your smile when you\'re genuinely happy, the way you laugh at silly jokes, the way your eyes light up when you talk about something you love, and the comfort I feel just hearing your voice.'],
              ['My Safe Place',  'Life isn\'t always easy, but somehow everything feels lighter whenever you\'re with me. You give me peace without even trying. No matter how stressful my day gets, talking to you reminds me that I\'m never alone. You truly feel like my home.'],
              ['The Future Star', 'I can\'t wait for all the memories we haven\'t made yet. I dream about traveling together, celebrating milestones, chasing our goals, and growing old side by side. No matter what the future brings, I hope it\'s a future where I get to hold your hand through it all.'],
          ];

          foreach ($starMemories as $index => $memory):
          ?>
            <button
              class="memory-star star-<?= $index + 1 ?>"
              type="button"
              data-title="<?= htmlspecialchars($memory[0], ENT_QUOTES) ?>"
              data-text="<?= htmlspecialchars($memory[1], ENT_QUOTES) ?>"
              aria-label="Open <?= htmlspecialchars($memory[0]) ?>"
            ><span class="star-core" aria-hidden="true"></span><span class="star-label"><?= htmlspecialchars($memory[0]) ?></span></button>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="content-section" id="gallery">
      <div class="container">
        <h2 class="section-title">Our Memory Gallery</h2>

        <?php if ($galleryImages): ?>
          <div class="gallery-grid">
            <?php foreach ($galleryImages as $image): ?>
              <button class="gallery-item glass-card" type="button" data-image="<?= htmlspecialchars($image) ?>">
                <img src="<?= htmlspecialchars($image) ?>" alt="A memory from our relationship" loading="lazy">
              </button>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="empty-state glass-card">
            <p>No photos yet. Add JPG, PNG, WEBP, or GIF files to the gallery folder.</p>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <section class="content-section" id="reasons">
      <div class="container">
        <h2 class="section-title">Six Reasons You Feel Like Home</h2>

        <div class="reason-grid">
          <?php
          $reasons = [
              ['Your kindness', 'You care deeply, even when nobody is watching.'],
              ['Your laugh', 'It turns ordinary moments into memories I want to keep.'],
              ['Your strength', 'You keep going, even when life is not gentle with you.'],
              ['Your honesty', 'You make our relationship feel real and safe.'],
              ['Your presence', 'Everything feels better when I know you are there.'],
              ['The way you love', 'You remind me that love can be soft, brave, and peaceful.'],
          ];

          foreach ($reasons as $index => $reason):
          ?>
            <article class="reason-card glass-card">
              <span><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <h3><?= htmlspecialchars($reason[0]) ?></h3>
              <p><?= htmlspecialchars($reason[1]) ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="content-section" id="timeline">
      <div class="container">
        <h2 class="section-title">Our Story So Far</h2>

        <div class="timeline">
          <?php foreach ($timeline as $item): ?>
            <article class="timeline-item glass-card">
              <p class="timeline-date"><?= htmlspecialchars((string)($item['date'] ?? '')) ?></p>
              <h3><?= htmlspecialchars((string)($item['title'] ?? '')) ?></h3>
              <p><?= htmlspecialchars((string)($item['text'] ?? '')) ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="content-section" id="places">
      <div class="container">
        <h2 class="section-title">Places That Belong to Us</h2>

        <div class="places-grid">
          <?php foreach ($places as $place): ?>
            <article class="place-card glass-card">
              <div class="map-pin">♥</div>
              <h3><?= htmlspecialchars((string)($place['name'] ?? '')) ?></h3>
              <p><?= htmlspecialchars((string)($place['text'] ?? '')) ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="content-section" id="letter">
      <div class="container">
        <h2 class="section-title">A Letter Across the Stars</h2>

        <article class="love-letter glass-card">
          <p>My love,</p>

          <p>
            I wanted to give you something different, not something that could
            simply be wrapped, opened, and forgotten, but a small world made
            especially for you.
          </p>

          <p>
            Thank you for being part of my days, my plans, my worries, my
            laughter, and my dreams. You have become one of the most beautiful
            parts of my life, and I never want to treat that as something ordinary.
          </p>

          <p>
            I may not always have the perfect words, but I hope you always feel
            the truth behind them: I choose you, I appreciate you, and I am
            grateful that our paths found each other.
          </p>

          <p>
            Happy National Girlfriend's Day. In every version of my future,
            I hope there is still an “us.”
          </p>

          <p class="signature">
            Always yours,<br>
            <strong><?= htmlspecialchars(YOUR_NAME) ?></strong>
          </p>
        </article>
      </div>
    </section>

    <section class="content-section" id="countdowns">
      <div class="container">
        <h2 class="section-title">Our Time Together</h2>

        <div
          class="relationship-counter glass-card"
          id="relationshipCounter"
          data-start="<?= htmlspecialchars(RELATIONSHIP_START) ?>"
        >
          <div class="counter-box">
            <strong id="days">0</strong>
            <span>Days</span>
          </div>

          <div class="counter-box">
            <strong id="hours">00</strong>
            <span>Hours</span>
          </div>

          <div class="counter-box">
            <strong id="minutes">00</strong>
            <span>Minutes</span>
          </div>

          <div class="counter-box">
            <strong id="seconds">00</strong>
            <span>Seconds</span>
          </div>
        </div>

        <div class="special-countdowns">
          <article
            class="countdown-card glass-card"
            data-countdown-type="birthday"
            data-date="<?= htmlspecialchars(HER_BIRTHDAY) ?>"
          >
            <h3>Her Next Birthday</h3>
            <p class="special-countdown-value">Calculating…</p>
          </article>

          <article
            class="countdown-card glass-card"
            data-countdown-type="anniversary"
            data-date="<?= htmlspecialchars(ANNIVERSARY_MONTH_DAY) ?>"
          >
            <h3>Our Next Anniversary</h3>
            <p class="special-countdown-value">Calculating…</p>
          </article>

          <article class="countdown-card glass-card" data-countdown-type="christmas">
            <h3>Christmas Together</h3>
            <p class="special-countdown-value">Calculating…</p>
          </article>
        </div>
      </div>
    </section>

    <section class="content-section" id="open-once">
      <div class="container">
        <div class="open-once-card glass-card">
          <h2>A Message for One Special Moment</h2>
          <button class="primary-button" id="openOnceButton" type="button">
            Open the Sealed Letter
          </button>
          <div class="open-once-result" id="openOnceResult"></div>
        </div>
      </div>
    </section>

    <section class="content-section" id="reply">
      <div class="container">
        <h2 class="section-title">Leave Me a Reply</h2>

        <form class="reply-form glass-card" id="replyForm">
          <label for="replyName">Your name</label>
          <input
            id="replyName"
            name="name"
            type="text"
            maxlength="60"
            value="<?= htmlspecialchars(GIRLFRIEND_NAME) ?>"
            required
          >

          <label for="replyMessage">Your message</label>
          <textarea
            id="replyMessage"
            name="message"
            maxlength="1000"
            rows="6"
            placeholder="Write your reply here…"
            required
          ></textarea>

          <button class="primary-button" type="submit">Send My Reply ♡</button>
          <p class="form-status" id="replyStatus" aria-live="polite"></p>
        </form>

        <?php if ($messages): ?>
          <div class="message-wall">
            <?php foreach ($messages as $message): ?>
              <article class="message-card glass-card">
                <p><?= nl2br(htmlspecialchars((string)($message['message'] ?? ''))) ?></p>
                <footer>
                  <?= htmlspecialchars((string)($message['name'] ?? 'Anonymous')) ?>
                  ·
                  <?= htmlspecialchars((string)($message['created_at'] ?? '')) ?>
                </footer>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <section class="content-section" id="surprise">
      <div class="container">
        <div class="final-card glass-card">
          <p class="eyebrow center">One final surprise</p>
          <h2>You Are My Favorite Coincidence</h2>

          <button class="primary-button" id="finalSurpriseButton" type="button">
            Open the Final Gift 🎁
          </button>

          <div class="hidden-message" id="finalMessage">
            <div class="digital-bouquet" aria-hidden="true">🌹🌷🌸🌻🌺</div>
            <p>
              No matter how many stars fill the sky, there will never be another
              you. Thank you for being my person, my comfort, my chaos, and my home.
            </p>
            <p>
              <strong>
                Happy Girlfriend's Day, <?= htmlspecialchars(GIRLFRIEND_NAME) ?>. ♡
              </strong>
            </p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="page-footer">
    I love you so much my love.
  </footer>

  <div class="modal" id="memoryModal" hidden>
    <div class="modal-card glass-card">
      <h2 id="memoryModalTitle"></h2>
      <p id="memoryModalText"></p>
      <button class="secondary-button" id="closeMemoryModal" type="button">Close</button>
    </div>
  </div>

  <div class="modal" id="imageModal" hidden>
    <div class="image-modal-card">
      <img id="imageModalPreview" src="" alt="Expanded memory">
      <button class="secondary-button" id="closeImageModal" type="button">Close</button>
    </div>
  </div>

  <div class="celebration-layer" id="celebrationLayer" aria-hidden="true"></div>

  <script src="assets/js/stars.js"></script>
  <script src="assets/js/app.js"></script>
</body>
</html>
