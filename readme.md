# Kirby ZIP plugin

Creates a ZIP archive from a list of files.

## Requirements

You need PHP ZIP module enabled.

## Setup a new project


2. go to the root of your Kirby project :
  ```
  cd path/to/your-project
  ```

2. clone this repo :
  ```
  git submodule add https://github.com/julien-gargot/kirby-plugin-zip.git site/plugins/zip
  ```

## Configure

You can set different defaults parameters in your `config.php`.
Like URL to download the ZIPs with `c::set('zip.download.url', "download/archive")`.
Where to save ZIPs (include trailing slash) `c::set('zip.download.url', "download/archive")` and `c::set('zip.archive.path', "tmp/zip/")`.
Also the ZIP filename with `c::set('zip.default.filename', "archive")`.

If you need individual case by ZIP, just edit the plugin ;).

## General infos

- I’m not a specialist about ZIP and PHP optimisation. If a lot of users start a ZIP generation at the same time, it will probably overload your server. Any advice appreciated.
- ZIP can be conserved or not. Your call. Edit the plugin. *cf. line 44*
- If user close the connection before the ZIP is generated, it stops the process, like a classic page displaying process.
- Filenames inside the archive are set `line 85`.

### TODO

- [ ] Write a better description and readme
- [ ] Create a kirby tag. Something like `(zip: file-1.ext, file-2.ext, file-3.ext zipname: my-archive)`.
- [ ] Prevent multiple ZIP generation and server overload.
