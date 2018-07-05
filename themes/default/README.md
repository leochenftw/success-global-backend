# Preparation
Things to do before start cracking

---

## CSS &JS

The css & js are all handled by npm/gupl/browserify.

Make sure you instlal the required npm components

`npm install`

`bower update`

and don't forget to go to scss directory, and

`git clone git@github.com:leochenftw/bulma-scss.git`

`rm -rf bulma`

`mv bulma-scss bulma`


You will also need:

- gulp `npm install gulp -g`
- browserify `npm install browserify -g`

## Watch tasks

There are 2 watch tasks to run:

`gulp default` - watches out for scss changes.

`cd  js; ./watch-js.sh` - watches for changes to the main js file, but you don't have to do this unless you are doing JS ES6 way

You may need to install watchify and uglifyjs globally:

- https://www.npmjs.com/package/watchify
- https://www.npmjs.com/package/uglify-js
