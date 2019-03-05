/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)

require('../vendors/bootstrap/dist/css/bootstrap.min.css');
require('../vendors/font-awesome/css/font-awesome.min.css');
require('../vendors/themify-icons/css/themify-icons.css');
require('../vendors/flag-icon-css/css/flag-icon.min.css');
require('../vendors/selectFX/css/cs-skin-elastic.css');
require('../vendors/jqvmap/dist/jqvmap.min.css');

require('../css/style.css');
require('../css/custom.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

 // create global $ and jQuery variables
global.$ = global.jQuery = $;

require('../vendors/jquery/dist/jquery.min.js');
require('../vendors/popper.js/dist/umd/popper.min.js');
require('../vendors/bootstrap/dist/js/bootstrap.min.js');
require('../js/main.js');

//require('../vendors/chart.js/dist/Chart.bundle.min.js');
require('../js/dashboard.js');
require('../js/widgets.js');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
