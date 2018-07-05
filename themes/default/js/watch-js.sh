#!/bin/bash
watchify main.js -o 'uglifyjs -cm > scripts.min.js'
