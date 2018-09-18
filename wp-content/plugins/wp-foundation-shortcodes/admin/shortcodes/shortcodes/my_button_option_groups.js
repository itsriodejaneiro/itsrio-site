frameworkShortcodeAtts={
	attributes:[
			{
                                label:"Option Label",
                                id:"label",
                                isRequired: true,
                                help:"E.g. OR."
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
	defaultContent:" [button_option_group url='#' class='primary'] Buy it now [/button_option_group] [button_option_group url='#' class='success'] Learn More [/button_option_group] ",
	shortcode:"button_option_groups"
};
setTimeout(function(){
        jQuery("#framework-content").parents("tr").hide();
}, 50)

