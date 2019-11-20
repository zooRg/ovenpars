ovenpars.grid.Items = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'ovenpars-grid-items';
    }
    Ext.applyIf(config, {
        url: ovenpars.config.connector_url,
        fields: this.getFields(config),
        columns: this.getColumns(config),
        tbar: this.getTopBar(config),
        sm: new Ext.grid.CheckboxSelectionModel(),
        baseParams: {
            action: 'mgr/item/getlist'
        },
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateItem(grid, e, row);
            }
        },
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: 0,
            getRowClass: function (rec) {
                return !rec.data.active
                    ? 'ovenpars-grid-row-disabled'
                    : '';
            }
        },
        paging: true,
        remoteSort: true,
        autoHeight: true,
    });
    ovenpars.grid.Items.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(ovenpars.grid.Items, MODx.grid.Grid, {
    windows: {},

    getMenu: function (grid, rowIndex) {
        var ids = this._getSelectedIds();

        var row = grid.getStore().getAt(rowIndex);
        var menu = ovenpars.utils.getMenu(row.data['actions'], this, ids);

        this.addContextMenuItem(menu);
    },

    createImport: function (request) {
        var _self = this,
            status = Ext.getCmp('currentStatus'),
            items_current = request.items_current || 1,
            countItems = request.countItems || 2,
            div = '<i class="icon icon-spinner"></i>';
    
        status.update(div + 'Поиск товаров');
    
        if (items_current >= countItems) {
            status.update('Завершено ' + request.items_current + ' из ' + request.countItems);
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/import/import',
                parent: ovenpars.config.setting_section_id,
                template: ovenpars.config.setting_template_id,
                price: ovenpars.config.setting_price_tv,
                description: ovenpars.config.setting_desc_tv,
                image: ovenpars.config.setting_image_tv,
                items_current: request.items_current
            },
            listeners: {
                success: {
                    fn: function (data) {
                        if (data.success) {
                            var html = data.results;
                            status.update(div + 'Обработано ' + html.items_current);
                        
                            this.refresh();
                            setTimeout(function () {
                                _self.createImport(html);
                                console.log(html);
                            }, 2000);
                        }
                    }, scope: this
                }
            }
        });
    },
    
    createExport: function (request) {
        var _self = this,
            status = Ext.getCmp('currentStatus'),
            page = request.page || 1,
            last_page = request.last_page || 2,
            div = '<i class="icon icon-spinner"></i>';
        
        status.update(div + 'Поиск товаров');
        
        if (page === last_page) {
            status.update('Завершено ' + request.items_current + ' из ' + request.items_max);
            this.refresh();
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/import/export',
                url: ovenpars.config.setting_url,
                container: ovenpars.config.setting_container,
                item: ovenpars.config.setting_item,
                currPage: request.page
            },
            listeners: {
                success: {
                    fn: function (data) {
                        if (data.success) {
                            var html = data.results.html;
                            status.update(div + 'Обработано ' + html.items_current + ' из ' + html.items_max);
                    
                            this.refresh();
                            setTimeout(function () {
                                _self.createExport(html);
                                console.log(html);
                            }, 2000);
                        }
                    }, scope: this
                },
                failure: {
                    fn: function (data) {
                        console.log(data);
                        status.update('Завершено с ошибкой, повторите еще раз');
                    }
                }
            }
        });
    },

    updateItem: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        else if (!this.menu.record) {
            return false;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/item/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = MODx.load({
                            xtype: 'ovenpars-item-window-update',
                            id: Ext.id(),
                            record: r,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.reset();
                        w.setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('ovenpars_items_remove')
                : _('ovenpars_item_remove'),
            text: ids.length > 1
                ? _('ovenpars_items_remove_confirm')
                : _('ovenpars_item_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/item/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    disableItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/item/disable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    enableItem: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/item/enable',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        })
    },

    getFields: function () {
        return ['id', 'parent', 'name', 'image', 'price', 'description', 'active', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('ovenpars_item_id'),
            dataIndex: 'id',
            sortable: true,
            width: 50
        }, {
            header: _('ovenpars_item_parent'),
            dataIndex: 'parent',
            sortable: true,
            width: 100
        }, {
            header: _('ovenpars_item_name'),
            dataIndex: 'name',
            sortable: true,
            width: 100,
        }, {
            header: _('ovenpars_item_image'),
            dataIndex: 'image',
            sortable: false,
            width: 100,
        }, {
            header: _('ovenpars_item_description'),
            dataIndex: 'description',
            sortable: false,
            width: 200,
        }, {
            header: _('ovenpars_item_price'),
            dataIndex: 'price',
            sortable: true,
            width: 70,
        }, {
            header: _('ovenpars_item_active'),
            dataIndex: 'active',
            renderer: ovenpars.utils.renderBoolean,
            sortable: true,
            width: 50,
        }, {
            header: _('ovenpars_grid_actions'),
            dataIndex: 'actions',
            renderer: ovenpars.utils.renderActions,
            sortable: false,
            width: 100,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-upload"></i>&nbsp;' + _('ovenpars_item_create'),
            handler: this.createImport,
            scope: this
        }, {
            text: '<i class="icon icon-download"></i>&nbsp;' + _('ovenpars_item_start'),
            handler: this.createExport,
            scope: this
        }, {
            xtype: 'label',
            text: 'Состояние:',
            id: 'currentStatus',
            flex: 1
        }, '->', {
            xtype: 'ovenpars-field-search',
            width: 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        }];
    },

    onClick: function (e) {
        var elem = e.getTarget();
        if (elem.nodeName == 'BUTTON') {
            var row = this.getSelectionModel().getSelected();
            if (typeof(row) != 'undefined') {
                var action = elem.getAttribute('action');
                if (action == 'showMenu') {
                    var ri = this.getStore().find('id', row.id);
                    return this._showMenu(this, ri, e);
                }
                else if (typeof this[action] === 'function') {
                    this.menu.record = row.data;
                    return this[action](this, e);
                }
            }
        }
        return this.processEvent('click', e);
    },

    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },

    _doSearch: function (tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    _clearSearch: function () {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg('ovenpars-grid-items', ovenpars.grid.Items);
