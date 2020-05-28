
      <footer>
        <p>
          <?php 
          $slug = '/' . $the_page->id;
          if ($language['active'] == 'de') {
            if (isset($pages['en'][$the_page->id])) {
              if ($slug == '/main') $slug = '/';
              echo '<a class="footer_link" href="' . $slug . '">English Version</a>|';
            }
            echo '<a class="footer_link" href="/de/legal-notice">Impressum</a>|<a class="footer_link" href="/de/privacy-policy">Datenschutz</a>';
          } else {
            if (isset($pages['de'][$the_page->id])) {
              if ($slug == '/main') $slug = '';
              echo '<a class="footer_link" href="/de' . $slug . '">Deutsche Version</a>|';
            }
            echo '<a class="footer_link" href="/legal-notice">Legal Notice</a>|<a class="footer_link" href="/privacy-policy">Privacy Policy</a>'; 
          }
          ?>
        </p>
        <p class="small">Icons made by <a href="https://www.flaticon.com/authors/freepik" target="_blank" rel="noopener" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" target="_blank" rel="noopener" title="Flaticon">www.flaticon.com</a></p>
        <p>&copy; <?php echo date('Y'); ?></p>
      </footer>
    </div>

    <!-- JavaScript -->        
    <!-- Add more files, if needed, but try to consolidate it into one for better performance -->
    <script async src="./assets/js/all.min.js<?php echo '?v='.$version_nr; ?>"></script>
        
  </body>
</html>