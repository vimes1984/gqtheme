module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        // If you can't get source maps to work, run the following command in your terminal:
        // $ sass scss/foundation.scss:css/foundation.css --sourcemap
        // (see this link for details: http://thesassway.com/intermediate/using-source-maps-with-sass )
        sourceMap: false
      },

      dist: {
        options: {
          outputStyle: 'compressed'
        },
        files: {
          'css/foundation.css': 'scss/foundation.scss'
        }
      }
    },

    copy: {
      scripts: {
        expand: true,
        cwd: 'bower_components/foundation/js/vendor/',
        src: '**',
        flatten: 'true',
        dest: 'js/vendor/'
      },

    },

    concat: {
        options: {
          separator: ';',
        },
        dist: {
          src: [
          'js/vendor/modernizer.js',
          'js/vendor/jquery.js',
          // Foundation core
          'bower_components/foundation/js/foundation/foundation.js',

          // Pick the componenets you need in your project
          //'bower_components/foundation/js/foundation/foundation.abide.js',
          'bower_components/foundation/js/foundation/foundation.accordion.js',
          //'bower_components/foundation/js/foundation/foundation.alert.js',
          //'bower_components/foundation/js/foundation/foundation.clearing.js',
          //'bower_components/foundation/js/foundation/foundation.dropdown.js',
          'bower_components/foundation/js/foundation/foundation.equalizer.js',
          //'bower_components/foundation/js/foundation/foundation.interchange.js',
          //'bower_components/foundation/js/foundation/foundation.joyride.js',
          //'bower_components/foundation/js/foundation/foundation.magellan.js',
          'bower_components/foundation/js/foundation/foundation.offcanvas.js',
          'bower_components/foundation/js/foundation/foundation.orbit.js',
          //'bower_components/foundation/js/foundation/foundation.reveal.js',
          //'bower_components/foundation/js/foundation/foundation.slider.js',
          'bower_components/foundation/js/foundation/foundation.tab.js',
          //'bower_components/foundation/js/foundation/foundation.tooltip.js',
          'bower_components/foundation/js/foundation/foundation.topbar.js',
          'js/vendor/angular.min.js',
          'js/vendor/masonry.pkgd.min.js',
          'js/vendor/angular-isotope.min.js',
          'bower_components/jquery-zoom/jquery.zoom.min.js',
          'js/vendor/spin.js',
          'js/vendor/angular-spinner.min.js',
          'js/vendor/angular.rangeSlider.js',
          'js/vendor/img-src-ondemand.js',
          //This is version 2.0 the css has been moved to _settings.scss
          'js/vendor/owl.carousel.min.js',
          //woo stuff
          'js/vendor/woo/*.js',


          'js/vendor/jquery.selectBox.min.js',
          'js/vendor/jquery.yith-wcwl.js',
          // Using all of your custom js files
          'js/custom/*.js'

          ],
          // Concat all the files above into one single file
          dest: 'js/foundation.js',

        },
      },

    uglify: {
      dist: {
        files: {
          // Shrink the file size by removing spaces
          //'js/foundation.js': ['js/foundation.js']
        }
      }
    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: 'scss/**/*.scss',
        tasks: ['sass']
      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('build', ['sass', 'copy', 'concat', 'uglify']);
  grunt.registerTask('default', ['watch']);
};
