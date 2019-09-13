<?php
namespace Sleek\Tinymce;

#############
# Clean paste
# https://sundari-webdesign.com/wordpress-removing-classes-styles-and-tag-attributes-from-pasted-content/
add_filter('tiny_mce_before_init', function ($in) {
	$in['paste_preprocess'] = "function (pl, o) {
		// remove the following tags completely:
		o.content = o.content.replace(/<\/*(form|applet|area|article|aside|audio|base|basefont|bdi|bdo|body|button|canvas|command|datalist|details|embed|figcaption|figure|font|footer|frame|frameset|head|header|hgroup|hr|html|iframe|img|keygen|link|map|mark|menu|meta|meter|nav|noframes|noscript|object|optgroup|output|param|progress|rp|rt|ruby|script|section|source|span|style|summary|time|title|track|video|wbr)[^>]*>/gi,'');

		// remove all attributes from these tags:
		o.content = o.content.replace(/<(div|table|tbody|tr|td|th|p|b|font|strong|i|em|h1|h2|h3|h4|h5|h6|hr|ul|li|ol|code|blockquote|address|dir|dt|dd|dl|big|cite|del|dfn|ins|kbd|q|samp|small|s|strike|sub|sup|tt|u|var|caption) [^>]*>/gi,'<$1>');

		// keep only href in the a tag (needs to be refined to also keep _target and ID):
		o.content = o.content.replace(/<a [^>]*href=(\"|')(.*?)(\"|')[^>]*>/gi,'<a href=\"$2\">');

		// replace br tag with p tag:
		if (o.content.match(/<br[\/\s]*>/gi)) {
			o.content = o.content.replace(/<br[\s\/]*>/gi,'</p><p>');
		}

		// replace div tag with p tag:
		o.content = o.content.replace(/<(\/)*div[^>]*>/gi,'<$1p>');

		// remove double paragraphs:
		o.content = o.content.replace(/<\/p>[\s\\r\\n]+<\/p>/gi,'</p></p>');
		o.content = o.content.replace(/<\<p>[\s\\r\\n]+<p>/gi,'<p><p>');
		o.content = o.content.replace(/<\/p>[\s\\r\\n]+<\/p>/gi,'</p></p>');
		o.content = o.content.replace(/<\<p>[\s\\r\\n]+<p>/gi,'<p><p>');
		o.content = o.content.replace(/(<\/p>)+/gi,'</p>');
		o.content = o.content.replace(/(<p>)+/gi,'<p>');
	}";

	return $in;
});

#########################################
# Add the styleselect dropdown to TinyMCE
add_filter('mce_buttons_2', function ($buttons) {
	array_unshift($buttons, 'styleselect');

	return $buttons;
});

###########################
# Disable colors in WYSIWYG
add_filter('mce_buttons_2', function ($buttons) {
	if (($key = array_search('forecolor', $buttons)) !== false) {
		unset($buttons[$key]);
	}

	return $buttons;
});
