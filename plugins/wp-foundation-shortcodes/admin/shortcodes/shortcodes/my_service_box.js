frameworkShortcodeAtts={
	attributes:[
			{
			        label:"Title",
                                id:"title",
                                help:"Enter the box title."
                        },
			{
                                label:"Subtitle",
                                id:"subtitle",
                                help:"Enter the box subtitle."
                        },
			{
                                label:"Icon",
                                id:"icon",
                                help:"Icon name, e.g. 'fa-pencil' from <u><a href='http://fortawesome.github.io/Font-Awesome/cheatsheet/' target='_blank'>Font-Awesome website</a></u>"
                        },
			{
                                label:"Banner Text",
                                id:"content",
                                controlType:"textarea-control",
                                help:"Enter the text for the box."
                        },
			{
                                label:"Link",
                                id:"url",
                                help:"Enter the url for the box, e.g. http://www.example.com/"
                        },
			{
				label:"Button Text",
				id:"btn_text",
				help:"Enter the text for button."
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
				label:"Button Colors",
				id:"color",
				controlType:"select-control",
				selectValues:['primary', 'success', 'secondary', 'alert', 'info'],
				defaultValue: 'primary',
				defaultText: 'primary',
				help:"Choose button colors."
			},
			{
                                label:"Button Corners",
                                id:"corners",
                                controlType:"select-control",
                                selectValues:['', 'round', 'radius'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose button corners style."
                        },
			{
				label:"Button Size",
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
			}
	],
	defaultContent:"",
	shortcode:"service_box"
};
