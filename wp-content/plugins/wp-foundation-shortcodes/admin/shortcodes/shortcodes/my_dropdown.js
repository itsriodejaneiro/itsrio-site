frameworkShortcodeAtts={
        attributes:[
			{
                                label:"Button Text",
                                id:"button_text",
                                help:"Enter the text for button."
                        },
			{
                                label:"Button Size",
                                id:"button_size",
                                controlType:"select-control",
                                selectValues:['simple_link', 'tiny', 'small', 'large', 'expand'],
                                defaultValue: 'simple_link',
                                defaultText: 'simple_link',
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
                                label:"Dropdown Direction",
                                id:"dropdown_direction",
                                controlType:"select-control",
                                selectValues:['', 'right', 'top', 'left'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose dropdown direction."
                        },
			{
                                label:"Dropdown Autoclose",
                                id:"dropdown_autoclose",
                                controlType:"select-control",
                                selectValues:['yes', 'no'],
                                defaultValue: 'yes',
                                defaultText: 'yes',
                                help:"Choose dropdown autoclose."
                        },
			{
                                label:"Dropdown open on hover",
                                id:"dropdown_open_on_hover",
                                controlType:"select-control",
                                selectValues:['no', 'yes'],
                                defaultValue: 'no',
                                defaultText: 'no',
                                help:"Choose dropdown autoclose."
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
        shortcode:"dropdown"
};
