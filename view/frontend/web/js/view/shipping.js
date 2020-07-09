define(
    [
        'jquery',
        'underscore',
        'Magento_Ui/js/form/form',
        'ko',
        'Magento_Customer/js/model/customer',
        'Magento_Customer/js/model/address-list',
        'Magento_Checkout/js/model/address-converter',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/action/create-shipping-address',
        'Magento_Checkout/js/action/select-shipping-address',
        'Magento_Checkout/js/model/shipping-rates-validator',
        'Magento_Checkout/js/model/shipping-address/form-popup-state',
        'Magento_Checkout/js/model/shipping-service',
        'Magento_Checkout/js/action/select-shipping-method',
        'Magento_Checkout/js/model/shipping-rate-registry',
        'Magento_Checkout/js/action/set-shipping-information',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Ui/js/modal/modal',
        'Magento_Checkout/js/model/checkout-data-resolver',
        'Magento_Checkout/js/checkout-data',
        'uiRegistry',
        'mage/translate',
        'Magento_Checkout/js/model/shipping-rate-service',
        'Magento_Checkout/js/model/cart/cache',
        'Magento_Checkout/js/model/cart/totals-processor/default'
    ],function (
        $,
        _,
        Component,
        ko,
        customer,
        addressList,
        addressConverter,
        quote,
        createShippingAddress,
        selectShippingAddress,
        shippingRatesValidator,
        formPopUpState,
        shippingService,
        selectShippingMethodAction,
        rateRegistry,
        setShippingInformationAction,
        stepNavigator,
        modal,
        checkoutDataResolver,
        checkoutData,
        registry,
        $t,
        ShippingRateService,
        cartCache,
        defaultTotal) {
        'use strict';

        //update shipping fee when change shipping method
        var mixin = {

            selectShippingMethod: async function (shippingMethod, event) {
                console.log(shippingMethod.method_code);
                $("#checkout-shipping-method-load .row").removeClass("checked");
                var target = event.currentTarget;
                $(target).addClass("checked");
                selectShippingMethodAction(shippingMethod);
                checkoutData.setSelectedShippingRate(shippingMethod.carrier_code + '_' + shippingMethod.method_code);
                await setShippingInformationAction();
                var totals = quote.getTotals()();
                var totalsInCache = cartCache.get('totals');
                if (totalsInCache == null)
                    totalsInCache   = {};
                totalsInCache.base_shipping_amount = shippingMethod.base_amount;
                totalsInCache.grand_total = totals['grand_total'];
                cartCache.set('totals', totalsInCache);

                return true;
            },
        };

        return function (target) { // target == Result that Magento_Ui/.../default returns.
            return target.extend(mixin); // new result that all other modules receive
        };
    });