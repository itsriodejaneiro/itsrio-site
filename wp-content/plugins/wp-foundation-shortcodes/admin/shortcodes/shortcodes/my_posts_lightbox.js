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
                                label:"Thumbnails",
                                id:"thumbs",
                                controlType:"select-control",
                                selectValues:['medium','small','mini'],
                                defaultValue: 'medium',
                                defaultText: 'medium',
                                help:"Size of post thumbnails."
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
				label:"Custom Class",
				id:"class",
				help:"Any CSS classes you want to add."
			}
	],
	defaultContent:"",
	shortcode:"posts_lightbox"
};
