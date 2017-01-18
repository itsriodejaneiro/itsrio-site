frameworkShortcodeAtts={
        attributes:[
			{
                                label:"Title",
                                id:"title",
                                help:"Enter the title for price table."
                        },
			{
                                label:"Price",
                                id:"price",
                                help:"Enter the price. E.g. $99.99"
                        },
			{
                                label:"Description",
                                id:"description",
                                help:"Enter the description."
                        },
			{
                                label:"Item name",
                                id:"item_name_1",
                                help:"Enter item1 name."
                        },
			{
                                label:"Item name",
                                id:"item_name_2",
                                help:"Enter item2 name."
                        },
			{
                                label:"Item name",
                                id:"item_name_3",
                                help:"Enter item3 name."
                        },
			{
                                label:"Button Text",
                                id:"button_text",
                                help:"Enter the text for button."
                        },
                        {
                                label:"Button Link",
                                id:"url",
                                help:"Enter the url for button. (e.g. http://www.example.com/)"
                        },
                        {
                                label:"Target",
                                id:"target",
                                controlType:"select-control",
                                selectValues:['_self', '_blank', '_parent', '_top'],
                                defaultValue: '_self',
                                defaultText: '_self',
                                help:"The target attribute specifies a window or a frame where the linked document is loaded."
                        },
			{
				label:"Recommended",
                                id:"recommended",
                                controlType:"select-control",
                                selectValues:['no', 'yes'],
                                defaultValue: 'no',
                                defaultText: 'no',
                                help:"Recommended block."
			},
                        {
                                label:"Custom class",
                                id:"class",
                                help:"Use this field if you want to use a custom class."
                        }
        ],
	defaultContent:"",
        shortcode:"pricing_table"
};
