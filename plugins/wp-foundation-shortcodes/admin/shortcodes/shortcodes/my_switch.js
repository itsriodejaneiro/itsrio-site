frameworkShortcodeAtts={
	attributes:[
			{
                                label:"Type",
                                id:"type",
                                controlType:"select-control",
                                selectValues:['checkbox', 'radio'],
                                defaultValue: 'checkbox',
                                defaultText: 'checkbox',
                                help:"Switch input type may be <em>checkbox</em> or <em>radio</em>."
                        },
			{
                                label:"Input name",
                                id:"name",
				isRequired: true,
                                help:"Must be in english, no spaces, no special chars."
                        },
			{
                                label:"Input ID",
                                id:"id",
                                isRequired: true,
                                help:"ID must be unique. Must be in english, no spaces, no special chars. If empty random ID will created."
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
                                label:"Label for ON",
                                id:"label_on_status",
                                help:"Label for ON status."
                        },
			{
                                label:"Label for OFF",
                                id:"label_off_status",
                                help:"Label for OFF status."
                        },
			{
				label:"Custom Class",
				id:"class",
				help:"Any CSS classes you want to add."
			}
	],
	defaultContent:"",
	shortcode:"switch"
};
