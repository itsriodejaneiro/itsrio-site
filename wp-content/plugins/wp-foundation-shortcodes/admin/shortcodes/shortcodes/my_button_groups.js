frameworkShortcodeAtts={
	attributes:[
			{
				label:"Colors",
				id:"color",
				controlType:"select-control",
				selectValues:['primary', 'success', 'secondary', 'alert', 'info', 'disabled'],
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
	defaultContent:" [button_group url='#'] Button 1 [/button_group] [button_group url='#'] Button 2 [/button_group] [button_group url='#'] Button 3 [/button_group] [button_group url='#'] Button 4 [/button_group] [button_group url='#'] Button 5 [/button_group] ",
	shortcode:"button_groups"
};
setTimeout(function(){
        jQuery("#framework-content").parents("tr").hide();
}, 50)

