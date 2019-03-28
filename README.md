# Candela Outcomes

A plugin that adds an Outcomes meta field to courseware edit page.

## Synopsis

[Pressbooks](https://github.com/pressbooks/pressbooks) is a plugin that turns your Wordpress multisite installation into a book publishing platform.
Candela Outcomes adds an Outcomes meta field for coursework.

## Installation

### Composer

1.  From the root wordpress installation, add the following to `composer.json` (replacing `v1.0.0` with desired version):

    ```
    {
      "repositories": [
        {
          "type": "vcs",
            "url": "https://github.com/lumenlearning/candela-outcomes"
        }
      ],
      "require": {
        "lumenlearning/candela-outcomes": "v1.0.0"
      }
    }
    ```

1.  Run `composer install` in the terminal

### Manually

1.  Download or clone Candela Outcomes into your wordpress multisite plugins directory: `/path/to/wordpress/wp-content/plugins`
1.  Log in to your Wordpress multisite instance and navigate to `Network Admin > Plugins` and activate the Candela Outcomes plugin

## Unit Testing and Code Standards

Unit tests and code standards are run by simply running `composer test`.
If you would just like to check code standards,
you can run `composer standards`.
