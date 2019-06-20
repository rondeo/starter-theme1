/*global module,require*/

module.exports = function (grunt) {
    "use strict";

    let thisPackage = grunt.file.readJSON('package.json');

    grunt.initConfig({
        watch: {
            scss: {
                files: ['_assets/scss/**/*.scss'],
                tasks: ['sass', 'postcss', 'bump']
            },
            js: {
                files: ['_assets/js/**/*.js'],
                tasks: ['uglify', 'bump']
            },
            livereload: {
                // Here we watch the files the sass task will compile to
                // These files are sent to the live reload server after sass compiles to them
                options: {
                    livereload: true,
                    host: 'testing-site.local', // ** REPLACE THIS WITH YOUR LOCAL ENVIRONMENT URL
                    port: 4006,
                },
                files: ['dist/*']
            }
        },
        postcss: {
            main: {
                src: 'style.css',
                options: {
                    map: true,
                    processors: [
                        require('autoprefixer')({ grid: true, browsers: ['>1%'] }),
                        require('cssnano')({zindex: false, reduceIdents: false, discardComments: {removeAllButFirst: true}})
                    ]
                },
            },
            sections: {
                src: 'dist/css/*.css',
                options: {
                    map: true,
                    processors: [
                        require('autoprefixer')({ grid: true, browsers: ['>1%'] }),
                        require('cssnano')({zindex: false, reduceIdents: false, discardComments: {removeAllButFirst: true}})
                    ]
                },
            },
        },
        sass: {            
            global: {
                options: {
                    sourceMap: true,
                    style: 'expanded'
                },
                files: [{
                    expand: true,
                    cwd: '_assets/scss',
                    src: ['*.scss'],
                    dest: '',
                    ext: '.css'
                }]
            },
        },
        bump: {
            options: {
                files: ['package.json'],
                updateConfigs: [],
                commit: false,
                createTag: false,
                push: false,
                globalReplace: false,
                prereleaseName: false,
                metadata: '',
                regExp: false
            }
        },
        svgstore: {
            options: {
                svg: {
                    xmlns: 'http://www.w3.org/2000/svg',
                    width: 0,
                    height: 0
                }
            },
            general: {
                files: {
                    'dist/images/icons.svg': ['_assets/icons/general/*.svg'],
                },
                options: {
                    prefix : 'icon--general__'
                }
            },
        },
        uglify: {
            options: {
                compress: true,
                sourceMap: true,           
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: '_assets/js',
                    src: ['*.js'],
                    dest: 'dist/js',
                    ext: '.min.js'
                }]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-cachebuster');
    grunt.loadNpmTasks('grunt-bump');
    grunt.loadNpmTasks('grunt-svgstore');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    //grunt.loadNpmTasks('grunt-contrib-copy');
    
    grunt.registerTask('default', ['watch']);
    grunt.registerTask('compile', ['sass', 'postcss', 'uglify', 'svgstore', 'bump']);    

};
