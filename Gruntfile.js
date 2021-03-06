module.exports = function (grunt) {
    // Project configuration.
    grunt.initConfig({
        modx: grunt.file.readJSON('_build/config.json'),
        sshconfig: grunt.file.readJSON('/Users/jako/Documents/MODx/partout.json'),
        banner: '/*!\n' +
        ' * <%= modx.name %> - <%= modx.description %>\n' +
        ' * Version: <%= modx.version %>\n' +
        ' * Build date: <%= grunt.template.today("yyyy-mm-dd") %>\n' +
        ' */\n',
        usebanner: {
            css: {
                options: {
                    position: 'top',
                    banner: '<%= banner %>'
                },
                files: {
                    src: [
                        'assets/components/glossary/css/mgr/glossary.min.css'
                    ]
                }
            },
            js: {
                options: {
                    position: 'top',
                    banner: '<%= banner %>'
                },
                files: {
                    src: [
                        'assets/components/glossary/js/mgr/glossary.min.js'
                    ]
                }
            }
        },
        uglify: {
            mgr: {
                src: [
                    'source/js/mgr/glossary.js',
                    'source/js/mgr/widgets/home.panel.js',
                    'source/js/mgr/widgets/terms.grid.js',
                    'source/js/mgr/sections/home.js'
                ],
                dest: 'assets/components/glossary/js/mgr/glossary.min.js'
            }
        },
        sass: {
            options: {
                outputStyle: 'expanded',
                sourcemap: false
            },
            dist: {
                files: {
                    'source/css/mgr/glossary.css': 'source/sass/mgr/glossary.scss'
                }
            }
        },
        postcss: {
            options: {
                processors: [
                    require('pixrem')(),
                    require('autoprefixer')({
                        browsers: 'last 2 versions, ie >= 8'
                    })
                ]
            },
            dist: {
                src: [
                    'source/css/mgr/glossary.css'
                ]
            }
        },
        cssmin: {
            glossary: {
                src: [
                    'source/css/mgr/glossary.css'
                ],
                dest: 'assets/components/glossary/css/mgr/glossary.min.css'
            }
        },
        sftp: {
            css: {
                files: {
                    "./": [
                        'assets/components/glossary/css/mgr/glossary.min.css'
                    ]
                },
                options: {
                    path: '<%= sshconfig.hostpath %>develop/glossary/',
                    srcBasePath: 'develop/glossary/',
                    host: '<%= sshconfig.host %>',
                    username: '<%= sshconfig.username %>',
                    privateKey: '<%= sshconfig.privateKey %>',
                    passphrase: '<%= sshconfig.passphrase %>',
                    showProgress: true
                }
            },
            js: {
                files: {
                    "./": [
                        'assets/components/glossary/js/mgr/glossary.min.js'
                    ]
                },
                options: {
                    path: '<%= sshconfig.hostpath %>develop/glossary/',
                    srcBasePath: 'develop/glossary/',
                    host: '<%= sshconfig.host %>',
                    username: '<%= sshconfig.username %>',
                    privateKey: '<%= sshconfig.privateKey %>',
                    passphrase: '<%= sshconfig.passphrase %>',
                    showProgress: true
                }
            }
        },
        watch: {
            scripts: {
                files: ['source/**/*.js'],
                tasks: ['uglify', 'usebanner:js', 'sftp:js']
            },
            css: {
                files: ['source/**/*.scss'],
                tasks: ['sass', 'postcss', 'cssmin', 'usebanner:css', 'sftp:css']
            }
        },
        bump: {
            copyright: {
                files: [{
                    src: 'core/components/glossary/model/glossary/glossary.class.php',
                    dest: 'core/components/glossary/model/glossary/glossary.class.php'
                }],
                options: {
                    replacements: [{
                        pattern: /Copyright 2012(-\d{4})? by/g,
                        replacement: 'Copyright ' + (new Date().getFullYear() > 2012 ? '2012-' : '') + new Date().getFullYear() + ' by'
                    }]
                }
            },
            version: {
                files: [{
                    src: 'core/components/glossary/model/glossary/glossary.class.php',
                    dest: 'core/components/glossary/model/glossary/glossary.class.php'
                }],
                options: {
                    replacements: [{
                        pattern: /version = '\d+.\d+.\d+[-a-z0-9]*'/ig,
                        replacement: 'version = \'' + '<%= modx.version %>' + '\''
                    }]
                }
            }
        }
    });

    //load the packages
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-banner');
    grunt.loadNpmTasks('grunt-ssh');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-string-replace');
    grunt.renameTask('string-replace', 'bump');

    //register the task
    grunt.registerTask('default', ['bump', 'uglify', 'sass', 'postcss', 'cssmin', 'usebanner', 'sftp']);
};