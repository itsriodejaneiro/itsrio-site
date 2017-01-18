frameworkShortcodeAtts={
	attributes:[
			{
                                label:"Autoplay",
                                id:"autoplay",
                                controlType:"select-control",
                                selectValues:['no', 'yes'],
                                defaultValue: 'no',
                                defaultText: 'no',
                                help:"Enables auto play of slides."
                        },
			{
                                label:"Slides to show",
                                id:"slides_to_show",
				controlType:"select-control",
                                selectValues:['1', '2', '3', '4'],
                                defaultValue: '1',
                                defaultText: '1',
                                help:"# of slides to show at a time."
                        },
			{
                                label:"Slides to scroll",
				controlType:"select-control",
                                selectValues:['1', '2', '3', '4'],
                                defaultValue: '1',
                                defaultText: '1',
                                id:"slides_to_scroll",
				
                                help:"# of slides to scroll at a time."
                        },
			{
				label:"Dots",
				id:"dots",
				controlType:"select-control",
				selectValues:['no', 'yes'],
				defaultValue: 'no',
				defaultText: 'no',
				help:"Current slide indicator dots."
			},
			{
                                label:"Infinite",
                                id:"infinite",
                                controlType:"select-control",
                                selectValues:['yes', 'no'],
                                defaultValue: 'yes',
                                defaultText: 'yes',
                                help:"Infinite looping"
                        },
			{
                                label:"Custom class",
                                id:"class",
                                help:"Any CSS classes you want to add."
                        }
	],
	defaultContent:" [slick_slider] http://lorempixel.com/1000/300/?1 [/slick_slider] [slick_slider] http://lorempixel.com/1000/300/?2 [/slick_slider] [slick_slider] http://lorempixel.com/1000/300/?3 [/slick_slider] [slick_slider] http://lorempixel.com/1000/300/?4 [/slick_slider] [slick_slider] http://lorempixel.com/1000/300/?5 [/slick_slider]",
	shortcode:"slick_sliders"
};
