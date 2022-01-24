(function() {


    tinymce.PluginManager.add('pushortcodes', function( editor )
    {

        editor.addButton('pushortcodes', {
            type: 'listbox',
            text: 'WMA Module Code',
            onselect: function(e){
                editor.insertContent(this.value());
            },
            values:[
                { text: 'accordion', value: '[med-accordion id="accordionid"][accordion-item title="title1"][/accordion-item][/med-accordion]' }
            ]
        });
    });


})();



