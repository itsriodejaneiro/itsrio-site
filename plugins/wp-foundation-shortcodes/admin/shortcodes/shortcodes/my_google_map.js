frameworkShortcodeAtts = {
        attributes:[
                        {
                                label:"Latitude coordinate",
                                id:"lat_value",
                                help:"Set latitude coordinate to location."
                        },
                        {
                                label:"Longitude coordinate",
                                id:"lng_value",
                                help:"Set longitude coordinate to location."
                        },
                        {
                                label:"The initial Map zoom level",
                                id:"zoom_value",
                                help:"Set the initial Map zoom level. Default: 14"
                        },
			{
                                label:"Scrollwheel zooming",
                                id:"zoom_wheel",
                                controlType:"select-control",
                                selectValues:['no', 'yes'],
                                defaultValue: 'no',
                                defaultText: 'no',
                                help:"Scrollwheel zooming on the map. Set 'no' for disabling."
                        },
                        {
                                label:"Custom class",
                                id:"class",
                                help:"Use this field if you want to use a custom class."
                        }
        ],
        defaultContent:"",
        shortcode:"google_map"
};

