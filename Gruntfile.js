//The wrapper function
module.exports = function(grunt) {

    require('load-grunt-tasks')(grunt);

    // Project configuration & task configuration
    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        pot: {
            options:{
                text_domain: 'mp-lms', // Plugin Text Domain. Produces text-domain.pot
                package_name: '<%= pkg.name %>',
                package_version: '<%= pkg.version %>',
                copyright_holder: '<%= pkg.author %>',
                dest: 'languages/', // Directory to place the pot file
                keywords: [ // WordPress l10n functions
                    '__:1',
                    '_e:1',
                    '_x:1,2c',
                    'esc_html__:1',
                    'esc_html_e:1',
                    'esc_html_x:1,2c',
                    'esc_attr__:1',
                    'esc_attr_e:1',
                    'esc_attr_x:1,2c',
                    '_ex:1,2c',
                    '_n:1,2',
                    '_nx:1,2,4c',
                    '_n_noop:1,2',
                    '_nx_noop:1,2,3c'
                ]
            },
            files:{
                src:  [ 'library/*.php' ],
                expand: true
            }
        },

        po2mo: {
            files: {
                src: 'languages/*.po',
                expand: true
            }
        },

        shell: {
            makeDocs: {
                options: {
                    stdout: true
                },
                command: 'apigen --config apigen/apigen.conf'
            }
        }

    });

    grunt.registerTask( 'default', ['pot'] );

    grunt.registerTask( 'docs', ['shell:makeDocs'] );

    grunt.registerTask( 'i18n', ['pot', 'po2mo'] );
}