(function ($) {
    "use strict";

    $(function () {

        var button_shortcode = {
            "component": {
                "id": "button",
                "label": "Button",
                "description": "Create a button with different style and size options.",
                "icon": "fa-2x fa-th-large"
            },
            "options": {
                "preview": true,
                "type": "shortcode",
                "shortcode_id": "button",
                "shortcode_atts": ["label", "style", "size"],
                "data": {
                    "label": "Button",
                    "style": "default",
                    "size": "default"
                },
                "form": [
                    {
                        "name": "label",
                        "label": "Button Text",
                        "type": "input"
                    },
                    {
                        "name": "style",
                        "label": "Style",
                        "type": "select",
                        "values": { "default": "Default", "primary": "Primary", "success": "Success", "danger": "Danger" }
                    },
                    {
                        "name": "size",
                        "label": "Size",
                        "type": "select",
                        "values": { "default": "Default", "sm": "Small", "xs": "Extra Small", "lg": "Large" }
                    }
                ]
            }
        };

        var button_generator = {
            "component": {
                "id": "button_generator",
                "label": "Button",
                "description": "Create a button with different style and size options.",
                "icon": "fa-2x fa-th-large"
            },
            "options": {
                "preview": true,
                "type": "generator",
                "generators": [
                    {
                        "generator_id": "Button",
                        "instance": "make",
                        "method": [ "addAttributes" ],
                        "atts": {
                            "make": [ "label" ],
                            "addAttributes": [
                                {
                                    "class": [ "style", "size" ]
                                }
                            ]
                        },
                        "map": {
                            "addAttributes": {
                                "class": {
                                    "style": {
                                        "default": "btn-default",
                                        "primary": "btn-primary",
                                        "success": "btn-success",
                                        "danger": "btn-danger"
                                    },
                                    "size": {

                                    }
                                }
                            }
                        }
                    }
                ],
                "data": {
                    "label": "Button",
                    "style": "default",
                    "size": "default"
                },
                "form": [
                    {
                        "name": "label",
                        "label": "Button Text",
                        "type": "input"
                    },
                    {
                        "name": "style",
                        "label": "Style",
                        "type": "select",
                        "values": { "default": "Default", "primary": "Primary", "success": "Success", "danger": "Danger" }
                    },
                    {
                        "name": "size",
                        "label": "Size",
                        "type": "select",
                        "values": { "default": "Default", "sm": "Small", "xs": "Extra Small", "lg": "Large" }
                    }
                ]
            }
        };

        $(document).on('loaded.ComponentsCtrl.builder', function()
        {
            var Components = angular.element('[ng-controller="ComponentsCtrl"]').scope();
            if (typeof Components !== 'undefined' && typeof Components.components !== 'undefined')
                Components.append(button_generator, 'HTML Generators');
        });

    });

})(jQuery);