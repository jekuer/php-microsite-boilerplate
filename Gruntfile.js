module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    paths: {
      src: {
        js: 'assets/js/*.js'
      },
      dest: {
        jsMin: 'assets/js/all.min.js'
      }
    },
    clean: {
      jsMin: '<%= paths.dest.jsMin %>'
    },
    uglify: {
      options: {
        compress: true,
        mangle: true,
        sourceMap: true
      },
      target: {
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