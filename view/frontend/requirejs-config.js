var config = {
    "map": {
        "*": {
            'Magento_Checkout/js/model/shipping-save-processor/default': 'Emartech_EmarsysRecommender/js/model/shipping-save-processor/default'
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/view/minicart': {
                'Emartech_EmarsysRecommender/js/minicart-mixin': true
            }
        }
    }
};
