# What the Hanzi? (An introduction)

HanziVG aims to become to Chinese (Traditonal and Simplified) Hanzi characters what [KanjiVG](https://github.com/KanjiVG/kanjivg) is to Japanese Kanji: A colllection of SVG stroke order files that also incorporates some meta information like radicals / character components. In fact, the project will indeed be heavily based on KanjiVG, as many characters can be used without or with little alteration. It will also make use of the great work by François Mizessyn at [AnimHanzi](http://gooo.free.fr/animHanzi/), who created all characters of the HSK1-3 characters and some more.

## KanjiVG compatibility

The SVGs will make use of the kvg namespace defined by KanjiVG. But the structure of this project will be completely different. The reason for this is that KanjiVG is not really well documented (the readme talks about an SVG and XML directory, but that structure seems to have been changed) and being no expert in Python, which all the build and maintenance scripts of KanjiVG are written in, left me a bit overwhelmed.

To get started, HanziVG will use PHP scripts, but I'll probably switch to node/npm as soon as I feel more comfortable using it for a from-scratch project.

## Traditional vs Simplified characters

I will first start with simplified characters, because that's what I currently need while learning Mandarin.
You can read a great (yet short and easy to understand!) article about Simplified and Traditional characters and the Han unification in Unicode here: https://r12a.github.io/scripts/chinese/
But I definitely want this to be usable for traditional Hanzi just the same. So just like KanjiVG has variants of the same character as different files, so will HanziVG. 

# Project structure and work process

The /kanji directory holds all the KanjiVG files as of [1eaef89b17e088f14a13cbb7091607b2ba0530fb](https://github.com/KanjiVG/kanjivg/commit/1eaef89b17e088f14a13cbb7091607b2ba0530fb) (checked in to HanziVG on 8 June 2018). The /hanzi directory will hold all the new and verified SVG files, the "real" HanziVG files. Files should be moved from /kanji to /hanzi after verification and files that are not re-usable should be deleted from kanji, thus eventually leading to the kanji directory being empty and deleted (well, that will take a while...). New files MUST be added to /hanzi, not /kanji. In the meantime, any script/software or whatever using HanziVG can use the Kanji as a fallback - first looking for the file(s) in /hanzi, then falling back to /kanji.

The same appllies to the /animhanzi folder - it currently contains the HSK1-3 sets as provided on the website. I have contacted François regarding the rest, but not yet heard back from him. Those could also be extracted from the demo on the website, but they are served via a PHP script and are missing all the group/radical information.

The file naming convention (the character's unicode encoding in hexadecimal) will be maintained.

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
* Make an adapted version of the [kanji-colorize](https://github.com/cayennes/kanji-colorize) Anki addon
* Don't forget to add documantation so that this ends up more maintainable by volunteers than KanjiVG ;)

# Licence

HanziVG is licenced under [Creative Commons Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)](http://creativecommons.org/licenses/by-sa/3.0/).