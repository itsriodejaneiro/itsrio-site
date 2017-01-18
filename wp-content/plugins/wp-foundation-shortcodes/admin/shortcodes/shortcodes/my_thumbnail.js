frameworkShortcodeAtts={
	attributes:[
			{
				label:"Thumbnail url",
				id:"content",
				help:"Enter the url for thumbnail. E.g. <strong>http://lorempixel.com/100/100/</strong>"
			},
			{
				label:"Link",
				id:"url",
				help:"Enter the url for thumbnail. E.g. <strong>http://www.example.com/</strong>"
			},
			{
                                label:"Target",
                                id:"target",
                                controlType:"select-control",
                                selectValues:['_self', '_blank', '_parent', '_top'],
                                defaultValue: '',
                                defaultText: '',
                                help:"The target attribute specifies a window or a frame where the linked document is loaded."
                        },
			{
                                label:"Corners",
                                id:"corners",
                                controlType:"select-control",
                                selectValues:['', 'radius'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose thumbnail corners style."
                        },
			{
				label:"Custom Class",
				id:"class",
				help:"Any CSS classes you want to add."
			}
	],
	defaultContent:"",
	shortcode:"thumbnail"
};
