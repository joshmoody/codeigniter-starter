#!/usr/env sh

# Compile our .less files and minify
lessc -x assets/css/less/style.less assets/css/style.min.css
lessc -x assets/themes/moody/less/style.less assets/themes/moody/style.min.css