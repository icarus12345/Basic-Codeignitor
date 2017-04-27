/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
if (typeof(base_url) != "string")
    base_url = '/';
// CKEDITOR.timestamp='19001';
CKEDITOR.config.autoParagraph = false;
CKEDITOR.editorConfig = function(config) {
    config.enterMode = CKEDITOR.ENTER_DIV;
    config.extraAllowedContent = '*(*)';
    // config.enterMode = CKEDITOR.ENTER_BR;
    config.extraPlugins = 'tableresize,imagepaste,youtube';
    //config.removePlugins = 'magicline,save,newpage,preview,print,find,forms,selectall,about,iframe';
    config.toolbar = [
        {name: 'Source', items: ['Source']},
        //{name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
        //{name: 'clipboard'/*, groups: ['clipboard', 'undo']*/, items: [/*'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',*/ 'Undo', 'Redo']},
        //{name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
        //{name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
        {name: 'tools', items: ['Maximize', 'ShowBlocks']},
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
        
        '/',
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
        {name: 'links', items: ['Link', 'Unlink' /*, 'Anchor'*/]},
        {name: 'insert', items: ['Image', 'Youtube','Flash','youtube', 'Table', 'HorizontalRule', 'Smiley'/*, 'SpecialChar', 'PageBreak', 'Iframe'*/]},
        '/',
        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
        {name: 'colors', items: ['TextColor', 'BGColor']},
        {name: 'others', items: ['-']},
        //{name: 'about', items: ['About']}
    ];

// Toolbar groups configuration.
    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
        {name: 'forms'},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
        {name: 'links'},
        {name: 'insert'},
        '/',
        {name: 'styles'},
        {name: 'colors'},
        //{name: 'tools'},
        {name: 'others'},
        {name: 'about'}
    ];
    // Define changes to default configuration here. For example:
    config.language = 'en';
    // config.uiColor = '#AADC6E';
    config.stylesSet = 'default:' + base_url + 'libraries/ckeditor/styles.js';
    config.filebrowserBrowseUrl = base_url + 'libraries/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = base_url + 'libraries/kcfinder/browse.php?type=image';
    config.filebrowserFlashBrowseUrl = base_url + 'libraries/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl = base_url + 'libraries/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = base_url + 'libraries/kcfinder/upload.php?type=image';
    config.filebrowserFlashUploadUrl = base_url + 'libraries/kcfinder/upload.php?type=flash';
    // config.contentsCss = ['/assets/bootstrap/css/bootstrap.css','/assets/css/nta.css'];
    return config;
};
CKEDITOR.stylesSet.add('default', [
    /* Block Styles */

    // These styles are already available in the "Format" combo ("format" plugin),
    // so they are not needed here by default. You may enable them to avoid
    // placing the "Format" combo in the toolbar, maintaining the same features.
    {name: 'Paragraph', element: 'div', attributes: {'class': 'ckeditor-paragraph'}},
    {name: 'Heading I', element: 'h1', attributes: {'class': 'ckeditor-title-level-one'}},
    {name: 'Heading II', element: 'h2', attributes: {'class': 'ckeditor-title-level-two'}},
    {name: 'Heading III', element: 'h3', attributes: {'class': 'ckeditor-title-level-three'}},
    {name: 'Heading IV', element: 'h4', attributes: {'class': 'ckeditor-title-level-four'}},
    {name: 'Heading V', element: 'h5', attributes: {'class': 'ckeditor-title-level-five'}},
    /*
     { name: 'Heading 5',		element: 'h5' },
     { name: 'Heading 6',		element: 'h6' },
     { name: 'Preformatted Text',element: 'pre' },
     { name: 'Address',			element: 'address' },
     */
    //{ name: 'Image Style(Center)',		element: 'div' , styles: { 'display': 'block' ,'margin':'0 auto','text-align':'center'} },
    {name: 'Italic Title', element: 'h2', styles: {'font-style': 'italic'}},
    {name: 'Subtitle', element: 'h3', styles: {'color': '#aaa', 'font-style': 'italic'}},
    {
        name: 'Special Container',
        element: 'div',
        styles: {
            padding: '5px 10px',
            background: '#eee',
            border: '1px solid #ccc'
        }
    },
    /* Inline Styles */

    // These are core styles available as toolbar buttons. You may opt enabling
    // some of them in the Styles combo, removing them from the toolbar.
    // (This requires the "stylescombo" plugin)
    /*
     { name: 'Strong',			element: 'strong', overrides: 'b' },
     { name: 'Emphasis',			element: 'em'	, overrides: 'i' },
     { name: 'Underline',		element: 'u' },
     { name: 'Strikethrough',	element: 'strike' },
     { name: 'Subscript',		element: 'sub' },
     { name: 'Superscript',		element: 'sup' },
     */

    { name: 'Highlighting',			element: 'span', attributes: { 'class': 'highlighting' } },
    { name: 'Highlighting 2',		element: 'span', attributes: { 'class': 'highlighting2' } },
    { name: 'Highlighting 3',		element: 'span', attributes: { 'class': 'highlighting3' } },
    { name: 'Marker Color',		element: 'span', attributes: { 'class': 'marker' } },
    { name: 'Marker Color 2',		element: 'span', attributes: { 'class': 'marker2' } },
    { name: 'Marker Color 3',		element: 'span', attributes: { 'class': 'marker3' } },
    {name: '1', element: 'span', attributes: {'class': 'no-number'}},
    {name: 'No', element: 'span', attributes: {'class': 'no-rank'}},
    {name: 'First Chart', element: 'span', attributes: {'class': 'first-chart'}},
    {name: 'Big', element: 'big'},
    {name: 'Small', element: 'small'},
    {name: 'Typewriter', element: 'tt'},
    {name: 'Computer Code', element: 'code'},
    {name: 'Keyboard Phrase', element: 'kbd'},
    {name: 'Sample Text', element: 'samp'},
    {name: 'Variable', element: 'var'},
    {name: 'Deleted Text', element: 'del'},
    {name: 'Inserted Text', element: 'ins'},
    {name: 'Cited Work', element: 'cite'},
    {name: 'Inline Quotation', element: 'q'},
    {name: 'Language: RTL', element: 'span', attributes: {'dir': 'rtl'}},
    {name: 'Language: LTR', element: 'span', attributes: {'dir': 'ltr'}},
    /* Object Styles */
    {
        name: 'Styled image (Center)',
        element: 'img',
        attributes: {'class': 'center'}
    },
    {
        name: 'Styled image (left)',
        element: 'img',
        attributes: {'class': 'left'}
    },
    {
        name: 'Styled image (right)',
        element: 'img',
        attributes: {'class': 'right'}
    },
    {
        name: 'Compact table',
        element: 'table',
        attributes: {
            cellpadding: '5',
            cellspacing: '0',
            border: '1',
            bordercolor: '#ccc'
        },
        styles: {
            'border-collapse': 'collapse'
        }
    },
    {name: 'Borderless Table', element: 'table', styles: {'border-style': 'hidden', 'background-color': '#E6E6FA'}},
    {name: 'Table - I', element: 'table', attributes: {'class': 'table-one'}},
    {name: 'Table - II', element: 'table', attributes: {'class': 'table-two'}},
    {name: 'Square Bulleted List', element: 'ul', styles: {'list-style-type': 'square'}}
]);