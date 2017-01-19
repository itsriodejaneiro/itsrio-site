frameworkShortcodeAtts={
        attributes:[
			{
                                label:"Text",
                                id:"content",
                                help:"Enter tooltip text."
                        },
			{
                                label:"Title",
                                id:"title",
                                help:"Enter tooltip title."
                        },
                        {
                                label:"Corners",
                                id:"corners",
                                controlType:"select-control",
                                selectValues:['', 'round', 'radius'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose tooltip corners style."
                        },
			{
                                label:"Direction",
                                id:"direction",
                                controlType:"select-control",
                                selectValues:['bottom', 'right', 'top', 'left'],
                                defaultValue: 'bottom',
                                defaultText: 'bottom',
                                help:"Choose tooltip direction."
                        },
                        {
                                label:"Custom class",
                                id:"class",
                                help:"Use this field if you want to use a custom class."
                        }
        ],
        defaultContent:"",
        shortcode:"tooltip"
};
