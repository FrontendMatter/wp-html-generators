(function ($) {
    "use strict";

    $(function () {

        var components = {
            "key": "HTML Generators",
            "views": []
        };

        $(document).on('loaded.ComponentsCtrl.builder', function()
        {
            var Components = angular.element('[ng-controller="ComponentsCtrl"]').scope();
            if (typeof Components !== 'undefined' && typeof Components.components !== 'undefined')
                Components.prepend(components);
        });

    });

})(jQuery);