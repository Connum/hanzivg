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
* Any (online) dictionaries with stroke order diagrams

## TODO

There's a lot to do and my available spare time (ok, I admit it - and motivation) for such projects is very fluctuating. So pull requests are of course more than welcome.

* Take a look at all those KanjiVG scripts to see if there's something really useful that we can adopt
* KanjiVG

  1. Write scripts to make it easier to check which Kanji can be used
  2. Verify and move Kanji files to /hanzi, making adaptions where necessary
  3. Find out what KanjiVG's /kanji_mismatch directory is all about and whether those files are of any use for this project
* AnimHanzi

  1. Collect all AnimHanzi files, verify and move them to /hanzi, completing meta information where necessary
  2. Verify the AnimHanzi files, make adaptions where needed (component groups seem not to be as complete as for the KanjiVG files)
     ~~**Be careful:** Some files are not in the ZIP file although they are different from the KanjiVG file and even though they do show the correction in the AnimHanzi demo! For example: 有 has 1st and 2nd strokes swapped compared to Japanese, but 06709.svg is not included in the ZIP files (should be in the HSK1 pack).~~  - this seems to be absolete after he [provided the files](https://github.com/parsimonhi/animHanzi/). But still: *Don't just copy the files over, **do** verify and correct them if necessary!* And don't forget to change the ids (not the attributes) to :hvg!
* Make an adapted version of the [kanji-colorize](https://github.com/cayennes/kanji-colorize) Anki addon
* Don't forget to add documantation so that this ends up more maintainable by volunteers than KanjiVG ;)

### HSK1-6 characters known to be different from KanjiVG but not included in animHanzi:
* 都 - strokes 9+10 should be combined, thus resulting in 10 strokes total for Chinese as opposed to 11 in Japanese

## How to create a new character
1. Open the *template.svg* in your favoured SVG editor
2. Change the orange character of the background layer to the character you want to create. This layer uses the font [CNstrokeorder](http://rtega.be/chmn/index.php?subpage=68). Please try to use this font, and if it doesn't contain the character, use a similiar handwritten-looking font instead, trying to match the same character size. This layer is only used as a template for drawing upon and can be deleted before saving.
3. Use the bezier tool to draw the lines. Use the correct stroke direction (important!) and order (will save time later because you don't have to rearrange them). You CAN use a stroke width of 3px and round joins and caps in order to see what the final result will look like, but you don't have to. The styles will be corrected later anyway.
4. Copy and paste the number that is placed as a reference on the top outside of the viewbox. Again, if you do this in the correct order of the numbers, you won't have to spend much time to correct the order later.
5. Delete the reference number and stroke as well es the orange template character.
6. Save the file with the correct file name (unicode of the char as 5 digit hex number, padded with 0 if necessary), e.g. *09547.svg*. If you only want to contribute the stroke order for this char without the grouping/radical information, that's totally fine! Just save it in the */hanzi_wip* folder with .raw.svg as the extension, e.g. *09547.raw.svg* and add it to the list inside the *README.md* in that folder. Create a pull request! Otherwise, proceed:

7. Open *format.html* in your browser (modern browsers like Chrome and Firefox are required). Drag and drop your file into the browser window.
8. You will see a tree structure of the strokes and numbers and you can add new groups and meta information. Try to make the information as complete as possible. You can also change the order of numbers and strokes via drag&drop. Make sure that the order of strokes and numbers is correct. You can hover over the strokes/numbers in the tree structure to have them highlighted as a visual aid.
9. Then you can hit the **Export** button and save the new file to the */hanzi* folder. Delete the raw file from the */hanzi_wip* if you created it or got it from there.
10. Create a pull request!

# Licence

HanziVG is licenced under [Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)](http://creativecommons.org/licenses/by-sa/3.0/).