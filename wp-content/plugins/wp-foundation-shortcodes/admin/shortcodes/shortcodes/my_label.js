frameworkShortcodeAtts={
	attributes:[
			{
				label:"Label Text",
				id:"content",
				help:"Enter the text for label."
			},
			{
				label:"Colors",
				id:"color",
				controlType:"select-control",
				selectValues:['primary', 'success', 'secondary', 'alert', 'info', 'warning'],
				defaultValue: 'primary',
				defaultText: 'primary',
				help:"Choose label colors."
			},
			{
                                label:"Corners",
                                id:"corners",
                                controlType:"select-control",
                                selectValues:['', 'round', 'radius'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose label corners style."
                        },
			{
				label:"Custom Class",
				id:"class",
				help:"Any CSS classes you want to add."
			},
			{
                                label:"Icon",
                                id:"icon",
				help:"Icon name, e.g. 'fa-pencil' from <u><a href='http://fortawesome.github.io/Font-Awesome/cheatsheet/' target='_blank'>Font-Awesome website</a></u>"
                        }
	],
	defaultContent:"label",
	shortcode:"label"
};
