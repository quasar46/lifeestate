"use strict";

const gulp = require("gulp");
const pug = require("gulp-pug");
const plumber = require("gulp-plumber");
const sourcemaps = require("gulp-sourcemaps");
const rename = require("gulp-rename");
const server = require("browser-sync").create();
const sass = require('gulp-sass')(require('sass'));
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const posthtml = require("gulp-posthtml");
const include = require("posthtml-include");
const del = require("del");
const imagemin = require("gulp-imagemin");
// const htmlmin = require('gulp-htmlmin');
// const csso = require("gulp-csso");
// const uglify = require('gulp-uglify-es').default;

gulp.task("pug", function () {
    return gulp.src("src/pug/*.pug")
        .pipe(pug({
            pretty: true
        }))
        .pipe(gulp.dest("build"));
})

gulp.task("css", function () {
    return gulp.src("src/scss/styles.scss")
        // .pipe(plumber())
        .pipe(sass().on("error", sass.logError))
        // .pipe(sass().on('error', function (error) {
        //     console.log(error);
        // }))
        .pipe(sourcemaps.init())

        .pipe(postcss([
            autoprefixer()
        ]))
        // .pipe(csso())
        
        .pipe(rename("style.min.css"))
        .pipe(sourcemaps.write("."))

        .pipe(gulp.dest("build/css"));
});

// gulp.task('vendor', function () {
//     return gulp.src("src/scss/vendor/*.*")
//         .pipe(gulp.dest("build/css"))
// });

gulp.task("js", function () {
    return gulp.src("src/js/*.js")
        .pipe(sourcemaps.init())
        // .pipe(uglify())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest("build/js"));
});

gulp.task("img", function () {
    return gulp.src("src/img/**/*.*")
        .pipe(imagemin([
            imagemin.gifsicle({
                interlaced: true
            }),
            // imagemin.mozjpeg({
            //     // quality: 50,
            //     quality: 20,
            //     progressive: true
            // }),
            // imagemin.optipng({
            //     // optimizationLevel: 5
            //     optimizationLevel: 2
            // }),
            imagemin.svgo({
                plugins: [{
                    removeViewBox: true
                },
                {
                    cleanupIDs: false
                }
                ]
            })
        ]))
        .pipe(gulp.dest("build/img"));
});

gulp.task("fonts", function () {
    return gulp.src([
        "src/fonts/**/*.{woff,woff2,css}",
    ], {
        base: "src"
    })
        .pipe(gulp.dest("build/"));
});

gulp.task("server", function () {
    server.init({
        server: "build/",
        notify: false,
        open: true,
        cors: true,
        ui: false
    });
    gulp.watch("src/scss/**/*.scss", gulp.series("css", "refresh"));
    gulp.watch("src/pug/**/*.pug", gulp.series("pug", "refresh"));
    gulp.watch("src/js/*.js", gulp.series("js", "refresh"));
    gulp.watch("src/img/**/*.*", gulp.series("img", "refresh"));
    gulp.watch("src/fonts/**/*.*", gulp.series("fonts", "refresh"));
});

gulp.task("refresh", function (done) {
    server.reload();
    done();
});

gulp.task("clean", function () {
    return del("build");
});

gulp.task("build", gulp.series("clean", "fonts", "css", "img", "pug", "js"));
gulp.task("start", gulp.series("build", "server"));
