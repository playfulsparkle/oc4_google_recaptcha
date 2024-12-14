<?php
// Heading
$_['heading_title']                    = 'Playful Sparkle - Google reCAPTCHA';
$_['heading_fix']                      = 'Gyakori hibák javítása';
$_['heading_getting_started']          = 'Kezdő lépések';
$_['heading_setup']                    = 'Google reCAPTCHA beállítása';
$_['heading_troubleshot']              = 'Gyakori hibakeresési lépések';
$_['heading_faq']                      = 'GYIK';
$_['heading_contact']                  = 'Terméktámogatás';
$_['heading_v3_score_threshold']       = 'Pontosító küszöbérték';

// Text
$_['text_extension']                   = 'Bővítmények';
$_['text_success']                     = 'Siker: Sikeresen módosította a Google reCAPTCHA beállításait!';
$_['text_edit']                        = 'Google reCAPTCHA szerkesztése';
$_['text_signup']                      = 'Látogasson el a <a href="https://www.google.com/recaptcha/intro/index.html" target="_blank" rel="noopener noreferrer">Google reCAPTCHA oldalára</a>, és regisztrálja weboldalát.';
$_['text_getting_started']             = '<p><strong>Áttekintés:</strong> A Playful Sparkle - Google reCAPTCHA egy fejlett bővítmény az OpenCart 4 számára, amely segít megvédeni webáruházát a spam-től és visszaélésektől. Támogatja a Google reCAPTCHA különböző megvalósításait, beleértve a Pontszám alapú (v3), jelölőnégyzetes (v2) és láthatatlan (v2) változatokat, ezzel rugalmasságot és fokozott biztonságot biztosítva webáruházának.</p><p><strong>Elvárások:</strong> OpenCart 4.x+, PHP 7.4+ vagy magasabb verzió szükséges.</p>';
$_['text_setup']                       = '<ul><li><strong>1. lépés:</strong> Szerezze meg reCAPTCHA Site Key-jét és Secret Key-jét a <a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="noopener noreferrer">Google reCAPTCHA admin konzoljában</a>.</li><li><strong>2. lépés:</strong> Az OpenCart admin felületén lépjen a bővítmény beállításokhoz, és válassza ki a használni kívánt reCAPTCHA megvalósítást (Pontszám alapú v3, jelölőnégyzetes v2, vagy láthatatlan v2).</li><li><strong>3. lépés:</strong> Testreszabhatja a beállításokat a kiválasztott megvalósítás szerint:<ul><li>Pontszám alapú (v3): Állítsa be a badge elhelyezését (bal alsó, jobb alsó vagy inline). Inline esetén válassza a világos vagy sötét témát, vagy rejtheti el a badge-t (lábjegyzet a Google szabályainak való megfelelés érdekében).</li><li>Kihívás (v2) Jelölőnégyzet: Állítsa be a badge témáját (világos vagy sötét) és méretét (normál vagy kompakt).</li><li>Kihívás (v2) Láthatatlan: Állítsa be a badge elhelyezését (bal alsó, jobb alsó vagy inline). Inline esetén válassza a világos vagy sötét témát.</li></ul></li><li><strong>4. lépés:</strong> Konfigurálja a reCAPTCHA-t a kívánt oldalakhoz az OpenCart beállítások oldalán.</li></ul>';
$_['text_troubleshot']                 = '<ul><li><strong>Probléma:</strong> A reCAPTCHA nem jelenik meg. <strong>Megoldás:</strong> Ellenőrizze, hogy a megfelelő Site Key-t és Secret Key-t adta-e meg, és győződjön meg róla, hogy a domain neve regisztrálva van a Google reCAPTCHA admin konzoljában.</li><li><strong>Probléma:</strong> Hiba jelentkezik a validálás során. <strong>Megoldás:</strong> Ellenőrizze, hogy a kulcspárok megfelelnek-e a választott reCAPTCHA megvalósításnak (pl. v2 jelölőnégyzetes kulcsok nem használhatóak v3 esetén).</li><li><strong>Probléma:</strong> A badge testreszabása nem a vártak szerint jelenik meg. <strong>Megoldás:</strong> Ellenőrizze a badge konfigurációs beállításokat (pl. elhelyezés, téma vagy méret).</li></ul>';
$_['text_faq']                         = '<details><summary>Melyik reCAPTCHA megvalósítást válasszam?</summary> A választás attól függ, mire van szüksége:<ul><li><strong>Pontszám alapú (v3):</strong> A legjobb folyamatos felhasználói élmény biztosításához, közvetlen interakció nélkül, hasznos a háttérbeli validálásra.</li><li><strong>Jelölőnégyzet (v2):</strong> Egyértelmű "Nem robot vagyok" jelölőnégyzetet ad hozzá a látható interakcióhoz, ideális a felhasználói űrlapokhoz.</li><li><strong>Láthatatlan (v2):</strong> Háttérben végzi a validálást felhasználói interakció nélkül, ideális tisztább felületekhez, opcionális badge megjelenítéssel.</li></ul></details><details><summary>Miért kapok "Érvénytelen webhely kulcs" hibát?</summary> Ez akkor fordul elő, ha a megadott kulcsok nem felelnek meg a választott reCAPTCHA megvalósításnak. Győződjön meg róla, hogy a megfelelő kulcspárt használja a kiválasztott megoldáshoz (pl. v3 kulcsok v3-hoz, v2 jelölőnégyzetes kulcsok v2-höz stb.).</details><details><summary>Hol engedélyezhetem a reCAPTCHA-t?</summary> A reCAPTCHA különböző oldalakhoz konfigurálható az OpenCart beállítások oldalán.</details>';
$_['text_contact']                     = '<p>További segítségért kérjük, lépjen kapcsolatba támogatási csapatunkkal:</p><ul><li><strong>Kapcsolat:</strong> <a href="mailto:%s">%s</a></li><li><strong>Dokumentáció:</strong> <a href="%s" target="_blank" rel="noopener noreferrer">Felhasználói dokumentáció</a></li></ul>';
$_['text_key_type_v3']                 = 'Pontszám alapú (v3) - Kérések ellenőrzése pontszám alapján';
$_['text_key_type_v2_checkbox']        = 'Kihívás (v2) - "Nem robot vagyok" jelölőnégyzet kihívás';
$_['text_key_type_v2_invisible']       = 'Kihívás (v2) - Láthatatlan reCAPTCHA badge kihívás';
$_['text_badge_inline']                = 'Inline';
$_['text_badge_bottom_left']           = 'Bal alsó';
$_['text_badge_bottom_right']          = 'Jobb alsó';
$_['text_badge_dark']                  = 'Sötét';
$_['text_badge_light']                 = 'Világos';
$_['text_badge_compact']               = 'Kompakt';
$_['text_badge_normal']                = 'Normál';
$_['text_badge_invisible']             = 'Láthatatlan';
$_['text_csp_info']                    = 'Győződjön meg róla, hogy a Content-Security-Policy (CSP) megfelelően van beállítva, hogy működjön a Google reCAPTCHA-val. A legjobb biztonság érdekében javasoljuk a <strong>nonce-alapú megközelítést a CSP3-ban</strong>. Alternatívaként adja hozzá a <strong>script-src</strong> direktívát a <strong>https://www.google.com/recaptcha/</strong> és <strong>https://www.gstatic.com/recaptcha/</strong>, valamint a <strong>frame-src</strong> direktívát a <strong>https://www.google.com/recaptcha/</strong> és <strong>https://recaptcha.google.com/recaptcha/</strong> engedélyezéséhez. A <strong>strict-dynamic</strong> is támogatott a kompatibilis böngészőkben.';
$_['text_v3_score_threshold_register'] = 'Regisztráció';
$_['text_v3_score_threshold_guest']    = 'Vendég vásárlás';
$_['text_v3_score_threshold_review']   = 'Vélemények';
$_['text_v3_score_threshold_comment']  = 'Hozzászólás';
$_['text_v3_score_threshold_return']   = 'Visszaküldés';
$_['text_v3_score_threshold_contact']  = 'Kapcsolat';
$_['text_log_clear_success']     = 'A hibanapló sikeresen törlésre került.';

// Tab
$_['tab_general']                      = 'Általános';
$_['tab_security']                     = 'Biztonság';
$_['tab_error_log']                    = 'Hiba napló';
$_['tab_help_and_support']             = 'Segítség &amp; Támogatás';

// Entry
$_['entry_key_type']                   = 'reCAPTCHA típus';
$_['entry_site_key']                   = 'Webhely kulcs';
$_['entry_secret_key']                 = 'Titkos kulcs';
$_['entry_status']                     = 'Állapot';
$_['entry_badge_position']             = 'Badge pozíció';
$_['entry_badge_theme']                = 'Badge téma';
$_['entry_badge_size']                 = 'Badge méret';
$_['entry_hide_badge']                 = 'Badge elrejtése';
$_['entry_script_nonce']               = 'Script nonce';
$_['entry_google_captcha_nonce']       = 'Google Captcha API Script nonce';
$_['entry_css_nonce']                  = 'CSS stílus elem nonce';
$_['entry_log_filename']               = 'Érvényesítési naplófájl neve';
$_['entry_send_client_ip']             = 'Kliens IP-címének küldése';
$_['entry_enable_error_log']           = 'Hibák naplózásának engedélyezése';

// Button
$_['button_download']                  = 'Letöltés';
$_['button_clear']                     = 'Törlés';
$_['button_fix_event_handler']         = 'Eseménykezelő javítása';

// Help
$_['help_copy']                        = 'URL másolása';
$_['help_key_type']                    = 'Válassza ki a reCAPTCHA típusát ehhez a webhely kulcshoz. A webhely kulcs csak egy adott reCAPTCHA típusú webhelyhez működik. További információkért tekintse meg a <a href="https://developers.google.com/recaptcha/docs/versions" target="_blank" rel="noopener noreferrer">Webhely típusok</a> oldalt.';
$_['help_hide_badge']                  = 'Ezen lehetőség engedélyezésével teljesen elrejtheti a Google reCAPTCHA badge-t. A láblécben automatikusan megjelenik egy figyelmeztetés minden oldalon a Google irányelveinek való megfelelés érdekében. További információkért látogasson el a Google reCAPTCHA GYIK oldalának <a href="https://developers.google.com/recaptcha/docs/faq#id-like-to-hide-the-recaptcha-badge.-what-is-allowed" target="_blank" rel="noopener noreferrer">A reCAPTCHA badge elrejtését szeretném. Mi megengedett?</a> szakaszához.';
$_['help_site_key']                    = 'Használja ezt a webhely kulcsot az HTML kódban, amelyet a webhelye a felhasználóknak küld.';
$_['help_secret_key']                  = 'Használja ezt a titkos kulcsot a webhelye és a reCAPTCHA közötti kommunikációhoz.';
$_['help_v3_score_threshold']          = 'Ez a beállítás a reCAPTCHA v3 által visszaadott pontszám küszöbértékét határozza meg. A pontszám 0,0 és 1,0 között mozog, ahol a magasabb pontszám (közelebb 1,0-hoz) a jogos felhasználói interakció magasabb valószínűségét jelzi, míg az alacsonyabb pontszám (közelebb 0,0-hoz) nagyobb valószínűséget jelez arra, hogy botról van szó. Ezt a küszöbértéket módosíthatja annak érdekében, hogy az Ön által választott akciókat a pontszám alapján hajtsa végre. Alapértelmezés szerint 0,5-ös küszöbértéket használ, de ezt módosíthatja a weboldal speciális igényei szerint.';
$_['help_log_filename']                = 'Adja meg a naplófájl nevét a reCAPTCHA érvényesítési hibák tárolásához.';

// Error
$_['error_permission']                 = 'Figyelmeztetés: Nincs engedélye a Google reCAPTCHA módosításához!';
$_['error_error_log_permission']       = 'Figyelmeztetés: Nincs engedélye a hibanapló törlésére!';
$_['error_error_log_file']             = 'Figyelmeztetés: A %s fájl nem található!';
$_['error_error_log_empty']            = 'Figyelmeztetés: A %s napló fájl üres!';
$_['error_site_key']                   = 'A kulcs megadása kötelező!';
$_['error_secret_key']                 = 'A titkos kulcs megadása kötelező!';
$_['error_v3_score_threshold_value']   = 'A pontszám értékének 0 és 1 között kell lennie. Nem lehet kisebb, mint 0, és nem lehet nagyobb, mint 1.';
$_['error_log_filename']               = 'A reCAPTCHA érvényesítési hibáinak tárolásához szükséges egy naplófájl név.';
