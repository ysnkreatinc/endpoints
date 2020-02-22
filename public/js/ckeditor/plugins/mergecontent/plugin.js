CKEDITOR.plugins.add('mergecontent', {
    requires: ['richcombo'],
    init: function (editor) {
        if (!('mergeContent' in editor.config)) return;
        if (!editor.config.mergeContent.length) return;

        // build the list.
        editor.ui.addRichCombo('mergecontent', {
            label: 'Merge Content',
            title: 'Merge Content',
            className: 	'cke_format',
            panel: {
                css: [ editor.config.contentsCss, CKEDITOR.skin.getPath('editor') ],
                voiceLabel: editor.lang.panelVoiceLabel
            },
            init: function () {
                var self = this;
                editor.config.mergeContent.forEach(function (item) {
                    if (item.isHeader) {
                        self.startGroup(item.name);
                    } else {
                        self.add(item.value, item.name, item.label || item.name);
                    }
                });
            },
            onClick: function(value) {
                editor.focus();
                editor.fire( 'saveSnapshot' );
                editor.insertHtml(value);
                editor.fire( 'saveSnapshot' );
            }
        });
    }
});
