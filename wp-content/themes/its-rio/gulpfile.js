var elixir = require('laravel-elixir');
// require('laravel-elixir-stylus');

elixir(function(mix) {
	mix.cssOutput = 'assets/css';
	mix.jsOutput = 'assets/js';
	mix.sass('../../../assets/sass/its.scss','assets/css/its.css');
	mix.sass('../../../assets/sass/wp-map.scss','assets/css/wp-map.css');
	 mix.browserify('../../../assets/js6/its.js','assets/js/its.js');
});