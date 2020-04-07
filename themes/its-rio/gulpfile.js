var elixir = require('laravel-elixir');
// require('laravel-elixir-stylus');
elixir.config.sourcemaps = true;

elixir(function(mix) {
	mix.cssOutput = 'assets/css';
	mix.jsOutput = 'assets/js';
	mix.sass('../../../assets/sass/its.scss','assets/css/its.css');
	mix.sass('../../../assets/sass/wp-map.scss','assets/css/wp-map.css');
	mix.browserify('../../../assets/js6/its.js','assets/js/its.js');
	mix.scripts([
		"../../../assets/js/lodash.min.js",
		"../../../assets/js/isotope.pkgd.min.js",
		"../../../assets/js/jquery.custom-scrollbar.min.js"
		],"assets/js/plugins.js");
});