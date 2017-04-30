# Site Builder
Site Builder is an easy-to-use tool to create static one-page websites from Markdown.

### Quickstart
Download the latest release from GitHub ([https://github.com/leveled-up/site-builder/releases/latest](https://github.com/leveled-up/site-builder/releases/latest)) and unpack it into your webserver's public directory (e.g. `/var/www/html/`). You should see the same page as you can see on [https://site-builder.leveled-up.com](https://site-builder.leveled-up.com/). A demo site is available at [https://goo.gl/Lmh43b](https://goo.gl/Lmh43b).

### Tutorial
In this tutorial I'll show you how to customize Site Builder to your needs. 

**1. Change Configuration**

The configuration of Site Builder is located in `config.inc.php`. There are lots of options: two!

```php
$config["templates"]["base_directory"] = "templates";
$config["templates"]["list_file"] = "templates.json";
```

The option `base_directory` defines the directory where templates are located. This directory is relative to the directory of `compile.php` and `index.php`.

The option `list_file` defines the name of the JSON file in which all templates are listed (3.). This file is located in the `base_directory`.

**2. Creating Templates**

Just create an HTML page with demo content and replace:

* the website's title with `%TITLE`,
* the website's introduction (description) with `%DESCRIPTION` (optional),
* the website's content with `%CONTENT`
* and the year in the copyright note with `%YEAR`.

After you created the template as shown above, you need to register it in `templates.json`.

**3. Working with "templates.json"**

For templates created as shown in 2. to show up on `index.php`, you'll need to register them in `templates.json`. In this file there is a `templates` node with sub-nodes for each template. The name of each sub-node must be a unique numeric value (e.g. `002`, `003`,...). This sub-node is an array of the template's filename `[0]` and its title `[1]` (shown on `index.php`).

The default `templates.json` file is shown below:

```json
{
    "templates" : {
        "001" : [  "cayman.html", "Cayman Theme" ]
    }
}
```

### License
Site Builder is licensed as shown in [LICENSE.md](https://github.com/leveled-up/site-builder/blob/master/LICENSE.md).

### Contact Me
If there are any questions feel free to contact me via Twitter Direct Message [@YujayAnthony](https://twitter.com/YujayAnthony).
