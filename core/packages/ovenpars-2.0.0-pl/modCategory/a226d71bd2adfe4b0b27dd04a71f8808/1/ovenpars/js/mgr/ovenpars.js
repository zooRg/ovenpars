var ovenpars = function (config) {
    config = config || {};
    ovenpars.superclass.constructor.call(this, config);
};
Ext.extend(ovenpars, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('ovenpars', ovenpars);

ovenpars = new ovenpars();