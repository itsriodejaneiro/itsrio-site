frameworkShortcodeAtts={
	attributes:[
			{
				label:"Button Text",
				id:"content",
				help:"Enter the text for alert box. You can use these tags:<code>&lt;strong&gt; &lt;em&gt; &lt;s&gt; &lt;strike&gt;</code>"
			},
			{
                                label:"Type",
                                id:"type",
                                controlType:"select-control",
                                selectValues:['standard', 'side border', 'minimal'],
                                defaultValue: 'standard',
                                defaultText: 'standard',
                                help:"Choose alert box type."
                        },
			{
				label:"Colors",
				id:"color",
				controlType:"select-control",
				selectValues:['primary', 'success', 'secondary', 'alert', 'info', 'warning'],
				defaultValue: 'primary',
				defaultText: 'primary',
				help:"Choose alert box colors."
			},
			{
                                label:"Corners",
                                id:"corners",
                                controlType:"select-control",
                                selectValues:['', 'round', 'radius'],
                                defaultValue: '',
                                defaultText: '',
                                help:"Choose alert box corners style."
                        },
			{
                                label:"Icon",
                                id:"icon",
				controlType:"select-control",
                                selectValues:['yes', 'no'],
                                defaultValue: 'yes',
                                defaultText: 'yes',
                                help:"Add icon."
                        },
			{
                                label:"Close button",
                                id:"close",
                                controlType:"select-control",
                                selectValues:['yes', 'no'],
                                defaultValue: 'yes',
                                defaultText: 'yes',
                                help:"Show close button or not."
                        },
			{
                                label:"Custom Class",
                                id:"class",
                                help:"Any CSS classes you want to add."
                        }
	],
	defaultContent:"",
	shortcode:"alert_box"
};
