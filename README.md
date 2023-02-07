# What the Hanzi? (An introduction)

HanziVG aims to become to Chinese (Traditonal and Simplified) Hanzi characters what [KanjiVG](https://github.com/KanjiVG/kanjivg) is to Japanese Kanji: A colllection of SVG stroke order files that also incorporates some meta information like radicals / character components. In fact, the project will indeed be heavily based on KanjiVG, as many characters can be used without or with little alteration. It will also make use of the great work by François Mizessyn at [AnimHanzi](http://gooo.free.fr/animHanzi/), who created all characters of the HSK1-3 characters and some more.

## KanjiVG compatibility

The SVGs will make use of the kvg namespace defined by KanjiVG. But the structure of this project will be completely different. The reason for this is that KanjiVG is not really well documented (the readme talks about an SVG and XML directory, but that structure seems to have been changed) and being no expert in Python, which all the build and maintenance scripts of KanjiVG are written in, left me a bit overwhelmed.

To get started, HanziVG will use PHP scripts, but I'll probably switch to node/npm as soon as I feel more comfortable using it for a from-scratch project.

## Traditional vs Simplified characters

I will first start with simplified characters, because that's what I currently need while learning Mandarin.
You can read a great (yet short and easy to understand!) article about Simplified and Traditional characters and the Han unification in Unicode here: https://r12a.github.io/scripts/chinese/
But I definitely want this to be usable for traditional Hanzi just the same. So just like KanjiVG has variants of the same character as different files, so will HanziVG. (Still have to think about a naming convention, probably charcode-trad.svg or charcode-traditional.svg)

## Why is this needed at all and can not just be added on top of KanjiVG?

Seriously, read the article I mentioned above - it's not that long! :) There are some differences in the way Chinese characters are written, even if they look exactly or almost the same. Stroke order or direction might be different, for example. And from what I found while researching if it's worth to start this at all, the people behind KanjiVG have made it clear that they want to stick with Kanji only and won't have any extensions to Hanzi. That's also the reason why I didn't just fork it, but chose to start from scratch (well, not completely) instead.

# Project structure and work process

The /kanji directory holds all the KanjiVG files as of [1eaef89b17e088f14a13cbb7091607b2ba0530fb](https://github.com/KanjiVG/kanjivg/commit/1eaef89b17e088f14a13cbb7091607b2ba0530fb) (checked in to HanziVG on 8 June 2018). The /hanzi directory will hold all the new and verified SVG files, the "real" HanziVG files. Files should be moved from /kanji to /hanzi after verification and files that are not re-usable should be deleted from kanji, thus eventually leading to the kanji directory being empty and deleted (well, that will take a while...). New files MUST be added to /hanzi, not /kanji. In the meantime, any script/software or whatever using HanziVG can use the Kanji as a fallback - first looking for the file(s) in /hanzi, then falling back to /kanji.

The same appllies to the /animhanzi folder - it currently contains the HSK1-3 sets as provided on the website. I have contacted François regarding the rest, but not yet heard back from him. Those could also be extracted from the demo on the website, but they are served via a PHP script and are missing all the group/radical information.

The file naming convention (the character's unicode encoding in hexadecimal) will be maintained. As will the kvg namespace attributes. However, inside id attributes, hvg: will be used as a prefix instead of kvg:, *except* if the file is absolutely identical with KanjiVG (i.e. it has been copied over without changing anything). This is to ensure that both files could be used in the same document. This also means when using a KanjiVG variant as the default for HanziVG, the filename as well as all ids and the id prefixes must be renamed!

Speaking of variants: The handwriting form should be preferred (xxxxx-Kaisho in KanjiVG), but always check against other dictionaries for the most common form. After all, stroke order is mainly useful for learning handwriting. ;-)

## Sources

* KanjiVG http://kanjivg.tagaini.net / https://github.com/KanjiVG/kanjivg
  released under [Creative Commons Attribution-Share Alike 3.0](http://creativecommons.org/licenses/by-sa/3.0/)
* AnimHanzi by François Mizessyn http://gooo.free.fr/animHanzi/
  released under [Creative Commons Attribution-Share Alike 3.0](http://creativecommons.org/licenses/by-sa/3.0/)
* Any (online) dictionaries with stroke order diagrams, especially [MDBG](https://www.mdbg.net/chinese/dictionary?cdqchi=), which offers decomposition of characters as a reference.
* Information on character composition and radical position: https://www.saporedicina.com/english/chinese-radicals/

## TODO

There's a lot to do and my available spare time (ok, I admit it - and motivation) for such projects is very fluctuating. So pull requests are of course more than welcome.

* Take a look at all those KanjiVG scripts to see if there's something really useful that we can adopt
* Make a decision on radical position names (see ["A word on radical positions"](#a-word-on-radical-positions) below)
* Visualize character composition in the formatter, similar to mdbg
* Check composition/radical position for existing characters
* Build index files (JSON?) for radical usage (characters including a given radical, etc.)
* KanjiVG

  1. Write scripts to make it easier to check which Kanji can be used
  2. Verify and move Kanji files to /hanzi, making adaptions where necessary
  3. Find out what KanjiVG's /kanji_mismatch directory is all about and whether those files are of any use for this project
* AnimHanzi

  1. Collect all AnimHanzi files, verify and move them to /hanzi, completing meta information where necessary
  2. Verify the AnimHanzi files, make adaptions where needed. Component groups seem not to be as complete as for the KanjiVG files, and there are some other errors regarding stroke count or order, so: *Don't just copy the files over, **do** verify and correct them if necessary!* And don't forget to change the ids (not the attributes) to :hvg (the format.html tool will do that automatically)!
* Don't forget to add documantation so that this ends up more maintainable by volunteers than KanjiVG ;)

See status.php to get startet and klick on any of the listed characters. Or see the status by HSK level in status_hsk.php.
[The HSK level status page is also available online here](https://connum.github.io/hanzivg/status_hsk.html)

### HSK1-6 characters known to be different from KanjiVG but not included in animHanzi:
-

## How to create a new character

You should check out the repository to a (local) server where you can run the PHP scripts.
You can use *status_hsk.php* or *status.php* and click on a character that is not yet done (i.e. is not green).
This will bring you to *compare.php* for the selected character.

Alternatively, the static version of the HSK status page at https://connum.github.io/hanzivg/status_hsk.html will lead you to the *format.html* for each character, or download the template for missing files respectively.

### preparation

You should now be on the *compare.php* page for a selected character (or on *format.html* via the static HSK status page).

1. For files from **KanjiVG**, click on the KanjiVG link to open the character in *format.html* (if not already opened via the static status page)
   * if there are no validation errors logged and all the metadata (radical, groups, ...) seems fine, you can copy the file to HanziVG as-it-is, using the lik "copy to HanziVG" below the character on compare.php
   * otherwise, fix any issues (including any that can't be auto-fixed, loading the file into format.html again afterwards) and proceed with the section "[adding metadata and finalizing](#adding-metadata-and-finalizing)" below
2. For files from **AnimHanzi**, click on the AnimHanzi link to open the character in *format.html* (if not already opened via the static status page)
   * fix any issues (including any that can't be auto-fixed, loading the file into format.html again afterwards) and proceed with the section "[adding metadata and finalizing](#adding-metadata-and-finalizing)" below
3. For files that need to be **created from-scratch**, click the link "save template" to download an SVG template and open it in your favoured SVG editor. Proceed with the section "[editing the template](#editing-the-template)" below.
   
### editing the template
**(only when creating from-scratch or needing to fix/change strokes in an SVG)**

1. The orange background layer uses the font [CNstrokeorder](http://rtega.be/chmn/index.php?subpage=68). Please try to use this font, and if it doesn't contain the character, use a similar handwritten-looking font instead, trying to match the same character size. This layer is only used as a template for drawing upon and can be deleted before saving.
2. Use the bezier tool to draw the lines. Use the correct stroke direction (important!) and order (will save time later because you don't have to rearrange them). You CAN use a stroke width of 3px and round joins and caps in order to see what the final result will look like, but you don't have to. The styles will be corrected later anyway.
3. Copy and paste the number that is placed as a reference on the top outside of the viewbox. Again, if you do this in the correct order of the numbers, you won't have to spend much time to correct the order later.
4. Delete the reference number and stroke as well es the orange template character.
5. Make sure that all strokes are in the stroke group and all numbers are in the number group!
6. Save the file with the correct file name (unicode of the char as 5 digit hex number, padded with 0 if necessary), e.g. *09547.svg*. If you only want to contribute the stroke order for this char without the grouping/radical information, that's totally fine! Just save it in the */hanzi_wip* folder with .raw.svg as the extension, e.g. *09547.raw.svg* and add it to the list inside the *README.md* in that folder. Create a pull request! Otherwise, proceed with the section "[adding metadata and finalizing](#adding-metadata-and-finalizing)" below

## adding metadata and finalizing

1. Open *format.html* in your browser and drag&drop your file into the browser window if you haven't already opened a character by clicking on it on a status page
2. You will see a tree structure of the strokes and numbers and you can add new groups and meta information. Try to make the information as complete as possible. You can also change the order of numbers and strokes via drag&drop. Make sure that the order of strokes and numbers is correct. You can hover over the strokes/numbers in the tree structure to have them highlighted as a visual aid in the preview, and vice versa.
3. compare.php offers several links on top that open resources directly for the displayed character, to cross-check stroke order (sometimes one source differs from the others) and radicals. MDBG is especially helpful for the character deconstruction
4. The formatter will try to find and fix any issues with the file by itself. Not all issues can by fixed automatically, though. Please make sure to run the tests again before finally exporting the file.
5. Then you can hit the **Export** button and save the new file to the */hanzi* folder. Delete the raw file from the */hanzi_wip* if you created it or got it from there, also removing it from the README in that folder if applicable.
6. run test.php to make sure again that there's not anything wrong with your created char or any others, and if there is, please try to fix it. This will also delete any residue files left from copying over from the KanjiVG or AnimHanzi folders.
7. Create a pull request!

## A word on radical positions

We have to make a decision on whether to use the Japanese names for the radical positions (nyo, tare, kamae) from KanjiVG, Chinese names (see https://www.saporedicina.com/english/chinese-radicals/), or English names. I tend dowards the latter, as we already have left/right and top/bottom, and we could also differentiate outside/inside for the different components. On the other hand, we'd loose compatibility to KanjiVG in that regard. Input welcome!

Here's the meaning of the currently used Japanese names:
* Tare: to the left and top, e.g. 厂 or 广
* Nyo: to the left and bottom, e.g. 辶 (it seems that Chinese uses left/right for this, but I need to look into this or someone with more expertise)
* Kamae: enclosing, e.g. 匚 or 囗 (not sure about the different variants, though)

# Licence

HanziVG is licenced under [Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)](http://creativecommons.org/licenses/by-sa/3.0/).
