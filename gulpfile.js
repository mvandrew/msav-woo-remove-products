const gulp                  = require("gulp");
const plumber               = require('gulp-plumber');
const notify                = require('gulp-notify');
const cssnano               = require("gulp-cssnano");
const sass                  = require("gulp-sass");
const autoprefixer          = require("gulp-autoprefixer");
const gcmq                  = require('gulp-group-css-media-queries');
const uglify                = require('gulp-uglify');
const babel                 = require('gulp-babel');
const del                   = require('del');
const runSequence           = require('run-sequence');
const zip                   = require('gulp-zip');


/**
 * Folders structure.
 *
 * @type {{src: string, dist: string, templates: string, build: string, bower: string, node: string}}
 */
const dirs = {
    src: './assets/',
    dist: './',
    templates: './templates/',
    build: './_build/',
    bower: './bower_components/',
    node: './node_modules/'
};


/**
 * Build files list
 */
const build_files = [
    '**',
    '!' + dirs.build,
    '!' + dirs.build + '/**',
    '!includes/messages.log',
    '!node_modules',
    '!node_modules/**',
    '!bower_components',
    '!bower_components/**',
    '!assets',
    '!assets/**',
    '!.git',
    '!.git/**',
    '!package.json',
    '!package-lock.json',
    '!bower.json',
    '!**/*.arj',
    '!**/*.rar',
    '!**/*.zip',
    '!.gitignore',
    '!gulpfile.js',
    '!LICENSE',
    '!README.md'
];


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


/**
 * Compiling SCSS files.
 */
gulp.task('sass', () => {
    return gulp.src( dirs.src + 'sass/**/*.scss' )
        .pipe( plumber({ errorHandler: function(err) {
                notify.onError({
                    title: "Gulp error in " + err.plugin,
                    message:  err.toString()
                })(err);
            }}) )
        .pipe( sass() )
        .pipe( autoprefixer(
            ['last 2 versions'],
            { cascade: false }
        ) )
        .pipe( gcmq() )
        .pipe( gulp.dest( dirs.templates + 'css/' ) )
        .pipe( notify({ message: 'Styles task complete', onLast: true }) );
});


/**
 * Default task
 */
gulp.task('watch', [
    'sass',
    'js'
], () => {

    gulp.watch( dirs.src + 'sass/**/*.scss', ['sass'] );
    gulp.watch( dirs.src + 'js/**/*.js', ['js'] );

});
gulp.task("default", ["watch"]);


/**
 * Delete the old build files.
 */
gulp.task( 'build-clean', function() {
    return del.sync( dirs.build );
});


/**
 * Copy the build files.
 */
gulp.task( 'build-copy', function() {
    return gulp.src( build_files )
        .pipe( gulp.dest( dirs.build + '/msav-woo-remove-products' ) );
} );


/**
 * Make a plugin package.
 */
gulp.task( 'build-zip', function () {
    return gulp.src( dirs.build + '/msav-woo-remove-products/**' )
        .pipe( zip('msav-woo-remove-products.zip') )
        .pipe( gulp.dest(dirs.build) );
});


/**
 * Build a plugin package.
 */
gulp.task( 'build', function() {
    return runSequence( 'build-clean', 'build-copy', 'build-zip' );
} );
