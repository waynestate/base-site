const validator = require("html-validator");
const request = require("request-promise");
const fs = require("fs");
const file = __dirname + "/../../styleguide/menu.json";
const base_domain = "https://base.wayne.local";
let urls = [];

const validator_options = {
    format: "text",
    ignore: ["Warning: This document appears to be written in Lorem ipsum"]
};

const request_options = {
    rejectUnauthorized: false
};

/**
 * Validate all menu items in the styleguide
 */
fs.readFile(file, "utf8", (err, data) => {
    if (err) {
        errorOut(err);
    }

    // Get all URLs in styleguide
    urls = pullUrls(Object.values(JSON.parse(data)));

    urls.forEach(url => {
        request_options.uri = `${base_domain}${url}`;

        request(request_options)
            .then(function(htmlString) {
                validator_options.data = htmlString;

                validator(validator_options)
                    .then(data => {
                        if (data.includes("The document validates")) {
                            process.stdout.write(colorize(92, "."));
                        } else {
                            process.stdout.write("\n\n" + colorize(91, "F "));
                            console.log(url, "\n", data);
                        }
                    })
                    .catch(errorOut);
            })
            .catch(errorOut);
    });
});

/**
 * Parse URLs from menus.json
 *
 * @param {array} entries
 */
const pullUrls = entries => {
    let urls = [];

    const parseElements = items => {
        items.forEach(element => {
            // Only push in unique URLs
            if (urls.indexOf(element.relative_url) === -1) {
                urls.push(element.relative_url);
            }

            // Recurse through submenu items
            const submenu_items = Object.values(element.submenu);
            if (submenu_items.length > 0) {
                parseElements(submenu_items);
            }
        });
    };

    parseElements(entries);

    return urls;
};

/**
 * Display error
 *
 * @param {string} err
 */
const errorOut = err => {
    console.error(err);
    process.exit(1);
};

/**
 * Color output
 *
 * @param {int} color 91 - red, 92 - green
 * @param {string} output
 */
const colorize = (color, output) => {
    return ["\033[", color, "m", output, "\033[0m"].join("");
};
