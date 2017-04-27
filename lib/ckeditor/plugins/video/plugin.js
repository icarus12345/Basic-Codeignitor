/*
* Youtube Embed Plugin
*
* @author Jonnas Fonini <contato@fonini.net>
* @version 1.0.10
*/
var videoPlugin = function() {
	var me = this;
    this.jqxgrid = "#jqxgrid-cke-video";
	this.TYPE = '';
	this.BINDING_URI = base_url + 'cms/vp/video/widgetbinding/';
	this._datafields = [
		{name: 'video_id', type: 'int'},
		{name: 'video_title'},
		{name: 'author_name'},
		{name: 'video_sourceid'},
		{name: 'video_type'},
	];
	this._source = {
        datatype			: "json",
        type 				: "POST",
        datafields 			: this._datafields,
        url 				: this.BINDING_URI + this.TYPE,
        id 					:'video_id',
        root 				: 'rows'
    };
    this._dataAdapter = new $.jqx.dataAdapter(this._source, {
    	autoBind: true,
    	beforeLoadComplete: function (records) {
    		
    	},
        loadError: function(xhr, status, error) {
            addNotice("<b>Status</b>:" + xhr.status + "<br/><b>ThrownError</b>:" + error + "<br/>", 'Error Message!', 'danger');
        }
    });
    this._columns = [
    	{ 
			text: 'Edit', datafield: 'Edit', columntype: 'button', 
			width:50,filterable: false, sortable: false,
    		cellsrenderer: function () {
                     return "Select";
          	}, buttonclick: function (row) {
          		var src;
          		var dataRecord = $(me.jqxgrid).jqxGrid('getrowdata', row);
          		if(dataRecord.video_type == 'youtube'){
          			src = '//youtube.com/v/'+ dataRecord.video_sourceid +'?version=3&f=videos&app=youtube_gdata';
          		}else if(dataRecord.video_type == 'vimeo'){
          			src = '//player.vimeo.com/video/'+ dataRecord.video_sourceid +'?color=a8a8a8';

          		}
          		if(src){
                	var ratio = '56.25';
                	var cls = 'cke-ration-16-9';
                	if(ratio == '56.25') cls='cke-ration-16-9';
                	if(ratio == '75') cls='cke-ration-4-3';
                	if(ratio == '42.8') cls='cke-ration-21-9';
                	var element = me.editor.document.createElement( 'div' );
	                $(element.$).addClass("cke-video");
	                $(element.$).attr('contenteditable','false');
	                $(element.$).html(
	                	'<div class="'+cls+'" data-src="'+src+'">'+
			       			'<iframe src="'+src+'" allowfullscreen></iframe>'+
			      		'</div>'
		      		);
	                me.editor.insertElement( element );
	                me.editor.insertElement( me.editor.document.createElement( 'div' ) );
                	
	            }
                $('#ckeditorVideoDialog').dialog("close");
                me.editor.focus();
          	}
      	// },{
       //      text: '', dataField: 'video_id', width: 60, filterable: false, sortable: true,editable: false,
       //      cellsrenderer: function (row, columnfield, value, defaulthtml, columnproperties) {
       //          var str = "";
       //          if (value && value > 0) {
       //              try {
       //                  str += "<a href='JavaScript:void(0)'"+
       //                  "style='margin: 5px; float: left;' " +
       //                  "onclick=\"authorApp.onSelect(" + value + ");\" "+ 
       //                  "title='Edit :" + value + "'><i class=\"fa fa-pencil-square\"></i></a>\
       //                  ";
       //                  str += "<a href='JavaScript:void(0)'"+ 
       //                  "style='margin: 5px; float: left;' "+
       //                  "onclick=\"_videoPlugin.onViewItem(" + value + ");\" "+
       //                  "title='Delete :" + value + "'><i class=\"fa fa-eye\"></i></a>\
       //                  ";
       //              } catch (e) {
       //              }
       //          }
                
       //          return str;
       //      }
        },{
            text: 'Author', dataField: 'author_name', width: 120, sortable: true,
            columntype: 'textbox', filtertype: 'input',filtercondition: 'CONTAINS',
        },{
            text: 'Title', dataField: 'video_title', minWidth: 220, sortable: true,
            columntype: 'textbox', filtertype: 'input',filtercondition: 'CONTAINS',
        }
    ];
    this.flag = false;
    this.editor;
    this.init = function(editor){
    	me.editor = editor;
        if(this.flag) return;
        this.flag = true;
        $(me.jqxgrid).jqxGrid({
            theme: 'metro',
            width: '100%',
            height: '400',
            source: me._dataAdapter,
            filterable 			: true,
	        autoshowfiltericon	: false,
			sortable 			: true,
			groupable 		    : true,
        	groups              : ['author_name'],
            pageable: true,
            pagesize : 100,
            pagesizeoptions     : [100,200,500,1000],
            autoheight: false,
            columnsresize: false,
            columns: me._columns
        }).on("bindingcomplete", function (event) {
	        $(me.jqxgrid).jqxGrid('expandallgroups');
	    })
    };
    return this;
};
var _videoPlugin = new videoPlugin();
function videoDialog(editor){
	if($('#ckeditorVideoDialog').length==0){
		$('body').append(
			'<div id="ckeditorVideoDialog" style="">'+
				'<div id="jqxgrid-cke-video" style="height:400px"></div>'+
			'</div>'
		);
		uidialog({
	        'message' : $('#ckeditorVideoDialog'),
	        'title': 'Insert Video !',
	        'width':'480px',
	        'type':'notice',
	        'onclose': function(){
	        	editor.focus();
	        }
	    }).open();
		_videoPlugin.init(editor);
	 //    $('#ckeditorVideoRatio').change(function(){
	 //    	$('#ckeditorVideoFrame').css({'padding-bottom':this.value+'%'});
	 //    })
		// $("#video-input-token").tokenInput(
		// 	base_url + "cms/vp/video/searchtoken/",
		// 	{
		// 		tokenLimit: 1,
	 //        	resultsFormatter: function(item){ 
	 //        		return "<li>"  + "<div style='display: inline-block; padding-left: 0px;'>" + item.video_title + "</div></li>" 
	 //        	},
	 //          	tokenFormatter: function(item) { 
	 //          		return "<li><div style='height:20px'>" + item.video_title + " </div></li>" 
	 //          	},
	 //          	onAdd: function (item) {
	 //          		if(item.video_type == 'youtube'){
	 //          			var src = 'http://www.youtube.com/v/'+item.video_sourceid+'?version=3&f=videos&app=youtube_gdata';
	 //          			// var src = 'https://www.youtube.com/embed/' + item.video_sourceid;
  //                   	$('#ckeditorVideoFrame iframe').attr('src',src);
	 //          		}else
  //                   	$('#ckeditorVideoFrame iframe').attr('src','');
  //               },
  //               onDelete: function (item) {
  //                   $('#ckeditorVideoFrame iframe').attr('src','');
  //               }
	 //    	}
	 //    );
	}
	$('#ckeditorVideoDialog').dialog("open");
}
var ckeditorElementSelected;
( function() {
	CKEDITOR.plugins.add( 'video', {
	    icons: 'video',
	    init: function( editor ) {
	    	editor.addCommand( 'video', {
	            exec: function( editor ) {
	            	videoDialog(editor);
	            }
	        });
	        editor.addCommand( 'removeVideo', {
	            exec: function( editor ) {
	                if($(ckeditorElementSelected).parents("div.cke-video").length==1){
	                	$(ckeditorElementSelected).parents("div.cke-video").remove();
	                }
	            }
	        });
	        // editor.addCommand( 'video', new CKEDITOR.dialogCommand( 'videoDialog' ) );
	        editor.ui.addButton( 'Video', {
	            label: 'Insert Video',
	            command: 'video',
	            toolbar: 'youtube',
	            icon : this.path + 'images/film_plus.png'
	        });

	        if ( editor.contextMenu ) {
			    editor.addMenuGroup( 'videoGroup' );
			    editor.addMenuItem( 'videoItem', {
			        label: 'Remove Video',
			        icon: this.path + 'images/film_plus.png',
			        command: 'removeVideo',
			        group: 'videoGroup'
			    });

			    editor.contextMenu.addListener( function( element ) {
			    	ckeditorElementSelected = element.$;
			    	if($(element.$).parents("div.cke-video").length==1)
			    	return { videoItem: CKEDITOR.TRISTATE_OFF };
			    });
			}
	    }
	});
	CKEDITOR.dialog.add( 'videoDialog', function( editor ) {
	    return {
	        title: 'Insert Video',
	        minWidth: 400,
	        minHeight: 200,
	        contents: [
	            {
	                id: 'tab-basic',
	                label: 'Basic Settings',
	                elements: [
	                    
	                    {
	                        type: 'text',
	                        id: 'id',
	                        label: 'Id',

	                        setup: function( element ) {
	                            this.setValue( element.getAttribute( "id" ) );
	                        },

	                        commit: function ( element ) {
	                            var id = this.getValue();
	                            if ( id )
	                                element.setAttribute( 'id', id );
	                            else if ( !this.insertMode )
	                                element.removeAttribute( 'id' );
	                        }
	                    }
	                ]
	                
	            },
	            {
	                id: 'tab-adv',
	                label: 'Advanced Settings',
	                elements: [
	                    {
	                        type: 'text',
	                        id: 'video',
	                        label: 'videoeviation',
	                        validate: CKEDITOR.dialog.validate.notEmpty( "videoeviation field cannot be empty." ),

	                        setup: function( element ) {
	                            this.setValue( element.getText() );
	                        },

	                        commit: function( element ) {
	                            element.setText( this.getValue() );
	                        }
	                    },
	                    {
	                        type: 'text',
	                        id: 'title',
	                        label: 'Explanation',
	                        validate: CKEDITOR.dialog.validate.notEmpty( "Explanation field cannot be empty." ),

	                        setup: function( element ) {
	                            this.setValue( element.getAttribute( "title" ) );
	                        },

	                        commit: function( element ) {
	                            element.setAttribute( "title", this.getValue() );
	                        }
	                    }
	                ]
	            }
	        ],
	        onOk: function() {
	            var dialog = this;
	            var video = this.element;
	            this.commitContent( video );
	            console.log(video)
	            if ( this.insertMode )
	                editor.insertElement( video );
	        },onShow: function() {
			    var selection = editor.getSelection();
	            var element = selection.getStartElement();
	            if ( element )
	                element = element.getAscendant( 'video', true );

	            if ( !element || element.getName() != 'video' ) {
	                //element = editor.document.createElement( 'video' );
	                element = editor.document.createElement( 'div' );
	                element.setAttribute('class',"video");
	                this.insertMode = true;
	            }
	            else
	                this.insertMode = false;

	            this.element = element;
	            console.log(element)
	            if ( !this.insertMode )
	                this.setupContent( this.element );
			},
	    };
	});
})();
