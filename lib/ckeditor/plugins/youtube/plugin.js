/*
* Youtube Embed Plugin
*
* @author Jonnas Fonini <contato@fonini.net>
* @version 1.0.10
*/
( function() {
	CKEDITOR.plugins.add( 'youtube',
	{
		lang: [ 'en', 'pt', 'ja', 'hu', 'it', 'fr', 'tr', 'ru', 'de', 'ar', 'nl', 'pl', 'vi'],
		init: function( editor )
		{
			editor.addCommand( 'youtube', new CKEDITOR.dialogCommand( 'youtube', {
				allowedContent: 'iframe[!width,!height,!src,!frameborder,!allowfullscreen]; object param[*]'
			}));

			editor.ui.addButton( 'Youtube',
			{
				label : editor.lang.youtube.button,
				toolbar : 'insert',
				command : 'youtube',
				icon : this.path + 'images/icon.png'
			});

			CKEDITOR.dialog.add( 'youtube', function ( instance )
			{
				var video;

				return {
					title : editor.lang.youtube.title,
					minWidth : 500,
					minHeight : 200,
					contents :
						[{
							id : 'youtubePlugin',
							expand : true,
							elements :
								[
								/*{
									id : 'txtEmbed',
									type : 'textarea',
									label : editor.lang.youtube.txtEmbed,
									autofocus : 'autofocus',
									onChange : function ( api )
									{
										handleEmbedChange( this, api );
									},
									onKeyUp : function ( api )
									{
										handleEmbedChange( this, api );
									},
									validate : function ()
									{
										if ( this.isEnabled() )
										{
											if ( !this.getValue() )
											{
												alert( editor.lang.youtube.noCode );
												return false;
											}
											else
											if ( this.getValue().length === 0 || this.getValue().indexOf( '//' ) === -1 )
											{
												alert( editor.lang.youtube.invalidEmbed );
												return false;
											}
										}
									}
								},
								{
									type : 'html',
									html : editor.lang.youtube.or + '<hr>'
								},
								*/
								{
									type : 'hbox',
									widths : [ '70%', '15%', '15%' ],
									children :
									[
										{
											id : 'txtUrl',
											type : 'text',
											label : editor.lang.youtube.txtUrl,
											onChange : function ( api )
											{
												handleLinkChange( this, api );
											},
											onKeyUp : function ( api )
											{
												handleLinkChange( this, api );
											},
											validate : function ()
											{
												if ( this.isEnabled() )
												{
													if ( !this.getValue() )
													{
														alert( editor.lang.youtube.noCode );
														return false;
													}
													else{
														video = ytVidId(this.getValue());

														if ( this.getValue().length === 0 ||  video === false)
														{
															alert( editor.lang.youtube.invalidUrl );
															return false;
														}
													}
												}
											}
										},
										{
											type : 'text',
											id : 'txtWidth',
											width : '60px',
											label : editor.lang.youtube.txtMaxWidth,
											'default' : editor.config.youtube_width != null ? editor.config.youtube_width : '640',
											validate : function ()
											{
												if ( this.getValue() )
												{
													var width = parseInt ( this.getValue() ) || 0;

													if ( width === 0 )
													{
														alert( editor.lang.youtube.invalidWidth );
														return false;
													}
												}
												else {
													alert( editor.lang.youtube.noWidth );
													return false;
												}
											}
										},
										/*{
											type : 'text',
											id : 'txtHeight',
											width : '60px',
											label : editor.lang.youtube.txtHeight,
											'default' : editor.config.youtube_height != null ? editor.config.youtube_height : '',
											validate : function ()
											{
												/*if ( this.getValue() )
												{
													var height = parseInt ( this.getValue() ) || 0;

													if ( height === 0 )
													{
														alert( editor.lang.youtube.invalidHeight );
														return false;
													}
												}
												else {
													alert( editor.lang.youtube.noHeight );
													return false;
												}* /
											}
										},*/
										{
											'type':'select',
											'id':'selectorRatito',
											'width' : '60px',
											'label' : editor.lang.youtube.txtRatio,
                                                                                        'default': 42.88,
											'items' : [
												[ '4:3', 75 ],
												[ '16:9', 56.25],
												[ '21:9', 42.88 ],
												[ '1:1', 100 ]
											]
											
										}
									]
								},
								{
									type : 'hbox',
									widths : [ '55%', '45%' ],
									children :
									[
										{
											id : 'chkRelated',
											type : 'checkbox',
											'default' : editor.config.youtube_related != null ? editor.config.youtube_related : true,
											label : editor.lang.youtube.chkRelated
										},
										{
											id : 'chkOlderCode',
											type : 'checkbox',
											'default' : editor.config.youtube_older != null ? editor.config.youtube_older : false,
											label : editor.lang.youtube.chkOlderCode
										}
									]
								},
								{
									type : 'hbox',
									widths : [ '55%', '45%' ],
									children :
									[
										{
											id : 'chkPrivacy',
											type : 'checkbox',
											label : editor.lang.youtube.chkPrivacy,
											'default' : editor.config.youtube_privacy != null ? editor.config.youtube_privacy : false
										},
										{
											id : 'chkAutoplay',
											type : 'checkbox',
											'default' : editor.config.youtube_autoplay != null ? editor.config.youtube_autoplay : false,
											label : editor.lang.youtube.chkAutoplay
										}
									]
								},
								{
									type : 'hbox',
									widths : [ '45%', '55%'],
									children :
									[
										{
											id : 'txtStartAt',
											type : 'text',
											label : editor.lang.youtube.txtStartAt,
											validate : function ()
											{
												if ( this.getValue() )
												{
													var str = this.getValue();

													if ( !/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/i.test( str ) )
													{
														alert( editor.lang.youtube.invalidTime );
														return false;
													}
												}
											}
										},
										{
											id: 'empty',
											type: 'html',
											html: ''
										}
									]
								}
							]
						}
					],
					onOk: function()
					{
						var content = '';

						//if ( this.getContentElement( 'youtubePlugin', 'txtEmbed' ).isEnabled() )
						//{
						//	content = this.getValueOf( 'youtubePlugin', 'txtEmbed' );
						//}
						//else {
							var url = '//', params = [], startSecs;
							var width = this.getValueOf( 'youtubePlugin', 'txtWidth' );
							//var height = this.getValueOf( 'youtubePlugin', 'txtHeight' );
							var ratito = this.getValueOf( 'youtubePlugin', 'selectorRatito' );
							if ( this.getContentElement( 'youtubePlugin', 'chkPrivacy' ).getValue() === true )
							{
								url += 'www.youtube-nocookie.com/';
							}
							else {
								url += 'www.youtube.com/';
							}

							url += 'embed/' + video;

							if ( this.getContentElement( 'youtubePlugin', 'chkRelated' ).getValue() === false )
							{
								params.push('rel=0');
							}

							if ( this.getContentElement( 'youtubePlugin', 'chkAutoplay' ).getValue() === true )
							{
								params.push('autoplay=1');
							}

							startSecs = this.getValueOf( 'youtubePlugin', 'txtStartAt' );
							if ( startSecs ){
								var seconds = hmsToSeconds( startSecs );

								params.push('start=' + seconds);
							}

							if ( params.length > 0 )
							{
								url = url + '?' + params.join( '&' );
							}

							if ( this.getContentElement( 'youtubePlugin', 'chkOlderCode' ).getValue() === true )
							{
								url = url.replace('embed/', 'v/');
								url = url.replace(/&/g, '&amp;');

								if ( url.indexOf('?')== -1 )
								{
									url += '?';
								}
								else {
									url += '&amp;';
								}
								url += 'hl=pt_BR&amp;version=3';
								content =  '<div class="ratito" style="margin:0 auto;max-width:'+width+'px;position:relative;"><div style="position:relative;height:0;padding-bottom:'+ratito+'%">';
								content = '<object style="position:absolute;top:0;left:0;width:100%;height:100%" >';
								content += '<param name="movie" value="' + url + '"></param>';
								content += '<param name="allowFullScreen" value="true"></param>';
								content += '<param name="allowscriptaccess" value="always"></param>';
								content += '<embed src="' + url + '" type="application/x-shockwave-flash" ';
								content += 'style="position:absolute;top:0;left:0;width:100%;height:100%" allowscriptaccess="always" ';
								content += 'allowfullscreen="true"></embed>';
								content += '</object>';
								content += '</div></div><p></p>';
							}
							else {
								content =  '<div class="ratito" style="margin:0 auto;max-width:'+width+'px;position:relative;"><div style="position:relative;height:0;padding-bottom:'+ratito+'%">';
								content += '<iframe style="position:absolute;top:0;left:0;width:100%;height:100%" src="' + url + '" ';
								content += 'frameborder="0" allowfullscreen></iframe>';
								content += '</div></div><p></p>';
							}
						//}

						var instance = this.getParentEditor();
						instance.insertHtml( content );
					}
				};
			});
		}
	});
})();

function handleLinkChange( el, api )
{
	if ( el.getValue().length > 0 )
	{
		el.getDialog().getContentElement( 'youtubePlugin', 'txtEmbed' ).disable();
	}
	else {
		el.getDialog().getContentElement( 'youtubePlugin', 'txtEmbed' ).enable();
	}
}

function handleEmbedChange( el, api )
{
	if ( el.getValue().length > 0 )
	{
		el.getDialog().getContentElement( 'youtubePlugin', 'txtUrl' ).disable();
	}
	else {
		el.getDialog().getContentElement( 'youtubePlugin', 'txtUrl' ).enable();
	}
}


/**
 * JavaScript function to match (and return) the video Id
 * of any valid Youtube Url, given as input string.
 * @author: Stephan Schmitz <eyecatchup@gmail.com>
 * @url: http://stackoverflow.com/a/10315969/624466
 */
function ytVidId( url )
{
	var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
	return ( url.match( p ) ) ? RegExp.$1 : false;
}

/**
 * Converts time in hms format to seconds only
 */
function hmsToSeconds( time )
{
	var arr = time.split(':'), s = 0, m = 1;

	while (arr.length > 0)
	{
		s += m * parseInt(arr.pop(), 10);
		m *= 60;
	}

	return s;
}
