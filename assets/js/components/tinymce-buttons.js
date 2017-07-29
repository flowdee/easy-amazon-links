(function() {
    tinymce.PluginManager.add( 'columns', function( editor, url ) {

        var button_image_url = url.replace('/public/js/', '/public/img/') + '/tinymce-button.png';

        console.log(button_image_url);

        // https://www.tinymce.com/docs/demo/custom-toolbar-menu-button/

        // Add Button to Visual Editor Toolbar
        editor.addButton('eal', {
            title: 'Easy Amazon Affiliate Link',
            cmd: 'eal-link',
            icon: 'icon eal-tinymce-icon',
            //type: 'menubutton',
            //text: 'Button Text',
            //icon: false,
            //image: button_image_url
            /*
            menu: [{
                text: 'Menu item 1',
                onclick: function() {
                    editor.insertContent('&nbsp;<strong>Menu item 1 here!</strong>&nbsp;');
                }
            }, {
                text: 'Menu item 2',
                onclick: function() {
                    editor.insertContent('&nbsp;<em>Menu item 2 here!</em>&nbsp;');
                }
            }, {
                text: 'test',
                onclick: function() {

                    var text = editor.selection.getContent({'format': 'html'});

                    if ( text && text.length > 0 ) {
                        editor.execCommand('mceInsertContent', false, '<span data-eal-link="true">' + text + '</span>');
                    } else {
                        alert( 'Please select some text.' );
                        return false;
                    }

                    //editor.insertContent('&nbsp;<em>Menu item 3 here!</em>&nbsp;');
                }
            }]
            */
        });

        editor.addCommand('eal-link', function() {

            editor.focus();

            var text = editor.selection.getContent({'format': 'html'});

            if ( text && text.length > 0 ) {
                editor.execCommand('mceInsertContent', false, '<span data-eal-link="true">' + text + '</span>');
            } else {
                alert( 'Please select some text.' );
                return false;
            }

            return false;

            /*
            var selected_text = editor.selection.getContent({
                'format': 'html'
            });
            if ( selected_text.length === 0 ) {
                alert( 'Please select some text.' );
                return;
            }
            var open_column = '<div class="column">';
            var close_column = '</div>';
            var return_text = '';
            return_text = open_column + selected_text + close_column;
            editor.execCommand('mceReplaceContent', false, return_text);
            return;
            */
        });

    });
})();