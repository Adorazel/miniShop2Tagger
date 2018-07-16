<?php
switch ($modx->event->name) {
	case 'OnDocFormPrerender':
		if ($mode !== 'upd') {return '';}
		if (!$modx->getObject('msProduct', $id)) {return '';}
		if (!$template = $resource->get('template')) {return '';}
		$configJs = '
			Ext.ComponentMgr.onAvailable("minishop2-product-settings-panel", function() {
			    this.on("beforerender", function() {
 					var items = [];
					Ext.each(Tagger.groups, function(group) {
						var value = Tagger.tags["tagger-" + group.id];
		                items.push({
		                    xtype: group.field_type
		                    ,fieldLabel: group.name
		                    ,name: "tagger-" + group.id
		                    ,hiddenName: "tagger-" + group.id
		                    ,value: value
		                    ,displayField: "tag"
		                    ,valueField: "tag"
		                    ,fields: ["tag"]
		                    ,url: Tagger.config.connectorUrl
		                    ,allowAdd: group.allow_new
		                    ,allowBlank: group.allow_blank
		                    ,pageSize: 20
		                    ,editable: group.allow_type
		                    ,autoTag: group.show_autotag
		                    ,baseParams: {
		                        action: "mgr/extra/gettags"
		                        ,group: group.id
		                    }
		                });
			        });
			        this.add({
			            title: "Теги",
			            hideMode: "offsets",
			            items: [
			                {
			                	id: "tagger-tag-form",
			                    layout: "column",
			                    border: false,
			                    bodyCssClass: "tab-panel-wrapper ",
			                    style: "padding: 15px;",
			                    items: [{
			                        columnWidth: 1,
			                        xtype: "panel",
			                        border: false,
			                        layout: "form",
			                        labelAlign: "top",
			                        preventRender: true,
			                        items: items
			                    }]
			                }
			            ]
			        });
    			});
			});
		';
		$modx->regClientStartupScript("<script type=\"text/javascript\">\n" . $configJs . "\n</script>", true);
		break;
}
