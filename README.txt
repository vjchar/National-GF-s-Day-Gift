OUR LITTLE UNIVERSE — XAMPP PHP SETUP

1. COPY TO XAMPP
   Extract this folder to:

   C:\xampp\htdocs\girlfriend-gift-php

2. START APACHE
   Open XAMPP Control Panel and start Apache.

3. OPEN THE WEBSITE
   http://localhost/girlfriend-gift-php/

4. DEFAULT PASSWORD
   ourlove

5. PERSONALIZE
   Open config.php and change:

   GIRLFRIEND_NAME
   YOUR_NAME
   RELATIONSHIP_START
   HER_BIRTHDAY
   ANNIVERSARY_MONTH_DAY

6. CHANGE THE PASSWORD
   Create a new password hash by opening Command Prompt inside:

   C:\xampp\php

   Run:

   php -r "echo password_hash('YOUR-NEW-PASSWORD', PASSWORD_DEFAULT);"

   Copy the result and replace GIFT_PASSWORD_HASH in config.php.

7. ADD MUSIC
   Put an MP3 file here:

   assets/audio/song.mp3

8. ADD PHOTOS
   Put JPG, JPEG, PNG, WEBP, or GIF images here:

   assets/images/gallery/

   PHP automatically loads them.

9. GUESTBOOK STORAGE
   Replies are saved in:

   data/messages.json

   Make sure the data folder is writable. On normal Windows XAMPP installations,
   it should work automatically.

10. RESET THE OPEN-ONCE LETTER
    Open:

    data/open_once.json

    Replace its contents with:

    {
      "opened": false,
      "opened_at": null
    }

11. EDIT CONTENT
    Most gift text is inside index.php.

12. LOCAL PHONE TEST
    Run ipconfig in Command Prompt and find your IPv4 address.

    Example:
    http://192.168.1.25/girlfriend-gift-php/

    Both devices must be connected to the same Wi-Fi.

13. PUBLIC INTERNET DEPLOYMENT
    This version requires PHP, so GitHub Pages will not work.

    Use:
    - InfinityFree
    - Hostinger
    - Namecheap shared hosting
    - Any PHP hosting provider
    - A properly secured VPS

    Upload all files into public_html using the hosting file manager or FTP.

SECURITY NOTE
Do not expose a default XAMPP installation directly to the public internet.
Use proper PHP hosting for the public version.


MOBILE SUPPORT

The site is optimized for:
- Android Chrome
- Android Firefox
- Samsung Internet
- iPhone Safari
- iPad Safari
- iOS Chrome

Mobile notes:
- Background audio must be started by tapping the music button.
- The navigation changes into a mobile menu.
- Buttons use touch-friendly sizes.
- iPhone safe areas and notches are supported.
- Mobile browser address-bar height changes are handled with svh/dvh units.
- Forms use 16px text to prevent unwanted iPhone zooming.

Recommended test sizes:
- 360 x 800
- 390 x 844
- 412 x 915
- 430 x 932
- 768 x 1024
