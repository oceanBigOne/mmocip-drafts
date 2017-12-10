module.exports = function(grunt) {




    grunt.initConfig({
        pkg: grunt.file.readJSON("package.json"),
        uglify:{
            options: {
                sourceMap: true
            },
            web: {
                files: [
                    {'dist/js/vendor.min.js' : [
                        'node_modules/jquery/dist/jquery.js',
                        'node_modules/popper.js/dist/umd/popper.js',
                        'node_modules/bootstrap/dist/js/bootstrap.js',
                        'node_modules/toastr/toastr.js',
                        'vendor/kzam/kzamengine-frameworkjquery/dist/KzamFrameworkJquery.min.js'
                    ]},
                    {'dist/js/app.min.js' : [
                        'src/js/**/*.js'
                    ]}

                ]
            }

        },
        watch:{
            js: {
                files: ['src/js/**/*.js'],
                tasks: ['uglify:web']
            },
            css: {
                files: ['src/css/**/*.css'],
                tasks: ['cssmin:web']
            }

        },
        cssmin:{
            web: {
                files: [{
                    'dist/css/vendor.min.css': [
                        'vendor/fortawesome/font-awesome/css/font-awesome.css',
                        'node_modules/bootstrap/dist/css/bootstrap.css',
                        'node_modules/toastr/build/toastr.css'
                    ]
                },{
                    'dist/css/app.min.css': [
                        'src/css/**/*.css'
                    ]
                }
                ]
            }

        },
        copy: {
            web: {
                files: [{
                    flatten: true,
                    cwd: 'vendor/fortawesome/font-awesome/fonts',
                    src: ['**/*.otf', '**/*.ttf', '**/*.eot', '**/*.svg','**/*.woff','**/*.woff2'],
                    dest: 'dist/fonts',
                    expand: true
                }

                ]
            }
        },
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['uglify','cssmin','copy']);
    grunt.registerTask('watching', ['uglify','cssmin','copy','watch']);




};