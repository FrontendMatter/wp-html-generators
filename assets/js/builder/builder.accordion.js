(function ($) {
    "use strict";

    $(function () {

        var accordion = {
            "component": {
                "id": "accordion",
                "label": "Accordion",
                "description": "Create accordions and collapsibles."
            },
            "options": {
                "preview": true,
                "type": "generator",
                "panels": [
                    {
                        "label": "Accordion Panel",
                        "generators": [
                            {
                                "generator_id": "Accordion",
                                "singleton": 1,
                                "method": "addAccordion",
                                "atts": {
                                    "addAccordion": ["heading", "body"]
                                },
                                "after": [ "isActive" ]
                            }
                        ],
                        "data": {
                            "heading": "Accordion heading 1",
                            "body": "Accordion body 1",
                            "isActive": 0
                        },
                        "form": [
                            {
                                "name": "heading",
                                "type": "input",
                                "label": "Heading"
                            },
                            {
                                "name": "body",
                                "type": "textarea",
                                "label": "Body"
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
                    "isCollapsible": 0
                },
                "after": [ "isCollapsible" ],
                "form": [
                    {
                        "name": "isCollapsible",
                        "label": "Type",
                        "type": "radio_buttons",
                        "values": { 0: 'Accordion', 1 : 'Collapsible' }
                    }
                ]
            }
        };

        $(document).on('loaded.ComponentsCtrl.builder', function()
        {
            var Components = angular.element('[ng-controller="ComponentsCtrl"]').scope();
            if (typeof Components !== 'undefined' && typeof Components.components !== 'undefined')
                Components.append(accordion, 'HTML Generators');
        });

    });

})(jQuery);