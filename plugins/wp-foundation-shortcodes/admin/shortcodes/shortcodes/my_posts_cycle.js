frameworkShortcodeAtts={
	attributes:[
			{
                                label:"How many posts to show?",
                                id:"numberposts",
                                help:"Total number of posts, -1 for all posts"
                        },
			{
                                label:"Category",
                                id:"category",
                                help:"Enter the slug of the category you'd like to pull posts from. Leave blank if you'd like to pull from all categories."
                        },
                        {
                                label:"Tag",
                                id:"tag",
                                help:"Enter tags for posts filtering. Leave blank to pull all tags."
                        },
                        {
                                label:"Order by",
                                id:"order_by",
                                controlType:"select-control",
                                selectValues:['date', 'title', 'popular', 'random'],
                                defaultValue: 'date',
                                defaultText: 'date',
                                help:"Choose the order by mode."
                        },
                        {
                                label:"Order",
                                id:"order",
                                controlType:"select-control",
                                selectValues:['DESC', 'ASC'],
                                defaultValue: 'DESC',
                                defaultText: 'DESC',
                                help:"Choose the order mode ( from Z to A or from A to Z)."
                        },
			{
                                label:"Meta",
                                id:"meta",
                                controlType:"select-control",
                                selectValues:['yes', 'no'],
                                defaultValue: 'yes',
                                defaultText: 'yes',
                                help:"Show a post meta?"
                        },
			{
                                label:"The number of words in the excerpt",
                                id:"excerpt_count",
                                help:"How many words are displayed in the excerpt? Dafault: 25."
                        },
			{
                                label:"Autoplay",
                                id:"autoplay",
                                controlType:"select-control",
                                selectValues:['no', 'yes'],
                                defaultValue: 'no',
                                defaultText: 'no',
                                help:"Enables auto play of slides."
                        },
			{
                                label:"Posts to show",
                                id:"posts_to_show",
				controlType:"select-control",
                                selectValues:['1', '2', '3', '4'],
                                defaultValue: '1',
                                defaultText: '1',
                                help:"# of posts to show at a time."
                        },
			{
                                label:"Posts to scroll",
				controlType:"select-control",
                                selectValues:['1', '2', '3', '4'],
                                defaultValue: '1',
                                defaultText: '1',
                                id:"posts_to_scroll",
                                help:"# of posts to scroll at a time."
                        },
			{
				label:"Dots",
				id:"dots",
				controlType:"select-control",
				selectValues:['no', 'yes'],
				defaultValue: 'no',
				defaultText: 'no',
				help:"Current slide indicator dots."
			},
			{
                                label:"Infinite",
                                id:"infinite",
                                controlType:"select-control",
                                selectValues:['yes', 'no'],
                                defaultValue: 'yes',
                                defaultText: 'yes',
                                help:"Infinite looping"
                        },
			{
                                label:"Custom class",
                                id:"class",
                                help:"Any CSS classes you want to add."
                        }
	],
	defaultContent:"",
	shortcode:"posts_cycle"
};
