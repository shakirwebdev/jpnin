module.exports = function(grunt) {
    grunt.initConfig({
		sass: {			
            dist: {
				options: {
					outputStyle: 'compressed'
				},
                files: [{
                    'public/assets/css/main.css':              'public/assets/scss/main.scss', 	                        /* 'All main SCSS' */
                    'public/assets/css/dark.css':              'public/assets/scss/skins/dark.scss',                      /* 'Theme SCSS to css path' */
                    'public/assets/css/theme1.css':            'public/assets/scss/skins/theme1.scss',                    /* 'Theme SCSS to css path' */                    
                    'public/assets/css/theme2.css':            'public/assets/scss/skins/theme2.scss',                    /* 'Theme SCSS to css path' */
                    'public/assets/css/theme3.css':            'public/assets/scss/skins/theme3.scss',                    /* 'Theme SCSS to css path' */

                    // 'assets/css/default.css':     'assets/scss/skins/default.scss',                   /* 'Theme SCSS to css path' */
				}]
            }
        },  
        uglify: {
            my_target: {
              files: {
                    'public/assets/bundles/lib.vendor.bundle.js':   ['public/assets/plugins/jquery/jquery-3.4.1.min.js','public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js','public/assets/plugins/metisMenu/metisMenu.js','public/assets/plugins/sparkline/sparkline.js','public/assets/js/vendors/circle-progress.min.js','public/assets/plugins/listjs/list.js'], /* main js*/
                    
                    //'public/assets/bundles/mainscripts.bundle.js':  ['public/assets/js/core.js'], /*coman js*/

                    'public/assets/bundles/counterup.bundle.js':    ['public/assets/plugins/counterjs/jquery.waypoints.js', 'public/assets/plugins/counterjs/jquery.counterup.min.js'],

                    'public/assets/bundles/c3.bundle.js':           ['public/assets/plugins/charts-c3/c3.min.js', 'public/assets/plugins/charts-c3/d3.v3.min.js'],
                    'public/assets/bundles/fullcalendar.bundle.js': ['public/assets/plugins/fullcalendar/moment.min.js', 'public/assets/plugins/fullcalendar/fullcalendar.min.js'],
                    'public/assets/bundles/summernote.bundle.js':   ['public/assets/plugins/summernote/dist/summernote.js'],
                    'public/assets/bundles/sweetalert.bundle.js':   ['public/assets/plugins/sweetalert/sweetalert.min.js'],
                    'public/assets/bundles/nestable.bundle.js':     ['public/assets/plugins/nestable/jquery.nestable.js'],
                    'public/assets/bundles/markdown.bundle.js':     ['public/assets/plugins/markdown/markdown.js','assets/plugins/markdown/to-markdown.js','assets/plugins/markdown/bootstrap-markdown.js'],
                    
                    'public/assets/bundles/flot.bundle.js':         ['public/assets/plugins/flot-charts/flot.js','public/assets/plugins/flot-charts/flot.resize.js','public/assets/plugins/flot-charts/flot.pie.js','public/assets/plugins/flot-charts/flot.categories.js','public/assets/plugins/flot-charts/flot.time.js'],
                    'public/assets/bundles/knobjs.bundle.js':       ['public/assets/plugins/knobjs/knob.min.js'],
                    'public/assets/bundles/echarts.bundle.js':      ['public/assets/plugins/echart/echarts.min.js'],
                    'public/assets/bundles/apexcharts.bundle.js':   ['public/assets/plugins/apexcharts/apexcharts.min.js'],
                    
                    
                    'public/assets/bundles/jvectormap1.bundle.js':  ['public/assets/plugins/jvectormap/jvectormap-2.0.3.min.js','public/assets/plugins/jvectormap/jvectormap-world.js','public/assets/plugins/jvectormap/jvectormap-in.js','public/assets/plugins/jvectormap/jvectormap-us.js','public/assets/plugins/jvectormap/jvectormap-au.js','public/assets/plugins/jvectormap/jvectormap-uk.js'],
                    'public/assets/bundles/jvectormap2.bundle.js':  ['public/assets/js/map/jquery-jvectormap-2.0.3.min.js', 'public/assets/js/map/jquery-jvectormap-de-merc.js', 'public/assets/js/map/jquery-jvectormap-world-mill.js'],
                    
                    'public/assets/bundles/selectize.bundle.js':    ['public/assets/js/vendors/selectize.min.js'],                    
                    
                    'public/assets/bundles/dataTables.bundle.js':[
                        'public/assets/plugins/datatable/jquery.dataTables.min.js',
                        'public/assets/plugins/datatable/dataTables.bootstrap4.min.js',
                        'public/assets/plugins/datatable/buttons/dataTables.buttons.min.js',
                        'public/assets/plugins/datatable/buttons/buttons.bootstrap4.min.js',
                        'public/assets/plugins/datatable/buttons/buttons.colVis.min.js',
                        'public/assets/plugins/datatable/buttons/buttons.html5.min.js',
                        'public/assets/plugins/datatable/buttons/buttons.print.min.js'], /*chartist js*/
                  }
              }
          }                      
    });
    grunt.loadNpmTasks("grunt-sass");
    grunt.loadNpmTasks('grunt-contrib-uglify');
    
    grunt.registerTask("buildcss", ["sass"]);
    grunt.registerTask("buildjs", ["uglify"]);
};
