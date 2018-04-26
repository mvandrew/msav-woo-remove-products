const gulp                  = require("gulp");
const plumber               = require('gulp-plumber');
const notify                = require('gulp-notify');
const cssnano               = require("gulp-cssnano");
const sass                  = require("gulp-sass");
const autoprefixer          = require("gulp-autoprefixer");
const gcmq                  = require('gulp-group-css-media-queries');
const uglify                = require('gulp-uglify');
const babel                 = require('gulp-babel');


/**
 * Folders structure.
 *
 * @type {{src: string, dist: string, templates: string, build: string, bower: string, node: string}}
 */
const dirs = {
    src: './assets/',
    dist: './',
    templates: './templates/',
    build: './build/',
    bower: './bower_components/',
    node: './node_modules/'
};


/**
 * Compiling JavaScript files.
 */
gulp.task('js', function() {
    return gulp.src( dirs.src + 'js/**/*.js' )
        .pipe( plumber({ errorHandler: function(err) {
                notify.onError({
                    title: "Gulp error in " + err.plugin,
                    message:  err.toString()
                })(err);
            }}) )
        .pipe( babel({
            presets: ['env']
        }) )
        .pipe( gulp.dest(dirs.templates + 'js/') )
        .pipe( notify({ message: 'JavaScript task complete', onLast: true }) );
});
