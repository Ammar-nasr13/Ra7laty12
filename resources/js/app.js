import './bootstrap';
import { TRIPS_DATA, matchTrips, renderTripCards, filterByCategory } from './trips.js';
import { initLang, applyLang, getCurrentLang, TEXTS, t } from './lang.js';

// Expose everything on window so Blade inline scripts can use them
// without needing separate Vite entry points.
window.TRIPS_DATA       = window.__DB_TRIPS && window.__DB_TRIPS.length ? window.__DB_TRIPS : TRIPS_DATA;
window.matchTrips       = matchTrips;
window.renderTripCards  = renderTripCards;
window.filterByCategory = filterByCategory;
window.initLang         = initLang;
window.applyLang        = applyLang;
window.getCurrentLang   = getCurrentLang;
window.TEXTS            = TEXTS;
window.t                = t;

// Apply locale from server on every page load
const serverLang = document.documentElement.lang || 'ar';
initLang(serverLang);
