      </div>
    </div>
    
    <footer class="p-8 text-sm">
      <p class="text-gray-600">
        <a class="p-4 font-normal no-underline" href="<?php echo $the_page_url_full . $pages[$language['active']]['legal-notice']['slug']; ?>/"><?php echo $pages[$language['active']]['legal-notice']['name']; ?></a>
        <a class="p-4 font-normal no-underline" href="<?php echo $the_page_url_full . $pages[$language['active']]['privacy-policy']['slug']; ?>/"><?php echo $pages[$language['active']]['privacy-policy']['name']; ?></a>
        <?php echo create_language_switcher($the_page->id); ?>
        <span class="block sm:inline-block py-4 sm:py-0 border-gray-600"><?php echo create_language_switcher($the_page->id); ?></span>
      </p>
      <p class="p-8 text-gray-500">&copy; <?php echo date('Y'); ?></p>
    </footer>

    <!-- JavaScript -->        
    <!-- Add more files, if needed, but try to consolidate it into one for better performance (when using npm to build the project, it is already all set up for that; simply throw all files into the js directory and build) -->
    <!-- Have a look at Alpine (https://github.com/alpinejs/alpine) for a minimal JavaScript framework -->
    <script src="./assets/js/all.min.js<?php echo '?v='.$version_nr; ?>"></script>
        
  </body>
</html>