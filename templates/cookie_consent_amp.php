<amp-geo layout="nodisplay">
  <script type="application/json">
    { "ISOCountryGroups": { "eu": ["unkown", "preset-eea"] } }
  </script>
</amp-geo>
<amp-consent id="myUserConsent" layout="nodisplay">
  <script type="application/json">
    {
      "consents": {
        "consent1": {
          "promptIfUnknownForGeoGroup": "eu",
          "promptUI": "consentDialog"
        }
      }
    }
  </script>
  <div class="popupOverlay" id="consentDialog">
    <div class="consentPopup">
      <div class="dismiss-button" role="button" tabindex="0" on="tap:myUserConsent.dismiss">
        [ X ]
      </div>
      <h2>Cookies.</h2>
      <?php if ($language['active'] == 'de') { ?>
        <p>
          <strong>Diese Webseite nutzt Cookies.</strong><br>
          Manche Cookies sind nötig, um die Kernfunktionalität zu gewährleisten. Diese sind automatisch aktiviert. Analytische Cookies helfen dabei, die Seite weiter zu optimieren. Hierbei werden anonymisierte Daten gesammelt und gespeichert.
        </p>
        <p>
          <strong>Bitte akzeptiere diese analytischen Cookies oder lehne sie ab.</strong>
        </p>
        <button on="tap:myUserConsent.reject" class="ampstart-btn-small">Ablehnen</button>
        <button on="tap:myUserConsent.accept" class="ampstart-btn">Akzeptieren</button>
      <?php } else { ?>
        <p>
          <strong>This website uses cookies.</strong><br>
          Some cookies are required to provide core functionality. The website won't function properly without these cookies and they are enabled by default. Analytical cookies help to improve this website by collecting and reporting anonymized information on its usage.
        </p>
        <p>
          <strong>Please accept or reject analytical cookies.</strong>
        </p>
        <button on="tap:myUserConsent.reject" class="ampstart-btn-small">Reject</button>
        <button on="tap:myUserConsent.accept" class="ampstart-btn">Accept</button>
      <?php } ?>
    </div>
  </div>
  <div id="post-consent-ui">
    <button on="tap:myUserConsent.prompt()" class="ampstart-btn">Cookie Settings</button>
  </div>
</amp-consent>