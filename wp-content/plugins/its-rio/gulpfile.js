var elixir = require('laravel-elixir');

elixir(function(mix) {
	mix.cssOutput = 'assets/css';


	mix.sass('its.scss');
});