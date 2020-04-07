if ( typeof fcaPcPost === 'object' && fcaPcPost.video_enabled === "1" ) {

	class EventEmitter {

		constructor() {
			this.events = {}
		}

		on(event, listener) {
			if (typeof this.events[event] !== 'object') {
				this.events[event] = []
			}
			this.events[event].push(listener)
			return () => this.removeListener(event, listener)
		}

		removeListener(event, listener) {
			if (typeof this.events[event] === 'object') {
				const idx = this.events[event].indexOf(listener)
				if (idx > -1) {
					this.events[event].splice(idx, 1)
				}
			}
		}

		emit(event, ...args) {
			if (typeof this.events[event] === 'object') {
				this.events[event].forEach(listener => listener.apply(this, args))
			}
		}

		once(event, listener) {
			const remove = this.on(event, (...args) => {
				remove()
				listener.apply(this, args)
			})
		}
	}

	class FCA_PC_Video extends EventEmitter {

		constructor(selector) {
			super()

			this.video_ready = false

			if (typeof selector === undefined) {
				return
			}

			this.element = selector
			this.init()

		}

		init() {
			
			this.setup_events()
			this.type = this.video_type()
			this.load_api()
		}

		load_api() {
			switch (this.type) {
				case 'YOUTUBE':
					this.api_youtube_load()
					break
				case 'WISTIA':
					this.api_wistia_load()
					break
				case 'VIMEO':
					this.api_vimeo_load()
					break
			}
		}

		setup_events() {
			this.on( 'api_youtube_loaded', this.api_youtube_setup )
			this.on( 'api_vimeo_loaded', this.api_vimeo_setup )
			this.on( 'api_wistia_loaded', this.api_wistia_setup )
		}

		video_type() {
			let src = this.element.attr('src')

			if (src === '') {
				this.revoke( 'pixel cat video: video link not found.' )
				return false
			}

			if (src.indexOf('youtube.com') > -1) return 'YOUTUBE'
			if (src.indexOf('vimeo.com') > -1) return 'VIMEO'
			if (src.indexOf('fast.wistia.com') > -1) return 'WISTIA'
		}

		revoke( message ) {
			if ( fcaPcDebug.debug ) {
				console.log( message )
				console.log( 'pixel cat video: revoked ')
			}
			// Do some code that revoke video JS here.
		}

		//VIMEO

		api_vimeo_load() {
			jQuery.getScript( 'https://player.vimeo.com/api/player.js', () => {
				this.emit( 'api_vimeo_loaded' )
			} )
		}

		api_vimeo_setup() {
			let player_dom = this.element[0]
			try {
				this.api = new Vimeo.Player(player_dom)
				this.api.ready().then( () => {
					this.api_vimeo_ready()
				} )
			} catch ( e ) {
				if ( fcaPcDebug.debug)
					console.log( e.message )
				return
			}
		}

		api_vimeo_ready() {
			if (fcaPcDebug.debug) {
				console.log( 'Pixel Cat video: Vimeo video ready' )
			}

			this.video_ready = true

			this.api.getVideoId().then( id => {
				this.video_id = id
			} )

			this.api.getVideoTitle().then( title => {
				this.title = title
			} )

			this.api.getVideoUrl().then( url => {
				this.url = url
			} )

			this.api.getDuration().then( duration => {
				this.duration = duration
			} )

			this.events_triggered = {}

			this.api_vimeo_state_change()
		}

		api_vimeo_state_change() {
			this.api.on( 'play', event => {
				this.trigger_event( 'VideoPlay' )
				this.timer = setInterval( this.track_progress.bind(this), 1000 )
			} )

			this.api.on( 'pause', event => {
				this.trigger_event( 'VideoPause', { percentage_watched: this.percentage_watched() + '%' } )
				clearInterval( this.timer )
			} )

			this.api.on( 'ended', event => {
				this.trigger_event( 'VideoWatchToEnd' )
				clearInterval( this.timer )
			} )
		}

		//WISTIA

		api_wistia_load() {
			jQuery.getScript( '//fast.wistia.net/assets/external/E-v1.js', () => {
				this.emit( 'api_wistia_loaded' )
			} )
		}

		api_wistia_setup() {

			let player_dom = this.element

			let video_src = player_dom.attr('src')

			if (typeof video_src === 'undefined') {
				return
			}

			//GET VIDEO ID FROM URL

			const pattern = /(https:\/\/fast\.wistia\.com\/embed\/medias)\/(.*)\.jsonp/

			let match = video_src.match(pattern)

			console.log(match)

			if (match === null) {

				if (fcaPcDebug) {
					console.log('no video id match')
				}

				return
			}

			this.url = match[1]

			let video_id = match[2]

			if ( typeof video_id === 'undefined' ) {
				if ( fcaPcDebug.debug ) {
					console.log ( 'pixel cat video: wistia video_id not found.' )
				}
				return
			}

			window._wq = window._wq || []

			this.api = window._wq

			this.api.push( {
				id: video_id,
				onReady: this.api_wistia_ready.bind(this)
			} )
		}

		api_wistia_ready( video ) {

			if ( fcaPcDebug.debug ) {
				console.log ( 'pixel cat video: wistia video ready.' )
			}

			this.video_ready = true
			this.api = video

			this.video_id = video.data.media.hashedId
			this.title = video.data.media.name !== undefined ? video.data.media.name : 'Untitled'
			this.url = this.url + '/' + this.video_id
			this.events_triggered = {}
			this.api_wistia_state_change.bind(this)()
		}

		api_wistia_state_change() {
			this.api.bind( 'play', event => {
				this.trigger_event( 'VideoPlay' )
			} )

			this.api.bind( 'pause', event => {
				this.trigger_event( 'VideoPause', { percentage_watched: this.percentage_watched() + '%' } )
			} )

			this.api.bind( 'percentwatchedchanged', ( percent, lastPercent ) => {
				this.track_progress()
			} )

			this.api.bind( 'end', event => {
				this.trigger_event( 'VideoWatchToEnd' )
			} )
		}

		//YOUTUBE

		api_youtube_load() {
			this.load_async_script( 'https://www.youtube.com/iframe_api' )
		}

		api_youtube_setup() {
			let player_dom = this.element[0]
			this.api = new YT.Player(player_dom, {
				events: {
					'onReady': this.api_youtube_ready.bind(this),
					'onStateChange': this.api_youtube_state_change.bind(this)
				}
			})
		}

		api_youtube_ready( event ) {

			if ( fcaPcDebug.debug ) {
				console.log( 'pixel cat video: youtube video ready')
			}

			// @todo: we will need to build this one in future to make sure the video is ready to use the object
			this.video_ready = true
			this.data = this.api.getVideoData()
			this.video_id = this.data.video_id
			this.title = this.data.title
			this.url = this.api.getVideoUrl()

			this.events_triggered = {}
		}

		api_youtube_state_change( event ) {
			if ( fcaPcDebug.debug ) {
				console.log( event )
			}

			switch ( event.data ) {
				case 0:
					// end video
					this.trigger_event( 'VideoWatchToEnd' )
					clearInterval( this.timer )
					break

				case 1:
					// play video
					this.trigger_event( 'VideoPlay' )
					// Since we check progress using range: ( percent >= 10 && percent < 25 )
					// So we do not need to set interval too fast. 1 - 2 seconds should be fine
					this.timer = setInterval( this.track_progress.bind(this), 1000 )
					break

				case 2:
					// pause video
					this.trigger_event( 'VideoPause',  { percentage_watched: this.percentage_watched() + '%' } )
					clearInterval( this.timer )
					break
			}
		}

		video_youtube_end() {
			if ( fcaPcDebug ) {
				console.log( 'end' )
			}
		}

		load_async_script( url ) {
			let new_script = document.createElement('script')
			let first_script = document.getElementsByTagName('script')[0]
		
			new_script.src = url

	        first_script.parentNode.insertBefore(new_script, first_script)

			if ( fcaPcDebug.debug ) {
				console.log('pixel cat video: ' + url + ' has been loaded.')
			}
		}

		track_progress() {
			switch( this.video_type() ) {
				case 'YOUTUBE':
				case 'VIMEO':
				case 'WISTIA':
					this.video_track_progress()
					break

				// Other cases
			}
		}

		video_track_progress() {
			let percent = this.percentage_watched()

			if ( fcaPcDebug.debug ) {
				console.log( this.percentage_watched() )
			}

			// Need to cover all the cases and reduce interval time -> better performance
			// Use switch here for better code readable
			switch ( true ) {
				// 10% milestone
				case ( percent >= 10 && percent < 25 ):
					this.trigger_event('VideoWatch10Percent')
					break

				// 25% milestone
				case ( percent >= 25 && percent < 50 ):
					this.trigger_event('VideoWatch25Percent')
					break

				case ( percent >= 50 && percent < 75 ):
					this.trigger_event('VideoWatch50Percent')
					break

				case ( percent >= 75 && percent < 90 ):
					this.trigger_event('VideoWatch75Percent')
					break

				case ( percent >= 90 && percent < 100 ):
					this.trigger_event('VideoWatch90Percent')
					break
			}
		}

		video_params() {
			return {
				video_title: this.title,
				video_url: this.url,
				video_id: this.video_id
			}
		}

		percentage_watched() {
			switch( this.type ) {
				case 'YOUTUBE':
					return  Math.round( this.api.getCurrentTime() / this.api.getDuration() * 100 )
				
				case 'VIMEO':
					this.api.getCurrentTime().then( current_time => {
						this.current_time = current_time
					} )
					return  Math.round( this.current_time / this.duration * 100 )
					
				case 'WISTIA':
					return Math.round( this.api.time() / this.api.duration() * 100 )

				default:
					return false
			}
		}

		trigger_event( action, additional_params = {} ) {

			if ( this.events_triggered[action] ) { 
				return
			}

			let params = Object.assign( {}, this.video_params(), additional_params )

			this.emit( 'pixel_event', 'trackCustom', action, params )

			// Add exception for VideoPause event
			if (  action !== 'VideoPause' ) {
				this.events_triggered[action] = true
			}
		}


	}

	FCA_PC_Video.prototype.__proto__ = EventEmitter.prototype;

	function onYouTubeIframeAPIReady() {

		fcaPcVideos.forEach(video => {
			if (video.type !== 'YOUTUBE') {
				return
			}

			video.emit('api_youtube_loaded')	
		})
		
	}

	window.fcaPcVideos = [];

	// detect all videos on the page
	function detect_videos() {

		let videos = [];

		jQuery( 'iframe' ).each(function () {
			videos.push(jQuery(this))
		})

		jQuery( 'script' ).each(function () {

			let src = jQuery(this).attr('src')

			if (typeof src === 'undefined') {
				return
			}

			if (src.indexOf('https://fast.wistia.com/embed/medias/') === -1) {
				return
			}

			videos.push(jQuery(this))

		})

		if (videos.length === 0) {

			if (fcaPcDebug) {
				console.log('No videos detected')	
			}

			return
		}

		videos.forEach(function (video) {
			window.fcaPcVideos.push(new FCA_PC_Video(video))
		})

		
	}


	detect_videos()
	
}
