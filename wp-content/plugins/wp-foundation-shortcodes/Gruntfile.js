module.exports = function(grunt) {
  // time
  require('time-grunt')(grunt);

  grunt.initConfig({

    concat: {
        options: {
          separator: ';',
        },
        dist: {
          src: [
          // Include your own custom scripts (located in the custom folder)
          'js/custom/*.js'

          ],
          // Finally, concatinate all the files above into one single file
          dest: 'js/app.js',
        },
      },

    uglify: {
      dist: {
        files: {
          // Shrink the file size by removing spaces
          'js/app.js': ['js/app.js']
        }
      }
    },

    watch: {
      js: {
        files: 'js/custom/**/*.js',
        tasks: ['concat', 'uglify'],
        options: {
          livereload:true,
        }
      },
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('js', ['concat', 'uglify']);
};
