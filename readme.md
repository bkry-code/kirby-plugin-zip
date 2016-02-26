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

You can set different defaults parameters in your `config.php` :
- the route URL to download the ZIPs : `c::set('zip.download.url', "download/archive")`,
- where to save ZIPs (include trailing slash) : `c::set('zip.archive.path', "tmp/zip/")`,
- also the ZIP filename : `c::set('zip.default.filename', "archive")`.

If you need individual case by ZIP, just edit the plugin ;).

## Use

Plugin needs a JSON object formatted like this:

```
{
  page-hash : filename.ext,
  page-hash : filename.ext,
  …
}
```

For now, plugin gets files by doing a `$site->index()->findBy('hash', page-hash)` then `$result_page->file(filename.ext)`.

Use POST to the send the JSON to the `zip.download.url`. Default URL is `download/archive`.

## General infos

- :exclamation: I’m not a specialist about ZIP and PHP optimisation. If a lot of users start a ZIP generation at the same time, it will probably overload your server. Any advice appreciated.
- ZIP can be conserved or not. Your call. Edit the plugin. *cf. line 44*
- If user close the connection before the ZIP is generated, it continue the process on your server and will save it, not matter your settings.
- Filenames inside the archive are set `line 85`.

### TODO

- [ ] Write a better description and readme
- [ ] Create a kirby tag. Something like `(zip: file-1.ext, file-2.ext, file-3.ext zipname: my-archive)`.
- [ ] Prevent multiple ZIP generation and server overload.
