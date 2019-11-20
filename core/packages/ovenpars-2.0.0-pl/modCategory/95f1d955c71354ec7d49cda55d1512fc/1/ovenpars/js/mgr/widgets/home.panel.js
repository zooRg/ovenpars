ovenpars.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'ovenpars-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('ovenpars') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('ovenpars_items'),
                layout: 'anchor',
                items: [{
                    html: _('ovenpars_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'ovenpars-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    ovenpars.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(ovenpars.panel.Home, MODx.Panel);
Ext.reg('ovenpars-panel-home', ovenpars.panel.Home);
