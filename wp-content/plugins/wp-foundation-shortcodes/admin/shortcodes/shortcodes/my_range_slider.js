frameworkShortcodeAtts={
        attributes:[
			{
				label:"Direction",
				id: "direction",
				controlType:"select-control",
				selectValues:['horizontal','vertical'],
				defaultValue: 'horizontal',
                                defaultText: 'horizontal',
                                help:"Choose horizontal or vertical display."
			},
			{
                                label:"Accessibility",
                                id:"accessibility",
                                controlType:"select-control",
                                selectValues:['', 'disabled'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose whether accessible."
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
                        },
			{
				label:"Initial value",
				id:"initial_value",
				help:"Enter initial value. Default 50."
			},
			{
				label: "Start value",
				id: "start_value",
				help: "Enter start value. Default 0."
			},
			{
                                label: "End value",
                                id: "end_value",
                                help: "Enter end value. Default 100."
                        },
			{
                                label: "Step",
                                id: "step",
                                help: "Enter step value. Default 1."
                        }
        ],
        defaultContent:"",
        shortcode:"range_slider"
};
