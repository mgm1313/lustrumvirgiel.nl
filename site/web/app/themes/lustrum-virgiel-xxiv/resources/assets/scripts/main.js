// import external dependencies
import 'jquery';
import 'tilt.js/dest/tilt.jquery.js';
import 'lettering.js';
import 'jquery-lazy';
import 'FitVids/jquery.fitvids';

// Import everything from autoload
import "./autoload/**/*"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';

/** Populate Router instance with DOM routes */
const routes = new Router({
    // All pages
    common,
    // Home page
    home,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());

