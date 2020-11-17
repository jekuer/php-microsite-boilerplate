<div class="area1">

  <?php if ($amp) { // For the AMP-Version, we need another markup here! ?>
  <amp-img src="/assets/images/box_open.svg" alt="PHP Microsite Boilerplate" width="200" height="200"  class="box_icon"></amp-img>
  <h1>PHP Microsite Boilerplate</h1>
  <a href="https://github.com/jekuer/php-microsite-boilerplate" rel="noopener"><span class="button">Zum Code-Repository &#8250;</span></a>
  <?php } else { ?>
  <div id="box_closed">
    <img src="/assets/images/box.svg" class="box_icon" alt="PHP Microsite Boilerplate">
    <h1>PHP Microsite Boilerplate</h1>
    <span class="button" id="open_box">&Ouml;ffne die Box!</span>
  </div>
  <div id="box_opened">
    <img src="/assets/images/box_open.svg" class="box_icon" alt="PHP Microsite Boilerplate">
    <h1>Genial. Du rockst!</h1>
    <a href="https://github.com/jekuer/php-microsite-boilerplate" rel="noopener"><span class="button">Ab zum Repository &#8250;</span></a>
    <div id="close_box" class="small pseudo_link"><em>Nochmal schlie&szlig;en.</em></div>
  </div>
  <?php } ?>

</div>

<div class="area2">

  <div class="container_small">

    <p><strong><em>"PHP Microsite Boilerplate"</em> ist eine Art PHP-Framework, um einfache, trotzdem hochgradig funktionale, schnelle und sichere Webseiten auf praktisch jeder Art Infrastruktur aufzusetzen.</strong></p>
    <p>Die meisten Frameworks und auch Boilerplates erfordern einen umfassenden Setup-Prozess, bei dem unz&auml;hlige weitere Tools und abhängige Module (Dependencies) installiert werden m&uuml;ssen. Dies f&uuml;hrt zu einem riesigen Overhead an Code, der nicht ben&ouml;tigt wird. All diese Komplexität erh&ouml;ht zudem das Risiko für deine Seite. Wenn du dein Werk auf einem g&uuml;nstigen Shared-Hosting-Angebot nutzen musst, scheiden zudem viele Kandidaten direkt aus.</p>
    <p><strong>Dieses Framework ist anders und das richtige für dich, wenn ...</strong></p>
    <ul>
      <li>Du eine eher kleine, aber funktionale Webseite bauen m&ouml;chtest.</li>
      <li>Du server-seitiges Scripting ben&ouml;tigst und PHP nutzen willst, da es die einzige Sprache ist, die quasi mit jeder Hosting-Option kompatibel ist.</li>
      <li>Du dein Projekt alleine oder mit max. 1 weiteren Person baust. Dies macht komplexe verteilte Code-Strukturen, obwohl eigentlich Best Practice, eher zu einem nutzlosen Overhead.</li>
      <li>Du das Ganze vor allem schnell umsetzen musst; ohne dabei Kompromisse bei Performance und Sicherheit einzugehen.</li>
    </ul>

    <div class="space50"></div>

    <h2>Key Features</h2>
    <ul>
      <li>Super einfaches Routing.</li>
      <li>F&uuml;r <a href="https://amp.dev/" target="_blank" rel="noopener" class="dark_link">Accelerated Mobile Pages (AMP)</a> vorbereitet.</li>
      <li>F&uuml;r <a href="https://web.dev/progressive-web-apps/" target="_blank" rel="noopener" class="dark_link">Progressive Web App (PWA)</a> vorbereitet.</li>
      <li>F&uuml;r Multilanguage vorbereitet.</li>
      <li><a href="https://directus.io/" target="_blank" rel="noopener" class="dark_link">Directus CMS</a> Integration (inkl. lokaler Cache).</li>
      <li>DSGVO und CCPA ready (regul&auml;re Seite und AMP).</li>
      <li>Intelligenter Serviceworker-Cache.</li>
      <li>Gettext Integration zur einfache Übersetzung von Texten (+ Fallback, falls vom Server nicht unterstützt)</li>
      <li>SEO-optimiert.</li>
      <li>Automatische Sitemap-Erzeugung.</li>
      <li>Optimiert f&uuml;r Social-Sharing.</li>
      <li>Umfassende In-Code Dokumentation.</li>
      <li><a href="https://securityheaders.com/" target="_blank" rel="noopener" class="dark_link">Security Headers</a> <span class="small">(.htaccess oder via PHP).</span></li>
      <li>Zahlreiche Security-Features <span class="small">(erfordern in Teilen einen Apache-Webserver).</span></li>
      <li>F&uuml;r automatische Git-Deployments vorbereitet.</li>
      <li>Keine externen Abh&auml;ngigkeiten.</li>
      <li>Mit dem Ziel entwickelt, Bestandteile extrem schnell entfernen, hinzuf&uuml;gen oder ver&auml;ndern zu k&ouml;nnen.</li>
    </ul>

    <div class="space50"></div>

    <h2>Let's build!</h2>
    <p>Ab zum Repository und los geht's!</p>
    <a href="https://github.com/jekuer/php-microsite-boilerplate" rel="noopener"><span class="button">Zu GitHub &#8250;</span></a>

    <div class="space25"></div>

    <h3>Lizenz</h3>
    <p>Der Quellcode unterliegt der <a href="https://www.gnu.org/licenses/gpl-3.0.html" target="_blank" rel="noopener" class="dark_link">GPU 3.0 Lizenz</a>.</p>

  </div>

</div>

<?php if (!$amp) { ?>
<div id="github_button" class="hide_on_mobile">
  <a href="https://github.com/jekuer/php-microsite-boilerplate" rel="noopener"><img src="/assets/images/github.svg" alt="Projekt auf GitHub entdecken!"></a>
</div>
<?php } ?>