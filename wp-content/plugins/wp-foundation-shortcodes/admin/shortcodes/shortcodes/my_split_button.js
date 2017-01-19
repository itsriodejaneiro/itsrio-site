frameworkShortcodeAtts={
        attributes:[
			{
                                label:"Button Text",
                                id:"button_text",
                                help:"Enter the text for button."
                        },
			{
                                label:"Button Link",
                                id:"button_url",
                                help:"Enter the url for button. (e.g. http://www.example.com/)"
                        },
			{
                                label:"Button Size",
                                id:"button_size",
                                controlType:"select-control",
                                selectValues:['', 'tiny', 'small', 'large', 'expand'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose button size."
                        },
			{
                                label:"Button Colors",
                                id:"button_color",
                                controlType:"select-control",
                                selectValues:['primary', 'success', 'secondary', 'alert', 'info'],
                                defaultValue: 'primary',
                                defaultText: 'primary',
                                help:"Choose button colors."
                        },
                        {
                                label:"Button Corners",
                                id:"button_corners",
                                controlType:"select-control",
                                selectValues:['', 'round', 'radius'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose button corners style."
                        },
			{
                                label:"Dropdown Size",
                                id:"dropdown_size",
                                controlType:"select-control",
                                selectValues:['', 'tiny', 'small', 'medium', 'large', 'content'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose dropdown size."
                        },
			{
                                label:"Dropdown Content",
				controlType:"textarea-control",
                                id:"content",
                                help:"Enter the dropdown content."
                        },
                        {
                                label:"Custom class",
                                id:"class",
                                help:"Use this field if you want to use a custom class."
                        }
        ],
        defaultContent:"",
        shortcode:"split_button"
};
