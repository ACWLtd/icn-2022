
var gulp = require('gulp'),
    browserify = require('browserify'),
    sourcemaps = require('gulp-sourcemaps'),
    source = require('vinyl-source-stream'),
    order = require("gulp-order"),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    cssnano = require('gulp-cssnano'),
    minifyCSS = require('gulp-clean-css'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    browserSync = require('browser-sync').create(),
    postcss = require('gulp-postcss'),
    merge = require('merge-stream');

    gulp.task('default', [], function () {
        gulp.start('browserify', 'styles', 'scripts' );
    });

/**
 * Browserify to Load our Dependencies
 */
gulp.task('browserify', function() {
    return browserify('./assets/js/vendor/bootstrap.js').bundle()
        .pipe(source('dependencies.js'))
        .pipe(gulp.dest('./assets/js/vendor/'));
});

/**
 * Compile / Concatenate styles
 */
gulp.task('styles', function () {
    // var sassStream = sass('./assets/css/sass/style.scss', {style: 'expanded'}),
    //     cssStream = gulp.src('./node_modules/animate.css/animate.min.css');
    // merge(cssStream, sassStream);

    return sass('./assets/css/sass/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([ autoprefixer('last 2 version')]))
        .pipe(minifyCSS({compatibility: 'ie9'}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./'))
        .pipe(browserSync.stream()) // browsers reload after tasks are complete.
        .pipe(autoprefixer('last 2 version'))
        .pipe(concat('style.css'))
        .pipe(gulp.dest('./'))
        .pipe(rename({suffix: '.min'}))
        .pipe(cssnano())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./'))
        .pipe(notify({message: 'Styles task complete'}));
});


gulp.task('css', function() {
    console.log("==> Transpiling scss, etc...");
    return gulp.src('./assets/css/sass/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer('last 2 version'))
        .pipe(minifyCSS({compatibility: 'ie8'}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./'))
        .pipe(browserSync.stream()); // browsers reload after tasks are complete.
});


/**
 * Concatenate Javascripts
 */

gulp.task('scripts', function() {
    return gulp.src(['./assets/js/vendor/dependencies.js', './assets/js/main.js'])
        .pipe(order([
            "assets/js/vendor/jquery-3.2.1.min.js",
            "node_modules/boostrap/dist/js/bootstrap.min.js",
            'assets/js/main.js'
        ]))
        .pipe(concat('app.js'))
        .pipe(gulp.dest('./'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify({
            mangle: true
        }))
        .pipe(notify({message: 'Scripts task complete'}));
});


/**
 * Watcher handlers
 */
gulp.task('watch', function () {
    gulp.watch('./assets/css/**/*.scss', ['styles']);
    gulp.watch('./assets/js/*.js', ['scripts']);

});

/**
 * Launch Browsersync and watch files
 */
gulp.task('serve', function () {
    browserSync.init({
        // server: {
        //     baseDir: "./"
        // },
        proxy: "localhost/ICN_2019/"
    });
    gulp.watch('./assets/css/**/*.scss', ['css']);
    gulp.watch('./assets/js/*.js', ['scripts']);
    gulp.watch("./*.html").on('change', browserSync.reload);
    gulp.watch("./*.php").on('change', browserSync.reload);
});