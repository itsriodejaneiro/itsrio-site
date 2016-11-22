var elixir = require('laravel-elixir');
// require('laravel-elixir-stylus');

elixir(function(mix) {
	mix.cssOutput = 'assets/css';

	mix.sass('../../../assets/sass/its.scss','assets/css/its.css');
});