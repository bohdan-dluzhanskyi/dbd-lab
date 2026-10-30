"use strict";

const
    jsWatch = [
        './assets/js/app.js'
    ],
    jsFiles = [
        './assets/js/app.js' 
    ],
    cssWatch = [
        './assets/scss/**/*.scss', 
    ],
    cssFiles = [
        './assets/scss/app.scss',
    ];

const gulp = require('gulp');
const { src, dest, watch, series, parallel } = gulp;

const
    sourcemaps = require('gulp-sourcemaps'),
    sass = require('gulp-sass')(require('sass')),
    babel = require('gulp-babel'),
    terser = require('gulp-terser'),      
    postcss = require('gulp-postcss'),     
    autoprefixer = require('autoprefixer'), 
    cssnano = require('cssnano'),           
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename');


function scssTask() {
    return src(cssFiles)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([
            autoprefixer(), 
            cssnano({
                preset: ['default', {
                    discardComments: { removeAll: false } 
                }]
            })       
        ]))
        .pipe(rename('style.css')) 
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./')); 
}


function jsTask() {
    return src(jsFiles)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: [['@babel/preset-env']]
        }))
        .pipe(terser()) 
        .pipe(rename('app.min.js'))
        .pipe(sourcemaps.write('.')) 
        .pipe(dest('./assets/js/'));
}


function watchTask() {
    watch(cssWatch, scssTask);
    watch(jsWatch, jsTask);
}


exports.default = series(
    parallel(scssTask, jsTask),
    watchTask
);
