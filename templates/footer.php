
      <footer>
      <p>
          <a class="footer_link" href="<?php echo $the_page_url_full; ?>legal-notice/"><?php echo $pages[$language['active']]['legal-notice']['name']; ?></a>
          <a class="footer_link" href="<?php echo $the_page_url_full; ?>privacy-policy/"><?php echo $pages[$language['active']]['privacy-policy']['name']; ?></a>
          <?php echo create_language_switcher($the_page->id); ?>
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