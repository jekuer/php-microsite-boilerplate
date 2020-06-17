<div class="area1">

  <?php if ($amp) { // For the AMP-Version, we need another markup here! ?>
  <amp-img src="/assets/images/box_open.svg" alt="PHP Microsite Boilerplate" width="200" height="200"  class="box_icon"></amp-img>
  <h1>PHP Microsite Boilerplate</h1>
  <a href="https://github.com/jekuer/php-microsite-boilerplate" rel="noopener"><span class="button">To the repository &#8250;</span></a>
  <?php } else { ?>
  <div id="box_closed">
    <img src="/assets/images/box.svg" class="box_icon" alt="PHP Microsite Boilerplate">
    <h1>PHP Microsite Boilerplate</h1>
    <span class="button" id="open_box">Open the Box!</span>
  </div>
  <div id="box_opened">
    <img src="/assets/images/box_open.svg" class="box_icon" alt="PHP Microsite Boilerplate">
    <h1>Awesome. You rock!</h1>
    <a href="https://github.com/jekuer/php-microsite-boilerplate" rel="noopener"><span class="button">Let's move to the repository &#8250;</span></a>
    <div id="close_box" class="small pseudo_link"><em>Close it again.</em></div>
  </div>
  <?php } ?>

</div>

<div class="area2">

  <div class="container_small">

    <p><strong><em>"PHP Microsite Boilerplate"</em> is a PHP framework to create simple, yet strongly functional, fast, and secure websites on basically every environment.</strong></p>
    <p>Most frameworks and even boilerplates require an exhausting setup process, where you need to install multiple dependencies. This leads to a huge overhead of code, which you often do not need. All of those complexity is also a potential risk for your website. Furthermore, it is often not possible to use most solutions, if you need to deploy it on the cheapest shared hosting plan.</p>
    <p><strong>This framework/template is different and right for you, if...</strong></p>
    <ul>
      <li>You need to build a rather small website, with some functionality.</li>
      <li>You choose PHP, because you want to do server-side scripting, while PHP is also maybe the only language, that runs on basically all hosting options.</li>
      <li>You build this thing on your own or with a maximum of 1 other person. This makes best practice, but complex code structure more of an unnecessary overhead than a helpful concept.</li>
      <li>You need to get it done fast, while you do not want to make compromises regarding security or performance.</li>
    </ul>

    <div class="space50"></div>

    <h2>Key Features</h2>
    <ul>
      <li>Easy routing.</li>
      <li><a href="https://amp.dev/" target="_blank" rel="noopener" class="dark_link">Accelerated Mobile Pages (AMP)</a> prepared.</li>
      <li><a href="https://web.dev/progressive-web-apps/" target="_blank" rel="noopener" class="dark_link">Progressive Web App (PWA)</a> prepared.</li>
      <li>Multilanguage prepared.</li>
      <li><a href="https://directus.io/" target="_blank" rel="noopener" class="dark_link">Directus CMS</a> integration.</li>
      <li>GDPR and CCPA ready (regular site and AMP).</li>
      <li>Intelligent serviceworker cache.</li>
      <li>SEO optimized.</li>
      <li>Optimized for Social sharing.</li>
      <li>Extensive in-code documentation.</li>
      <li><a href="https://securityheaders.com/" target="_blank" rel="noopener" class="dark_link">Security Headers</a> <span class="small">(.htaccess or via PHP).</span></li>
      <li>Multiple security features <span class="small">(some of them require an Apache web server).</span></li>
      <li>Prepared to run automated git deployments.</li>
      <li>No (maybe sometimes breaking) external dependencies.</li>
      <li>Developed to make it extremely easy for you to remove features or add your own things.</li>
    </ul>

    <div class="space50"></div>

    <h2>Let's build!</h2>
    <p>Got to the repository and get started!</p>
    <p><a href="https://github.com/jekuer/php-microsite-boilerplate" rel="noopener"><span class="button">Go to GitHub &#8250;</span></a></p>

    <div class="space25"></div>

    <h3>License</h3>
    <p>The code is available under the <a href="https://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank" rel="noopener" class="dark_link">GPU 3.0 license</a>.</p>

  </div>

</div>

<?php if (!$amp) { ?>
<div id="github_button" class="hide_on_mobile">
  <a href="https://github.com/jekuer/php-microsite-boilerplate" rel="noopener"><img src="/assets/images/github.svg" alt="Explore the project on GitHub!"></a>
</div>
<?php } ?>