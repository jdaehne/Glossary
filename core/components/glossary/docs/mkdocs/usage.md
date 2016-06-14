## Introduction
This MODX Extra adds a custom manager page that allows you to create & maintain
a list of explanations for key terms in your site. Entries into the glossary 
take the form of `term => explanation` where `term` is the phrase being 
described and `explanation` is the description of said term.

Included in the package is a snippet called Glossary which will output the 
glossary terms to a resource page. The snippet is fully templatable using 
chunks specified as optional parameters to the snippet call, and various 
features can be turned on or off in the same manner.

## Snippet
This snippet outputs a list of terms and explanations, ordered alphabetically 
and grouped by first letter. It also ouputs a navigation list of links at the 
top of the glossary list to allow a user to jump to a specific letter.
The following properties could be set in the snippet call:

Property | Description | Default
---------|-------------|--------
showNav | Show the letter nav at the top of the list. | Yes
outerTpl | Template chunk for glossary outer wrapper. | Glossary.listOuterTpl
groupTpl | Template chunk for glossary item group. | Glossary.listGroupTpl
termTpl | Template chunk for glossary term items. | Glossary.listItemTpl
navOuterTpl | Template chunk for outer nav-bar wrapper. | Glossary.navOuterTpl
navItemTpl | Template chunk for each item in the nav-bar. | Glossary.navItemTpl

## Plugin
The Highlighter plugin parses page content field on render and replaces all
occurrences of terms with markup defined in the plugin's tpl chunk. This can be
used to provide a link directly to the glossary entry for that term. The Plugin 
could be controlled by the following MODX System settings:

Setting | Description | Default
------------|---------|--------
debug | Log debug information in the MODX error log. | No
fullwords | Replace only full words of a glossary term in the resource content. | Yes
resid | ID of a resource containing a Glossary snippet call. | 0
tpl | Template Chunk for the highlight replacement. | Glossary.highlighterTpl
sections | Replace glossary terms only in sections marked with &lt;!— GlossaryStart --&gt;&lt;!— GlossaryEnd --&gt;. | False

## Available placeholders
The following placeholders are available in the chunks used by the snippet and
the plugin:

Placeholder | Description | Chunk
------------|-------------|------
link | Link url including hash anchor. | highlighterTpl
groups | The list of term groups. | outerTpl
items | The list of terms. | groupTpl
anchor | The anchor for the term being referenced. | listItemTpl
term | The term being referenced. | listItemTpl, highlighterTpl
explanation | The explanation for this term. | listItemTpl, highlighterTpl
letters | The list of letters in the letter nav. | navOuterTpl
letter | One letter in the letter nav. | groupTpl, navItemTpl

The default chunks for these placeholders are available with the `Glossary.`
prefix. If you want to change the chunks, you have to duplicate them and
change the duplicates. The default chunks are reset with each update of the 
Glossary extra.
