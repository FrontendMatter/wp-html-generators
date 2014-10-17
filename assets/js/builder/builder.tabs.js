(function ($) {
    "use strict";

    $(function () {

        var tabs = {
            "component": {
                "id": "tabs",
                "label": "Tabs",
                "description": "Create Tab Panels."
            },
            "options": {
                "preview": true,
                "type": "generator",
                "panels": [
                    {
                        "label": "Tab Panel",
                        "generators": [
                            {
                                "generator_id": "Nav",
                                "singleton": 1,
                                "method": "addNav",
                                "atts": {
                                    "addNav": ["tab_id", "tab_text"]
                                },
                                "before": [ "isTabs" ],
                                "after": [ "isActive" ]
                            },
                            {
                                "generator_id": "Tab",
                                "singleton": 1,
                                "method": "addTab",
                                "atts": {
                                    "addTab": ["tab_id", "tab_content"]
                                },
                                "after": [ "isActive" ]
                            }
                        ],
                        "data": {
                            "tab_id": "tab1",
                            "tab_text": "Tab text 1",
                            "tab_content": "Tab content 1",
                            "isActive": 1
                        },
                        "form": [
                            {
                                "name": "tab_id",
                                "type": "input",
                                "label": "Tab ID"
                            },
                            {
                                "name": "tab_text",
                                "type": "input",
                                "label": "Tab Text"
                            },
                            {
                                "name": "tab_content",
                                "type": "textarea",
                                "label": "Tab Content"
                            },
                            {
                                "name": "isActive",
                                "label": "Active",
                                "type": "radio_buttons",
                                "values": { 0: 'Off', 1 : 'On' }
                            }
                        ]
                    }
                ],
                "data": {
                    "isFade": 1
                },
                "after": [ "isFade" ],
                "form": [
                    {
                        "name": "isFade",
                        "label": "Fade",
                        "type": "radio_buttons",
                        "values": { 1 : 'On', 0: 'Off' }
                    }
                ]
            }
        };

        $(document).on('loaded.ComponentsCtrl.builder', function()
        {
            var Components = angular.element('[ng-controller="ComponentsCtrl"]').scope();
            if (typeof Components !== 'undefined' && typeof Components.components !== 'undefined')
                Components.append(tabs, 'HTML Generators');
        });

    });

})(jQuery);