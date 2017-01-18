frameworkShortcodeAtts={
        attributes:[
			{
                                label:"Title",
                                id:"title",
                                help:"Enter product card title."
                        },
			{
                                label:"Price",
                                id:"price",
                                help:"Enter price. (e.g. $19.99)"
                        },
			{
                                label:"Image path",
                                id:"img",
                                help:"Image path. (e.g. http://lorempixel.com/450/300/)"
                        },
			{
                                label:"Button Text",
                                id:"button_text",
                                help:"Enter the text for button."
                        },
			{
                                label:"Link",
                                id:"url",
                                help:"Enter the url. (e.g. http://www.example.com/)"
                        },
			{
                                label:"Hover Effect",
                                id:"hover_effect",
                                controlType:"select-control",
                                selectValues:['overlay-fade-in', 'overlay-slide-in-left', 'overlay-fade-in-new-background'],
                                defaultValue: 'overlay-fade-in',
                                defaultText: 'overlay-fade-in',
                                help:"Image hover effects. You can change background via CSS."
                        },
                        {
                                label:"Custom class",
                                id:"class",
                                help:"Use this field if you want to use a custom class."
                        }
        ],
        defaultContent:"",
        shortcode:"product_card_hover"
};
