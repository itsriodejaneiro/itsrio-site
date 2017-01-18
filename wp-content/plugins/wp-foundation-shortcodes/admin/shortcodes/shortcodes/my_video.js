frameworkShortcodeAtts={
	attributes:[
			{
				label:"The source of your video file",
				id:"src",
				help:"Youtube, vimeo or other URL, e.g. <strong>http://player.vimeo.com/video/60122989</strong>"
			},
			{
				label:"Poster",
				id:"poster",
				help:"Defines image to show as placeholder before the media plays."
			},
			{
                                label:"Loop",
                                id:"loop",
                                controlType:"select-control",
                                selectValues:['off', 'on'],
                                defaultValue: 'off',
                                defaultText: 'off',
                                help:"Allows for the looping of media."
                        },
			{
				label:"Autoplay",
				id:"autoplay",
				controlType:"select-control",
				selectValues:['off', 'on'],
				defaultValue: 'off',
				defaultText: 'off',
				help:"Causes the media to automatically play as soon as the media file is ready."
			},
			{
                                label:"Preload",
                                id:"preload",
                                controlType:"select-control",
                                selectValues:['metadata', 'none', 'auto'],
                                defaultValue: 'metadata',
                                defaultText: 'metadata',
                                help:"Specifies if and how the video should be loaded when the page loads. \"metadata\" - only metadata should be loaded when the page loads, \"none\" - the video should not be loaded when the page loads, \"auto\" - the video should be loaded entirely when the page loads"
                        },
			{
                                label:"Width",
                                id:"width",
                                help:"Defines width of the media. Default: [Media file width]"
                        },
			{
				label:"Height",
				id:"height",
				help:"Defines height of the media. Default: [Media file height] "
			}
	],
	defaultContent:"",
	shortcode:"video"
};
