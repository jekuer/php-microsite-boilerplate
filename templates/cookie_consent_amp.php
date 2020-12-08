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
      <h2><?php echo T_('Cookies'); ?>.</h2>
      <p>
        <strong><?php echo T_('This website uses cookies'); ?>.</strong><br>
        <?php echo T_('Some cookies are required to provide core functionality. The website won\'t function properly without these cookies and they are enabled by default. Analytical cookies help to improve this website by collecting and reporting anonymized information on its usage.'); ?>
      </p>
      <p>
        <strong><?php echo T_('Please accept or reject analytical cookies'); ?>.</strong>
      </p>
      <button on="tap:myUserConsent.reject" class="ampstart-btn-small"><?php echo T_('Reject'); ?></button>
      <button on="tap:myUserConsent.accept" class="ampstart-btn"><?php echo T_('Accept'); ?></button>
    </div>
  </div>
  <div id="post-consent-ui">
    <button on="tap:myUserConsent.prompt()" class="ampstart-btn"><?php echo T_('Cookie Settings'); ?></button>
  </div>
</amp-consent>