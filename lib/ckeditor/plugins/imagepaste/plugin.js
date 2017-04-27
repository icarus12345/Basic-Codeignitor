/*
 * @file image paste plugin for CKEditor
	Feature introduced in: https://bugzilla.mozilla.org/show_bug.cgi?id=490879
	doesn't include images inside HTML (paste from word): https://bugzilla.mozilla.org/show_bug.cgi?id=665341
 * Copyright (C) 2011-13 Alfonso Martínez de Lizarrondo
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 */

 // Handles image pasting in Firefox
CKEDITOR.plugins.add( 'imagepaste',
{
	init : function( editor )
	{

		// Paste from clipboard:
		editor.on( 'paste', function(e) {
			var data = e.data,
				html = (data.html || ( data.type && data.type=='html' && data.dataValue));
			if (!html)
				return;

			// strip out webkit-fake-url as they are useless:
			if (CKEDITOR.env.webkit && (html.indexOf("webkit-fake-url")>0) )
			{
				alert("Sorry, the images pasted with Safari aren't usable");
				return;
			}

			// Replace data: images in Firefox and upload them
			html = html.replace( /<img src="data:image\/png;base64,.*?" alt="">/g, function( img )
				{
					var data = img.match(/"data:image\/png;base64,(.*?)"/)[1];
					var id = CKEDITOR.tools.getNextId();

					var url= editor.config.filebrowserImageUploadUrl + '&CKEditor=' + editor.name + '&CKEditorFuncNum=2&langCode=' + editor.langCode;
					url = '/libraries/kcfinder/clipboard.php';
					var xhr = new XMLHttpRequest();
					xhr.open("POST", url);
					xhr.onload = function() {
						console.log(xhr.responseText)
						serverResponse = JSON.parse(xhr.responseText);
						if(serverResponse.result !=undefined &&  serverResponse.result>=0){
							var theImage = editor.document.getById( id );
							theImage.data( 'cke-saved-src', serverResponse.imgpath);
							theImage.setAttribute( 'src', serverResponse.imgpath);
							theImage.removeAttribute( 'id' );
							//window.parent.CKEDITOR.currentInstance.getIndex().insertHTML(img);
						}else{
							//window.parent.WarningMsg(serverResponse.message);
							alert(serverResponse.message)
						}
						// Upon finish, get the url and update the file
						
					}
					var formData = new FormData();
					formData.append('base64imagestring',data);
					xhr.send(formData);
					return img.replace(/>/, ' id="' + id + '">')
				});

			if (e.data.html)
				e.data.html = html;
			else
				e.data.dataValue = html;
		});

	} //Init
} );
