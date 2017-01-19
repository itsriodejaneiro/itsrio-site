frameworkShortcodeAtts={
	attributes:[
			{
                                label:"Input name",
                                id:"name",
                                isRequired: true,
                                help:"Must be in english, no spaces, no special chars. If empty random name will taken."
                        },
			{
				label:"Colors",
				id:"color",
				controlType:"select-control",
				selectValues:['primary', 'success', 'secondary', 'alert', 'info'],
				defaultValue: 'primary',
				defaultText: 'primary',
				help:"Choose button colors."
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
				label:"Custom Class",
				id:"class",
				help:"Any CSS classes you want to add."
			},
			{
                                label:"",
                                id:"content",
				item_class:"hide_content"
                        },
	],
	defaultContent:" [radio_button_group id='radio1'] Button 1 [/radio_button_group] [radio_button_group id='radio2'] Button 2 [/radio_button_group] [radio_button_group id='radio3'] Button 3 [/radio_button_group] [radio_button_group id='radio4'] Button 4 [/radio_button_group] [radio_button_group id='radio5'] Button 5 [/radio_button_group] ",
	shortcode:"radio_button_groups"
};
setTimeout(function(){
        jQuery("#framework-content").parents("tr").hide();
}, 50)

