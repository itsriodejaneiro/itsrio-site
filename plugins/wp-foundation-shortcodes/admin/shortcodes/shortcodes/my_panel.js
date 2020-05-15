frameworkShortcodeAtts={
        attributes:[
                        {
                                label:"Corners",
                                id:"corners",
                                controlType:"select-control",
                                selectValues:['', 'radius'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose panel corners style."
                        },
			{       
                                label:"Callout",
                                id:"callout",
                                controlType:"select-control",
                                selectValues:['no', 'yes'],
                                defaultValue: 'no',
                                defaultText: 'no',
                                help:"Choose panel callout."
                        },
			{
                                label:"Panel Content",
				controlType:"textarea-control",
                                id:"content",
                                help:"Enter the panel content."
                        },
                        {
                                label:"Custom class",
                                id:"class",
                                help:"Use this field if you want to use a custom class."
                        }
        ],
        defaultContent:"",
        shortcode:"panel"
};
