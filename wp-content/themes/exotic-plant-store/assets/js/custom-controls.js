(function(api) {

    api.sectionConstructor['exotic-plant-store-buynow'] = api.Section.extend({
        attachEvents: function() {},
        isContextuallyActive: function() {
            return true;
        }
    });

})(wp.customize);