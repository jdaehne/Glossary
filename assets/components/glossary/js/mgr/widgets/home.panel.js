Glossary.panel.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        // border: false,
        // baseCls: 'modx-formpanel',
        cls: 'container',
        defaults: {
            collapsible: false,
            autoHeight: true
        },
        items: [{
            html: '<h2>' + _('glossary.management') + '</h2>',
            cls: 'modx-page-header',
            border: false
        }, {
            xtype: 'modx-tabs',
            defaults: {
                border: false,
                autoHeight: true
            },
            border: true,
            items: [{
                title: _('glossary.terms'),
                defaults: {
                    autoHeight: true
                },
                items: [{
                    xtype: 'glossary-grid-terms',
                    cls: 'main-wrapper',
                    preventRender: true
                }]
            }]
        }]
    });
    Glossary.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(Glossary.panel.Home, MODx.Panel);
Ext.reg('glossary-panel-home', Glossary.panel.Home);

