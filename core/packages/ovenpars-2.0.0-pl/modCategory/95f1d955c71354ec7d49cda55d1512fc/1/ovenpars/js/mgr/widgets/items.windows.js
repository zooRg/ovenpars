ovenpars.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ovenpars-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('ovenpars_item_create'),
        width: 550,
        autoHeight: true,
        url: ovenpars.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    ovenpars.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(ovenpars.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('ovenpars_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('ovenpars_item_description'),
            name: 'description',
            id: config.id + '-description',
            height: 150,
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('ovenpars_item_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('ovenpars-item-window-create', ovenpars.window.CreateItem);


ovenpars.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ovenpars-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('ovenpars_item_update'),
        width: 550,
        autoHeight: true,
        url: ovenpars.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    ovenpars.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(ovenpars.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('ovenpars_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('ovenpars_item_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('ovenpars_item_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('ovenpars-item-window-update', ovenpars.window.UpdateItem);