frameworkShortcodeAtts={
	attributes:[
			{
                                label:"Title",
                                id:"title",
                                help:"Enter the banner title."
                        },
			{
                                label:"Image",
                                id:"img",
                                help:"Enter path to the banner image, e.g. http://www.example.com/pic.png"
                        },
			{
                                label:"Link",
                                id:"url",
                                help:"Enter the url for the banner, e.g. http://www.example.com/"
                        },
			{
                		label:"Banner Text",
                		id:"content",
                                controlType:"textarea-control",
		                help:"Enter the text for banner."
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
				label:"Custom Class",
				id:"class",
				help:"Any CSS classes you want to add."
			}
	],
	defaultContent:"",
	shortcode:"banner"
};

