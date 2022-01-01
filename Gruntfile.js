module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    paths: {
      src: {
        js: 'assets/js/*.js', // mind that files get combined in alphabetical order
        swcache: 'serviceworker-cache.js'
      },
      dest: {
        jsMin: 'assets/js/all.min.js',
        swcacheMin: 'serviceworker-cache.min.js'
      }
    },
    clean: {
      jsMin: '<%= paths.dest.jsMin %>',
      swcacheMin: '<%= paths.dest.swcacheMin %>'
    },
    uglify: {
      swcache: {
        options: {
          compress: true,
          mangle: true,
          sourceMap: true
        },
        src: '<%= paths.src.swcache %>',
        dest: '<%= paths.dest.swcacheMin %>'
      },
      jsassets: {
        options: {
          compress: true,
          mangle: true,
          sourceMap: true
        },
        src: '<%= paths.src.js %>',
        dest: '<%= paths.dest.jsMin %>'
      }
    }
  });

  // Load the plugin that provides the "clean" and "uglify" tasks.
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  // Default task(s).
  grunt.registerTask('default', ['clean', 'uglify']);

};