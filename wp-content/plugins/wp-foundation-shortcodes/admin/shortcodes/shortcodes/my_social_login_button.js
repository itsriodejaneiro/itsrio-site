frameworkShortcodeAtts={
	attributes:[
			{
				label:"Button Text",
				id:"content",
				help:"Enter the text for button."
			},
			{
				label:"Type",
				id:"type",
				controlType:"select-control",
				selectValues:['facebook', 'twitter', 'google'],
				defaultValue: 'facebook',
				defaultText: 'facebook',
				help:"Choose social button type."
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
				selectValues:['', 'tiny', 'small', 'large'],
				defaultValue: '',
				defaultText: '',
				help:"Choose button size."
			},
			{
                                label:"Icon Side",
                                id:"icon_side",
                                controlType:"select-control",
                                selectValues:['right', 'left'],
                                defaultValue: 'right',
                                defaultText: 'right',
                                help:"Choose icon side."
                        },
			{
				label:"Custom Class",
				id:"class",
				help:"Any CSS classes you want to add."
			}
	],
	defaultContent:"",
	shortcode:"social_login_button"
};
