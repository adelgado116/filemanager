<?php
require_once('bbcode.php');
$bbcode = new bbcode();
$bbcode->add_tag(array('Name'=>'b','HtmlBegin'=>'<span style="font-weight: bold;">','HtmlEnd'=>'</span>'));
$bbcode->add_tag(array('Name'=>'i','HtmlBegin'=>'<span style="font-style: italic;">','HtmlEnd'=>'</span>'));
$bbcode->add_tag(array('Name'=>'u','HtmlBegin'=>'<span style="text-decoration: underline;">','HtmlEnd'=>'</span>'));
$bbcode->add_tag(array('Name'=>'link','HasParam'=>true,'HtmlBegin'=>'<a href="%%P%%">','HtmlEnd'=>'</a>'));
$bbcode->add_tag(array('Name'=>'color','HasParam'=>true,'ParamRegex'=>'[A-Za-z0-9#]+','HtmlBegin'=>'<span style="color: %%P%%;">','HtmlEnd'=>'</span>','ParamRegexReplace'=>array('/^[A-Fa-f0-9]{6}$/'=>'#$0')));
$bbcode->add_tag(array('Name'=>'email','HasParam'=>true,'HtmlBegin'=>'<a href="mailto:%%P%%">','HtmlEnd'=>'</a>'));
$bbcode->add_tag(array('Name'=>'size','HasParam'=>true,'HtmlBegin'=>'<span style="font-size: %%P%%pt;">','HtmlEnd'=>'</span>','ParamRegex'=>'[0-9]+'));
$bbcode->add_tag(array('Name'=>'bg','HasParam'=>true,'HtmlBegin'=>'<span style="background: %%P%%;">','HtmlEnd'=>'</span>','ParamRegex'=>'[A-Za-z0-9#]+'));
$bbcode->add_tag(array('Name'=>'s','HtmlBegin'=>'<span style="text-decoration: line-through;">','HtmlEnd'=>'</span>'));
$bbcode->add_tag(array('Name'=>'align','HtmlBegin'=>'<div style="text-align: %%P%%">','HtmlEnd'=>'</div>','HasParam'=>true,'ParamRegex'=>'(center|right|left)'));
$bbcode->add_alias('url','link');
/* This outputs:
<span style="font-weight: bold;">Bold text</span>
<span style="font-style: italic;">Italic text</span>
<span style="text-decoration: underline;">Underlinex text</span>
<a href="http://phpclasses.org/">A link</a>
<a href="http://phpclasses.org/">Another link</a>
<span style="color: red;">Red text</span>
<a href="mailto:eurleif@ecritters.biz">Email me!</a>
<span style="font-size: 20pt;">20-point text</span>
<span style="background: red;">Text with a red background</span>
<span style="text-decoration: line-through;">Text with a line through it</span>
<div style="text-align: center">Centered text</div>
*/
print $bbcode->parse_bbcode('[b]Bold text[/b]
[i]Italic text[/i]
[u]Underlinex text[/u]
[link=http://phpclasses.org/]A link[/link]
[url=http://phpclasses.org/]Another link[/url]
[color=red]Red text[/color]
[email=eurleif@ecritters.biz]Email me![/email]
[size=20]20-point text[/size]
[bg=red]Text with a red background[/bg]
[s]Text with a line through it[/s]
[align=center]Centered text[/align]');
?>