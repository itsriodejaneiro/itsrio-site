frameworkShortcodeAtts={
	attributes:[
			{
				label:"Button Text",
				id:"content",
				help:"Enter the text for button."
			},
			{
				label:"Button Link",
				id:"url",
				help:"Enter the url for button. (e.g. http://www.example.com/)"
			},
			{
                                label:"Target",
                                id:"target",
                                controlType:"select-control",
                                selectValues:['_self', '_blank', '_parent', '_top'],
                                defaultValue: '_self',
                                defaultText: '_self',
                                help:"The target attribute specifies a window or a frame where the linked document is loaded."
                        },
			{
				label:"Colors",
				id:"color",
				controlType:"select-control",
				selectValues:['primary', 'success', 'secondary', 'alert', 'info', 'disabled'],
				defaultValue: 'primary',
				defaultText: 'primary',
				help:"Choose button colors."
			},
			{
                                label:"Corners",
                                id:"corners",
                                controlType:"select-control",
                                selectValues:['', 'round', 'radius'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose button corners style."
                        },
			{
				label:"Size",
				id:"size",
				controlType:"select-control",
				selectValues:['', 'tiny', 'small', 'large', 'expand'],
				defaultValue: '',
				defaultText: '',
				help:"Choose button size."
			},
			{
				label:"Custom Class",
				id:"class",
				help:"Any CSS classes you want to add."
			},
			{
                                label:"Icon",
                                id:"icon",
				help:"Icon name. E.g. 'fa-pencil' from <u><a href='http://fortawesome.github.io/Font-Awesome/cheatsheet/' target='_blank'>Font-Awesome website</a></u>"
                        }
	],
	defaultContent:"",
	shortcode:"button"
};
