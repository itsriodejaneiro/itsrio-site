frameworkShortcodeAtts={
        attributes:[
                        {
                                label:"Value",
                                id:"value",
                                help:"Enter the value for bar (%) from 1 to 100."
                        },
			{
                                label:"Colors",
                                id:"color",
                                controlType:"select-control",
                                selectValues:['blue', 'red', 'orange', 'green', 'purple'],
                                defaultValue: 'blue',
                                defaultText: 'blue',
                                help:"Choose progress bar colors."
                        },
			{
                                label:"Corners",
                                id:"corners",
                                controlType:"select-control",
                                selectValues:['', 'round', 'radius'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose progress bar corners style."
                        },
                        {
                                label:"Custom class",
                                id:"class",
                                help:"Use this field if you want to use a custom class."
                        }
        ],
        defaultContent:"",
        shortcode:"progressbar"
};
