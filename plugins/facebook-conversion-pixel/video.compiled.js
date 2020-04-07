'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

if ((typeof fcaPcPost === 'undefined' ? 'undefined' : _typeof(fcaPcPost)) === 'object' && fcaPcPost.video_enabled === "1") {
	var onYouTubeIframeAPIReady = function onYouTubeIframeAPIReady() {

		fcaPcVideos.forEach(function (video) {
			if (video.type !== 'YOUTUBE') {
				return;
			}

			video.emit('api_youtube_loaded');
		});
	};

	// detect all videos on the page
	var detect_videos = function detect_videos() {

		var videos = [];

		jQuery('iframe').each(function () {
			videos.push(jQuery(this));
		});

		jQuery('script').each(function () {

			var src = jQuery(this).attr('src');

			if (typeof src === 'undefined') {
				return;
			}

			if (src.indexOf('https://fast.wistia.com/embed/medias/') === -1) {
				return;
			}

			videos.push(jQuery(this));
		});

		if (videos.length === 0) {

			if (fcaPcDebug) {
				console.log('No videos detected');
			}

			return;
		}

		videos.forEach(function (video) {
			window.fcaPcVideos.push(new FCA_PC_Video(video));
		});
	};

	var EventEmitter = function () {
		function EventEmitter() {
			_classCallCheck(this, EventEmitter);

			this.events = {};
		}

		_createClass(EventEmitter, [{
			key: 'on',
			value: function on(event, listener) {
				var _this = this;

				if (_typeof(this.events[event]) !== 'object') {
					this.events[event] = [];
				}
				this.events[event].push(listener);
				return function () {
					return _this.removeListener(event, listener);
				};
			}
		}, {
			key: 'removeListener',
			value: function removeListener(event, listener) {
				if (_typeof(this.events[event]) === 'object') {
					var idx = this.events[event].indexOf(listener);
					if (idx > -1) {
						this.events[event].splice(idx, 1);
					}
				}
			}
		}, {
			key: 'emit',
			value: function emit(event) {
				var _this2 = this;

				for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
					args[_key - 1] = arguments[_key];
				}

				if (_typeof(this.events[event]) === 'object') {
					this.events[event].forEach(function (listener) {
						return listener.apply(_this2, args);
					});
				}
			}
		}, {
			key: 'once',
			value: function once(event, listener) {
				var _this3 = this;

				var remove = this.on(event, function () {
					for (var _len2 = arguments.length, args = Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
						args[_key2] = arguments[_key2];
					}

					remove();
					listener.apply(_this3, args);
				});
			}
		}]);

		return EventEmitter;
	}();

	var FCA_PC_Video = function (_EventEmitter) {
		_inherits(FCA_PC_Video, _EventEmitter);

		function FCA_PC_Video(selector) {
			_classCallCheck(this, FCA_PC_Video);

			var _this4 = _possibleConstructorReturn(this, (FCA_PC_Video.__proto__ || Object.getPrototypeOf(FCA_PC_Video)).call(this));

			_this4.video_ready = false;

			if ((typeof selector === 'undefined' ? 'undefined' : _typeof(selector)) === undefined) {
				return _possibleConstructorReturn(_this4);
			}

			_this4.element = selector;
			_this4.init();

			return _this4;
		}

		_createClass(FCA_PC_Video, [{
			key: 'init',
			value: function init() {

				this.setup_events();
				this.type = this.video_type();
				this.load_api();
			}
		}, {
			key: 'load_api',
			value: function load_api() {
				switch (this.type) {
					case 'YOUTUBE':
						this.api_youtube_load();
						break;
					case 'WISTIA':
						this.api_wistia_load();
						break;
					case 'VIMEO':
						this.api_vimeo_load();
						break;
				}
			}
		}, {
			key: 'setup_events',
			value: function setup_events() {
				this.on('api_youtube_loaded', this.api_youtube_setup);
				this.on('api_vimeo_loaded', this.api_vimeo_setup);
				this.on('api_wistia_loaded', this.api_wistia_setup);
			}
		}, {
			key: 'video_type',
			value: function video_type() {
				var src = this.element.attr('src');

				if (src === '') {
					this.revoke('pixel cat video: video link not found.');
					return false;
				}

				if (src.indexOf('youtube.com') > -1) return 'YOUTUBE';
				if (src.indexOf('vimeo.com') > -1) return 'VIMEO';
				if (src.indexOf('fast.wistia.com') > -1) return 'WISTIA';
			}
		}, {
			key: 'revoke',
			value: function revoke(message) {
				if (fcaPcDebug.debug) {
					console.log(message);
					console.log('pixel cat video: revoked ');
				}
				// Do some code that revoke video JS here.
			}

			//VIMEO

		}, {
			key: 'api_vimeo_load',
			value: function api_vimeo_load() {
				var _this5 = this;

				jQuery.getScript('https://player.vimeo.com/api/player.js', function () {
					_this5.emit('api_vimeo_loaded');
				});
			}
		}, {
			key: 'api_vimeo_setup',
			value: function api_vimeo_setup() {
				var _this6 = this;

				var player_dom = this.element[0];
				try {
					this.api = new Vimeo.Player(player_dom);
					this.api.ready().then(function () {
						_this6.api_vimeo_ready();
					});
				} catch (e) {
					if (fcaPcDebug.debug) console.log(e.message);
					return;
				}
			}
		}, {
			key: 'api_vimeo_ready',
			value: function api_vimeo_ready() {
				var _this7 = this;

				if (fcaPcDebug.debug) {
					console.log('Pixel Cat video: Vimeo video ready');
				}

				this.video_ready = true;

				this.api.getVideoId().then(function (id) {
					_this7.video_id = id;
				});

				this.api.getVideoTitle().then(function (title) {
					_this7.title = title;
				});

				this.api.getVideoUrl().then(function (url) {
					_this7.url = url;
				});

				this.api.getDuration().then(function (duration) {
					_this7.duration = duration;
				});

				this.events_triggered = {};

				this.api_vimeo_state_change();
			}
		}, {
			key: 'api_vimeo_state_change',
			value: function api_vimeo_state_change() {
				var _this8 = this;

				this.api.on('play', function (event) {
					_this8.trigger_event('VideoPlay');
					_this8.timer = setInterval(_this8.track_progress.bind(_this8), 1000);
				});

				this.api.on('pause', function (event) {
					_this8.trigger_event('VideoPause', { percentage_watched: _this8.percentage_watched() + '%' });
					clearInterval(_this8.timer);
				});

				this.api.on('ended', function (event) {
					_this8.trigger_event('VideoWatchToEnd');
					clearInterval(_this8.timer);
				});
			}

			//WISTIA

		}, {
			key: 'api_wistia_load',
			value: function api_wistia_load() {
				var _this9 = this;

				jQuery.getScript('//fast.wistia.net/assets/external/E-v1.js', function () {
					_this9.emit('api_wistia_loaded');
				});
			}
		}, {
			key: 'api_wistia_setup',
			value: function api_wistia_setup() {

				var player_dom = this.element;

				var video_src = player_dom.attr('src');

				if (typeof video_src === 'undefined') {
					return;
				}

				//GET VIDEO ID FROM URL

				var pattern = /(https:\/\/fast\.wistia\.com\/embed\/medias)\/(.*)\.jsonp/;

				var match = video_src.match(pattern);

				console.log(match);

				if (match === null) {

					if (fcaPcDebug) {
						console.log('no video id match');
					}

					return;
				}

				this.url = match[1];

				var video_id = match[2];

				if (typeof video_id === 'undefined') {
					if (fcaPcDebug.debug) {
						console.log('pixel cat video: wistia video_id not found.');
					}
					return;
				}

				window._wq = window._wq || [];

				this.api = window._wq;

				this.api.push({
					id: video_id,
					onReady: this.api_wistia_ready.bind(this)
				});
			}
		}, {
			key: 'api_wistia_ready',
			value: function api_wistia_ready(video) {

				if (fcaPcDebug.debug) {
					console.log('pixel cat video: wistia video ready.');
				}

				this.video_ready = true;
				this.api = video;

				this.video_id = video.data.media.hashedId;
				this.title = video.data.media.name !== undefined ? video.data.media.name : 'Untitled';
				this.url = this.url + '/' + this.video_id;
				this.events_triggered = {};
				this.api_wistia_state_change.bind(this)();
			}
		}, {
			key: 'api_wistia_state_change',
			value: function api_wistia_state_change() {
				var _this10 = this;

				this.api.bind('play', function (event) {
					_this10.trigger_event('VideoPlay');
				});

				this.api.bind('pause', function (event) {
					_this10.trigger_event('VideoPause', { percentage_watched: _this10.percentage_watched() + '%' });
				});

				this.api.bind('percentwatchedchanged', function (percent, lastPercent) {
					_this10.track_progress();
				});

				this.api.bind('end', function (event) {
					_this10.trigger_event('VideoWatchToEnd');
				});
			}

			//YOUTUBE

		}, {
			key: 'api_youtube_load',
			value: function api_youtube_load() {
				this.load_async_script('https://www.youtube.com/iframe_api');
			}
		}, {
			key: 'api_youtube_setup',
			value: function api_youtube_setup() {
				var player_dom = this.element[0];
				this.api = new YT.Player(player_dom, {
					events: {
						'onReady': this.api_youtube_ready.bind(this),
						'onStateChange': this.api_youtube_state_change.bind(this)
					}
				});
			}
		}, {
			key: 'api_youtube_ready',
			value: function api_youtube_ready(event) {

				if (fcaPcDebug.debug) {
					console.log('pixel cat video: youtube video ready');
				}

				// @todo: we will need to build this one in future to make sure the video is ready to use the object
				this.video_ready = true;
				this.data = this.api.getVideoData();
				this.video_id = this.data.video_id;
				this.title = this.data.title;
				this.url = this.api.getVideoUrl();

				this.events_triggered = {};
			}
		}, {
			key: 'api_youtube_state_change',
			value: function api_youtube_state_change(event) {
				if (fcaPcDebug.debug) {
					console.log(event);
				}

				switch (event.data) {
					case 0:
						// end video
						this.trigger_event('VideoWatchToEnd');
						clearInterval(this.timer);
						break;

					case 1:
						// play video
						this.trigger_event('VideoPlay');
						// Since we check progress using range: ( percent >= 10 && percent < 25 )
						// So we do not need to set interval too fast. 1 - 2 seconds should be fine
						this.timer = setInterval(this.track_progress.bind(this), 1000);
						break;

					case 2:
						// pause video
						this.trigger_event('VideoPause', { percentage_watched: this.percentage_watched() + '%' });
						clearInterval(this.timer);
						break;
				}
			}
		}, {
			key: 'video_youtube_end',
			value: function video_youtube_end() {
				if (fcaPcDebug) {
					console.log('end');
				}
			}
		}, {
			key: 'load_async_script',
			value: function load_async_script(url) {
				var new_script = document.createElement('script');
				var first_script = document.getElementsByTagName('script')[0];

				new_script.src = url;

				first_script.parentNode.insertBefore(new_script, first_script);

				if (fcaPcDebug.debug) {
					console.log('pixel cat video: ' + url + ' has been loaded.');
				}
			}
		}, {
			key: 'track_progress',
			value: function track_progress() {
				switch (this.video_type()) {
					case 'YOUTUBE':
					case 'VIMEO':
					case 'WISTIA':
						this.video_track_progress();
						break;

					// Other cases
				}
			}
		}, {
			key: 'video_track_progress',
			value: function video_track_progress() {
				var percent = this.percentage_watched();

				if (fcaPcDebug.debug) {
					console.log(this.percentage_watched());
				}

				// Need to cover all the cases and reduce interval time -> better performance
				// Use switch here for better code readable
				switch (true) {
					// 10% milestone
					case percent >= 10 && percent < 25:
						this.trigger_event('VideoWatch10Percent');
						break;

					// 25% milestone
					case percent >= 25 && percent < 50:
						this.trigger_event('VideoWatch25Percent');
						break;

					case percent >= 50 && percent < 75:
						this.trigger_event('VideoWatch50Percent');
						break;

					case percent >= 75 && percent < 90:
						this.trigger_event('VideoWatch75Percent');
						break;

					case percent >= 90 && percent < 100:
						this.trigger_event('VideoWatch90Percent');
						break;
				}
			}
		}, {
			key: 'video_params',
			value: function video_params() {
				return {
					video_title: this.title,
					video_url: this.url,
					video_id: this.video_id
				};
			}
		}, {
			key: 'percentage_watched',
			value: function percentage_watched() {
				var _this11 = this;

				switch (this.type) {
					case 'YOUTUBE':
						return Math.round(this.api.getCurrentTime() / this.api.getDuration() * 100);

					case 'VIMEO':
						this.api.getCurrentTime().then(function (current_time) {
							_this11.current_time = current_time;
						});
						return Math.round(this.current_time / this.duration * 100);

					case 'WISTIA':
						return Math.round(this.api.time() / this.api.duration() * 100);

					default:
						return false;
				}
			}
		}, {
			key: 'trigger_event',
			value: function trigger_event(action) {
				var additional_params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};


				if (this.events_triggered[action]) {
					return;
				}

				var params = Object.assign({}, this.video_params(), additional_params);

				this.emit('pixel_event', 'trackCustom', action, params);

				// Add exception for VideoPause event
				if (action !== 'VideoPause') {
					this.events_triggered[action] = true;
				}
			}
		}]);

		return FCA_PC_Video;
	}(EventEmitter);

	FCA_PC_Video.prototype.__proto__ = EventEmitter.prototype;

	window.fcaPcVideos = [];

	detect_videos();
}
