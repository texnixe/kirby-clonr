The Clonr Kirby field allows you to copy a single page in the panel. It does not copy any subpages or files.

## Installation

Put the plugin into `/site/plugins`; create the plugins folder if it does not exist yet.

Your structure should then look like this:

```yaml
site/
  fields/
    clonr/
      assets/
        clonr.php
```

## In your blueprint

```yaml
fields:
  clonr:
    type: clonr
```

It's probably best to put this field before any other fields at the top of the form (or at the bottom).

You can provide a placeholder text and a buttontext. The examples above are the default settings.

This will create a button in your Panel form.

## Options:

### placeholder

Change the default placeholder text for the input field.

```yaml
fields:
  clonr:
    type: clonr
    placeholder: Some text
```

### buttontext

Change the default text of the clone button.

```yaml
fields:
  clonr:
    type: clonr
    buttontext: Clone page
```


## Usage

1. Click on the "Clone Page" button => an input field is shown.
2. Enter the title of the new page into the input field and press `ENTER`.
3. If all is well and the page does not exist yet, the new page is created and you are redirected to the new page.


## Notes

- In a multi-lingual installation, you should always enter the title of the default language, because the UID will be generated from the title of the page
- In a multi-lingual installation, the title entered into the input field will be used for all languages
- If you use the `URL-key` field in multi-lingual installations, make sure to change the value of this field in your new pages to prevent errors
- The new page is invisible by default

## Author

Sonja Broda sonja@texniq.de

## Feedback/issues

Please create an issue.
