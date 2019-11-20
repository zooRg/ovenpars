ovenpars.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'ovenpars-panel-home',
            renderTo: 'ovenpars-panel-home-div'
        }]
    });
    ovenpars.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(ovenpars.page.Home, MODx.Component);
Ext.reg('ovenpars-page-home', ovenpars.page.Home);