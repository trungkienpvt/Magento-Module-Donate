define(
    [
        'Dev69_DonateService/js/view/checkout/summary/donatefee'
    ],
    function (Component) {
        'use strict';

        return Component.extend({
            /**
             * @override
             * use to define amount is display setting
             */
            isDisplayed: function () {
                return true;
            }
        });
    }
);