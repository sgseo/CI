KISSY.Editor.add("htmlparser",function(){function h(){this._={htmlPartsRegex:RegExp("<(?:(?:\\/([^>]+)>)|(?:!--([\\S|\\s]*?)--\>)|(?:([^\\s>]+)\\s*((?:(?:[^\"'>]+)|(?:\"[^\"]*\")|(?:'[^']*'))*)\\/?>))","g")}}var k=KISSY,f=function(){},i=k.Editor,n=/([\w\-:.]+)(?:(?:\s*=\s*(?:(?:"([^"]*)")|(?:'([^']*)')|([^\s>]+)))|(?=\s|$))/g,o={checked:1,compact:1,declare:1,defer:1,disabled:1,ismap:1,multiple:1,nohref:1,noresize:1,noshade:1,nowrap:1,readonly:1,selected:1},l=i.XHTML_DTD;k.augment(h,{onTagOpen:f,onTagClose:f,
onText:f,onCDATA:f,onComment:f,parse:function(g){for(var b,a,d=0,c;b=this._.htmlPartsRegex.exec(g);){a=b.index;if(a>d){d=g.substring(d,a);c?c.push(d):this.onText(d)}d=this._.htmlPartsRegex.lastIndex;if(a=b[1]){a=a.toLowerCase();if(c&&l.$cdata[a]){this.onCDATA(c.join(""));c=null}if(!c){this.onTagClose(a);continue}}if(c)c.push(b[0]);else if(a=b[3]){a=a.toLowerCase();if(!/="/.test(a)){var m={},e;b=b[4];var p=!!(b&&b.charAt(b.length-1)=="/");if(b)for(;e=n.exec(b);){var j=e[1].toLowerCase();e=e[2]||e[3]||
e[4]||"";m[j]=!e&&o[j]?j:e}this.onTagOpen(a,m,p);if(!c&&l.$cdata[a])c=[]}}else if(a=b[2])this.onComment(a)}g.length>d&&this.onText(g.substring(d,g.length))}});i.HtmlParser=h;i.HtmlParser=h});
