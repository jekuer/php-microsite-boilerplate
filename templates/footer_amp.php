
      <footer>
        <p>
          <?php
          if ($the_page->id != 'main') $slug = $the_page->id . '/';
          if ($language['active'] == 'de') {
            if (isset($pages['en'][$the_page->id])) {
              echo '<a class="footer_link" href="/';
              if (isset($pages['en'][$the_page->id]['amp']) and $pages['en'][$the_page->id]['amp'] = true) echo 'amp/';
              echo $slug . '">English Version</a>|';
            }
            echo '<a class="footer_link" href="/amp/de/legal-notice/">Impressum</a>|<a class="footer_link" href="/amp/de/privacy-policy/">Datenschutz</a>|<span class="footer_link" on="tap:myUserConsent.prompt()" role="button" tabindex="-1">Cookie-Einstellungen</span>';
          } else {
            if (isset($pages['de'][$the_page->id])) {
              echo '<a class="footer_link" href="/';
              if (isset($pages['en'][$the_page->id]['amp']) and $pages['en'][$the_page->id]['amp'] = true) echo 'amp/';
              echo 'de/' . $slug . '">Deutsche Version</a>|';
            }
            echo '<a class="footer_link" href="/amp/legal-notice/">Legal Notice</a>|<a class="footer_link" href="/amp/privacy-policy/">Privacy Policy</a>|<span class="footer_link" on="tap:myUserConsent.prompt()" role="button" tabindex="-1">Cookie Settings</span>'; 
          }
          ?>
        </p>
        <p class="small">Icons made by <a href="https://www.flaticon.com/authors/freepik" target="_blank" rel="noopener" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" target="_blank" rel="noopener" title="Flaticon">www.flaticon.com</a></p>
        <p>&copy; <?php echo date('Y'); ?></p>
      </footer>
    </div>

    <!-- No JavaScript allowed for AMP pages! -->
        
  </body>
</html>