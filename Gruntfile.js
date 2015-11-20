'use strict';
module.exports = function (grunt){
    require("time-grunt")(grunt);
    require('load-grunt-tasks')(grunt);
    require("rsyncwrapper").rsync;

   //loading grunt tasks
  

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-phplint');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');

    grunt.loadNpmTasks('grunt-bower-task');
    grunt.loadNpmTasks('grunt-rsync');


 //grunt options
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
           //package options

        compass: {
          dev: {
              options: {
                  sassDir: 'assets/style/sass',
                  cssDir: 'assets/style/css',
                  fontsDir: 'assets/fonts',
                  javascriptsDir: 'assets/js',
                  imagesDir: 'assets/img',
                  force:true,
                  relativeAssets: true,
              }
            }
        },
        jshint:{
          files: ['Gruntfile.js', 'assets/js/**/*.js'],
          options: {
              globals: {
                  jQuery: true
                }
          }
        },
    phplint:{
            good: ["test/rsrc/*-good.php"],
            bad: ["test/rsrc/*-fail.php"]
    },

    htmlhint: {
        html1: {
          options: {
              'tag-pair': true
          },
          src: ['**/*.php']
        }
    },
    watch: {
      options: {
              livereload: true,
              spawn: false
            },
          scripts: {
              files: ['assets/js/**/*.js'],
              tasks: ['jshint', 'concat']
            },
            compass: {
              files: ['assets/style/sass/{,*/}*.{scss,sass}'],
              tasks: ['compass:dev']
            },
            php: {
              files: ['*.php'],
              tasks : ['phplint']
            },
            
        },
    rsync: {
        options: {
            args: ["--verbose"],
            exclude: [".git*","*.scss","node_modules",".bowerrc", "bower.json", "livereload.js", "Gruntfile.js", ".sass-cache", 'src', 'Main', 'bootstrap/grunt','bootstrap/js','bootstrap/less','bootstrap/fonts' ,'pro', 'build', 'sass','package.js', 'LICENSE' ,'package.json', 'Designs'],
            recursive: true
        },
        dist: {
            options: {
                src: "./",
                dest: "../TwitterGoogleMap_production"
            }
        },
        stage: {
            options: {
                src: "../TwitterGoogleMap_production",
                dest: "/var/www/site",
                host: "user@staging-host",
                // delete: true // Careful this option could cause data loss, read the docs!
            }
        },
        prod: {
            options: {
                src: "../TwitterGoogleMap_production",
                dest: "/var/www/site",
                host: "user@live-host",
                //delete: true // Careful this option could cause data loss, read the docs!
            }
        }
    }
  });



    //register tasks here


    grunt.registerTask('go', ['watch', 'compass:dev', 'jshint', 'phplint' ]);



    grunt.registerTask('pro', 'rsync');


}