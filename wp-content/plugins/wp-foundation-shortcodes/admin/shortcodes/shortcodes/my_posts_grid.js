frameworkShortcodeAtts={
	attributes:[
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
                                label:"Columns",
                                id:"columns",
                                help:"Number of posts per row."
                        },
			{
                                label:"Rows",
                                id:"rows",
                                help:"Number of rows."
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
				label:"Custom Class",
				id:"class",
				help:"Any CSS classes you want to add."
			}
	],
	defaultContent:"",
	shortcode:"posts_grid"
};
