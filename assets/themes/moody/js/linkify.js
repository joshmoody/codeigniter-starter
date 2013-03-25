/**
	Replace URLS in text strings with hyperlinks.  Also replaces twitter #hashtags and @usernames with the appropriate links
	inputText: Text string to linkify
*/
(function( $ ) {

	$.fn.linkify = function() {
	
		this.each(function() {
			var $this = $(this);
			var inputText = $this.html();
			if (typeof(inputText) == 'undefined'){
				return inputText;
			}
			
			var replaceText, replacePattern1, replacePattern2, replacePattern3, hashtagPattern, userPattern;
			
			// URLs starting with http://, https://, or ftp://
			replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
			replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank">$1</a>');
			
			// URLs starting with www. (without // before it, or it'd re-link the ones done above)
			replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
			replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');
			
			// Change email addresses to mailto:: links
			replacePattern3 = /(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})/gim;
			replacedText = replacedText.replace(replacePattern3, '<a href="mailto:$1">$1</a>');
		
			// Change twitter hashtags to search link
			hashtagPattern = /(^|\s)#(\w+)/g;
			
			replacedText = replacedText.replace(hashtagPattern, '$1<a href="https://www.twitter.com/search?q=%23$2">#$2</a>');
		
			// Change twitter @usernames to links
			userPattern = /(^|\s)@(\w+)/g;
			replacedText = replacedText.replace(userPattern, '$1<a href="https://www.twitter.com/$2">@$2</a>');
			
			$this.html(replacedText);
		});
	
	};
})( jQuery );
